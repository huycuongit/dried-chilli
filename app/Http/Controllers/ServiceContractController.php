<?php

namespace App\Http\Controllers;

use App\Models\ServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceContractController extends Controller
{
    public function show(string $token)
    {
        $contract = ServiceContract::with('items')->where('public_token', $token)->firstOrFail();

        if (!$contract->viewed_at) {
            $contract->forceFill(['viewed_at' => now()])->save();
        }

        return response()->view('contracts.show', compact('contract'))
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->header('Cache-Control', 'private, no-store, max-age=0');
    }

    public function sign(Request $request, string $token)
    {
        $request->validate([
            'signature_name' => ['required', 'string', 'max:255'],
            'signature_data' => [
                'required',
                'string',
                'max:3000000',
                'regex:/^data:image\/png;base64,[A-Za-z0-9+\/=]+$/',
                function ($attribute, $value, $fail) {
                    $binary = base64_decode(Str::after($value, 'data:image/png;base64,'), true);

                    if ($binary === false || substr($binary, 0, 8) !== "\x89PNG\r\n\x1a\n") {
                        $fail('Dữ liệu chữ ký không phải là ảnh PNG hợp lệ.');
                    }
                },
            ],
            'signature_consent' => ['accepted'],
        ], [
            'signature_name.required' => 'Vui lòng nhập đầy đủ họ tên người ký.',
            'signature_data.required' => 'Vui lòng ký tên trong khung chữ ký.',
            'signature_data.regex' => 'Dữ liệu chữ ký không hợp lệ.',
            'signature_consent.accepted' => 'Bạn cần xác nhận đồng ý ký hợp đồng điện tử.',
        ]);

        DB::transaction(function () use ($request, $token) {
            $contract = ServiceContract::with('items')
                ->where('public_token', $token)->lockForUpdate()->firstOrFail();

            abort_if($contract->isSigned(), 409, 'Hợp đồng này đã được ký.');
            abort_if($contract->expires_at && $contract->expires_at->copy()->endOfDay()->isPast(), 410, 'Hợp đồng đã hết hạn ký.');

            abort_if($contract->hasUnfilledTerms(), 422, 'Hợp đồng còn thông tin chưa hoàn tất. Vui lòng liên hệ FEB Digi.');

            $payload = [
                'contract' => $contract->only([
                    'website_details', 'locale', 'provider_email', 'provider_phone', 'provider_address',
                    'customer_phone', 'customer_tax_id', 'customer_address',
                    'contract_number', 'title', 'provider_name', 'provider_legal_name',
                    'provider_tax_id', 'customer_name', 'customer_company', 'customer_email',
                    'scope_summary', 'terms', 'payment_terms', 'subtotal', 'tax_rate',
                    'tax_amount', 'total', 'currency', 'effective_date', 'expires_at',
                ]),
                'items' => $contract->items->map->only([
                    'name', 'description', 'quantity', 'unit', 'unit_price', 'amount', 'position',
                ])->values()->all(),
            ];

            $contract->forceFill([
                'status' => 'signed',
                'signed_at' => now(),
                'signature_name' => $request->signature_name,
                'signature_data' => $request->signature_data,
                'signature_consent' => true,
                'signature_ip' => $request->ip(),
                'signature_user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
                'signed_payload_hash' => hash('sha256', json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)),
            ])->save();
        });

        return redirect()->route('contracts.show', $token)->with('signed_success', 'Hợp đồng đã được ký thành công.');
    }
}
