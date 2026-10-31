<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\PaymentAttempt;
use App\Support\Payments\RefundService;
use DataTables;

class EcomOrderController extends Controller
{
    public function index()
    {
        $pendingRefunds = PaymentAttempt::where('status', PaymentAttempt::REFUND_PENDING)
            ->orderByDesc('updated_at')->paginate(25, ['*'], 'refund_page');
        return view('admin.ecom_orders.index', compact('pendingRefunds'));
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::query();
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('id', $request->keyword);
            }
            return DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_orders.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                            </div>';
                })
                ->editColumn('total_amount', function($row) { return '$' . number_format($row->total_amount, 2); })
                ->editColumn('status', function($row) { 
                    $color = match($row->status) {
                        'pending' => 'warning',
                        'paid', 'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-'.$color.'">'.ucfirst($row->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $data = Order::with('items')->findOrFail($id);
        $paymentAttempt = PaymentAttempt::where('order_id', $data->id)->first();
        return view('admin.ecom_orders.form', compact('data', 'paymentAttempt'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['status' => 'required|in:pending,paid,processing,shipped,delivered,completed,cancelled']);
        $refundId = DB::transaction(function () use ($id, $data) {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);
            $refundId = null;
            if ($order->status === 'cancelled' && $data['status'] !== 'cancelled') {
                abort(422, 'A cancelled order cannot be reopened.');
            }
            if (in_array($order->status, ['shipped', 'delivered', 'completed'], true) &&
                in_array($data['status'], ['pending', 'paid', 'processing', 'cancelled'], true)) {
                abort(422, 'Shipped or completed orders cannot be moved back or cancelled here. Handle returns and refunds separately.');
            }
            if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') {
                if ($order->payment_status === 'paid') {
                    $attempt = PaymentAttempt::where('order_id', $order->id)->lockForUpdate()->first();
                    if (!$attempt || !$attempt->provider_payment_id || ($attempt->provider === PaymentAttempt::PAYPAL && !$attempt->provider_capture_id)) {
                        abort(422, 'This paid order needs a manual refund before it can be cancelled.');
                    }
                    if ($attempt->status !== PaymentAttempt::REFUNDED) {
                        $attempt->update(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'order_cancelled']);
                        $refundId = $attempt->id;
                    }
                }
                foreach ($order->items as $item) {
                    if (!$item->product_id) continue;
                    $inventory = Inventory::where('product_id', $item->product_id)
                        ->where('variant_id', $item->variant_id)->lockForUpdate()->first();
                    if ($inventory) $inventory->increment('quantity', $item->quantity);
                }
            }
            $order->update(['status' => $data['status']]);
            return $refundId;
        });
        if ($refundId) {
            app(RefundService::class)->retry($refundId);
            $message = PaymentAttempt::whereKey($refundId)->value('status') === PaymentAttempt::REFUNDED
                ? 'Order cancelled and payment refunded.'
                : 'Order cancelled. The payment refund is pending; check its status before promising completion.';
            return redirect()->route('admin.ecom_orders.index')->with('success', $message);
        }
        return redirect()->route('admin.ecom_orders.index')->with('success', 'Order status updated successfully.');
    }
}
