@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action active">Order History</a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">Address Book</a>
                <a href="#" class="list-group-item list-group-item-action">Account Details</a>
                <a href="#" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Order Details #{{ $order->id }}</h2>
                <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary">Back to Orders</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light"><strong>Order Summary</strong></div>
                        <div class="card-body">
                            <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                            <p>
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'canceled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light"><strong>Shipping & Payment</strong></div>
                        <div class="card-body">
                            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                            <p>
                                <strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Shipping Address:</strong><br> {{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light"><strong>Items Ordered</strong></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-bottom">
                                    <td class="ps-3">
                                        <strong>{{ $item->product->name }}</strong>
                                        @if($item->variant)
                                            <div class="text-muted small">Variant: {{ $item->variant->sku ?? 'N/A' }}</div>
                                        @endif
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end pe-3">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end ps-3"><strong>Grand Total:</strong></td>
                                    <td class="text-end pe-3"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
