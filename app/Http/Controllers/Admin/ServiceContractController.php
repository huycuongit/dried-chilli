<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceContractRequest;
use App\Models\ServiceContract;
use App\Support\SystemSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ServiceContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = ServiceContract::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('contract_number', 'like', "%{$keyword}%")
                        ->orWhere('customer_name', 'like', "%{$keyword}%")
                        ->orWhere('customer_company', 'like', "%{$keyword}%")
                        ->orWhere('customer_email', 'like', "%{$keyword}%");
                });
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        return view('admin.contracts.create', ['services' => \App\Models\Service::active()->orderBy('position')->get()]);
    }

    public function store(ServiceContractRequest $request, SystemSettings $settings)
    {
        $contract = DB::transaction(function () use ($request, $settings) {
            if ($request->boolean('quick_create')) {
                $services = \App\Models\Service::active()->whereIn('id', $request->validated()['service_ids'])->get();
                if ($services->count() !== count($request->validated()['service_ids'])) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['service_ids' => 'Có dịch vụ không còn hoạt động. Vui lòng chọn lại.']);
                }
                try {
                    $selection = \App\Support\QuickContractItems::build($services->toArray());
                } catch (\InvalidArgumentException $exception) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['service_ids' => $exception->getMessage()]);
                }
                $items = $selection['items'];
                $data = [
                    'customer_name' => $request->validated()['customer_name'],
                    'customer_email' => $request->validated()['customer_email'] ?? '',
                    'contract_number' => null, 'locale' => 'vi', 'currency' => 'VND', 'tax_rate' => 0,
                    'effective_date' => now(), 'title' => config('website-contract.title'),
                    'website_details' => $this->templateDefaults($settings),
                    'terms' => config('website-contract.terms'), 'payment_terms' => config('website-contract.payment_terms'),
                    'scope_summary' => implode("\n", array_column($items, 'name')),
                    'subtotal' => $selection['total'],
                    'tax_amount' => 0,
                ];
                $data['total'] = $data['subtotal'];
                $data += $this->providerData($settings);
            } else {
                $data = $this->contractData($request, $settings);
                $items = $request->input('items', []);
            }
            $data['created_by'] = Auth::id();
            $data['public_token'] = Str::random(64);
            $data['contract_number'] = $data['contract_number'] ?: $this->nextContractNumber();
            $data['status'] = 'draft';
            $contract = ServiceContract::create($data);
            $this->syncItems($contract, $items);
            return $contract;
        });

        return redirect()->route('admin.contracts.edit', $contract->id)
            ->with('success', 'Đã tạo hợp đồng. Bạn có thể kiểm tra và gửi link cho khách hàng.');
    }

    public function edit($id)
    {
        $contract = ServiceContract::with('items')->findOrFail($id);
        return view('admin.contracts.form', compact('contract'));
    }

    public function update(ServiceContractRequest $request, $id, SystemSettings $settings)
    {
        $contract = ServiceContract::with('items')->findOrFail($id);
        abort_if($contract->isSigned(), 409, 'Hợp đồng đã ký không thể chỉnh sửa.');

        DB::transaction(function () use ($request, $settings, $contract) {
            $contract = ServiceContract::whereKey($contract->id)->lockForUpdate()->firstOrFail();
            abort_if($contract->isSigned(), 409, 'Hợp đồng đã ký không thể chỉnh sửa.');
            $contract->update($this->contractData($request, $settings, $contract));
            $this->syncItems($contract, $request->input('items', []));
        });

        return back()->with('success', 'Đã cập nhật hợp đồng.');
    }

    public function send($id)
    {
        $contract = ServiceContract::with('items')->findOrFail($id);
        abort_if($contract->isSigned(), 409, 'Hợp đồng đã được ký.');

        abort_unless($contract->customer_email, 422, 'Hãy bổ sung email hoặc sao chép link gửi cho khách.');
        abort_if($contract->hasUnfilledTerms(), 422, 'Vui lòng hoàn thiện thông tin điều khoản và phụ lục trước khi gửi.');

        $contract->forceFill([
            'status' => 'sent',
            'sent_at' => now(),
        ])->save();

        $mailSent = true;
        try {
            Mail::send('emails.contract-invitation', compact('contract'), function ($message) use ($contract) {
                $message->to($contract->customer_email, $contract->customer_name)
                    ->subject("Service agreement {$contract->contract_number} from {$contract->provider_name}");
            });
        } catch (Throwable $exception) {
            report($exception);
            $mailSent = false;
        }

        $message = $mailSent
            ? 'Đã gửi email hợp đồng cho khách hàng.'
            : 'Đã tạo link ký nhưng chưa gửi được email. Hãy sao chép link và gửi thủ công.';

        return back()->with($mailSent ? 'success' : 'error', $message);
    }

    public function destroy($id)
    {
        $contract = ServiceContract::findOrFail($id);
        abort_if($contract->isSigned(), 409, 'Không thể xóa hợp đồng đã ký.');
        $contract->delete();

        return redirect()->route('admin.contracts.index')->with('success', 'Đã xóa hợp đồng.');
    }

    private function contractData(ServiceContractRequest $request, SystemSettings $settings, ?ServiceContract $existing = null): array
    {
        $data = $request->safe()->except('items');
        $data['customer_email'] = $data['customer_email'] ?? '';
        if (isset($data['website_details'])) {
            $keys = array_merge(...array_values(array_map('array_keys', config('website-contract.fields'))));
            $data['website_details'] = array_intersect_key($data['website_details'], array_flip($keys));
        }
        $items = collect($request->input('items', []));
        $subtotal = $items->sum(fn ($item) => round((float) $item['quantity'] * (float) $item['unit_price'], 2));
        $taxRate = (float) ($data['tax_rate'] ?? 0);
        $taxAmount = round($subtotal * $taxRate / 100, 2);

        $data['subtotal'] = $subtotal;
        $data['tax_amount'] = $taxAmount;
        $data['total'] = $subtotal + $taxAmount;

        if (!$existing) { $data += $this->providerData($settings); }

        return $data;
    }

    private function templateDefaults(SystemSettings $settings): array
    {
        $details = config('website-contract.defaults', []);
        foreach (config('website-contract.fields') as $fields) {
            foreach ($fields as $key => $label) {
                $details[$key] = $settings->get('contract_default_' . $key, $details[$key] ?? '');
            }
        }
        return $details;
    }

    private function providerData(SystemSettings $settings): array
    {
        return [
            'provider_name' => $settings->get('company_name', 'FEB Digi'),
            'provider_legal_name' => $settings->get('company_legal_name', 'HỘ KINH DOANH FEB DIGI'),
            'provider_tax_id' => $settings->get('company_tax_id'),
            'provider_email' => $settings->get('company_email'),
            'provider_phone' => $settings->get('company_hotline'),
            'provider_address' => $settings->get('company_address'),
        ];
    }

    private function syncItems(ServiceContract $contract, array $items): void
    {
        $contract->items()->delete();
        foreach (array_values($items) as $position => $item) {
            $quantity = (float) $item['quantity'];
            $unitPrice = (float) $item['unit_price'];
            $contract->items()->create([
                'name' => $item['name'],
                'description' => $item['description'] ?? null,
                'quantity' => $quantity,
                'unit' => $item['unit'],
                'unit_price' => $unitPrice,
                'amount' => round($quantity * $unitPrice, 2),
                'position' => $position,
            ]);
        }
    }

    private function nextContractNumber(): string
    {
        $prefix = 'FEB-' . now()->format('Ym') . '-';
        $latest = ServiceContract::where('contract_number', 'like', $prefix . '%')
            ->orderByDesc('contract_number')->value('contract_number');
        $sequence = $latest ? ((int) Str::afterLast($latest, '-') + 1) : 1;
        return $prefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
