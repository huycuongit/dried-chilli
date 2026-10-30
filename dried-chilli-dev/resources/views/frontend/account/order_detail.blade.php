@extends('frontend.account.layout')

@section('title', 'Order Details')

@section('account-content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="serif-title" style="margin-bottom: 0;">Order #{{ $order->id }}</h2>
        <a href="{{ route('account.orders') }}" class="btn-outline-small">Back to Orders</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div class="account-card" style="margin-bottom: 0;">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                <p>
                    <strong>Status:</strong> 
                    <span class="status-badge {{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>
        
        <div class="account-card" style="margin-bottom: 0;">
            <div class="card-header">Shipping & Payment</div>
            <div class="card-body">
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method ?? 'N/A') }}</p>
                <p>
                    <strong>Payment Status:</strong> 
                    <span class="status-badge {{ $order->payment_status == 'paid' ? 'delivered' : 'pending' }}">
                        {{ ucfirst($order->payment_status ?? 'unpaid') }}
                    </span>
                </p>
                <p><strong>Shipping Address:</strong><br> {{ $order->shipping_address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="account-card">
        <div class="card-header">Items Ordered</div>
        <div class="card-body" style="padding: 0;">
            <table class="account-table">
                <thead>
                    <tr>
                        <th style="padding-left: 2rem;">Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th style="text-align: right; padding-right: 2rem;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="padding-left: 2rem;">
                            <strong>{{ optional($item->product)->name ?? 'Unknown Product' }}</strong>
                            @if($item->variant)
                                <div style="color: #888; font-size: 0.85rem; margin-top: 0.3rem;">Variant: {{ $item->variant->sku ?? 'N/A' }}</div>
                            @endif
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right; padding-right: 2rem;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: rgba(0,0,0,0.02);">
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 1.5rem 1rem; border-top: 2px solid rgba(0,0,0,0.1);"><strong>Grand Total:</strong></td>
                        <td style="text-align: right; padding: 1.5rem 2rem 1.5rem 1rem; border-top: 2px solid rgba(0,0,0,0.1);"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
