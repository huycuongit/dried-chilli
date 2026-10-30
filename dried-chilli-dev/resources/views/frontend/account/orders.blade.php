@extends('frontend.account.layout')

@section('title', 'Order History')

@section('account-content')
    <h2 class="serif-title">Order History</h2>
    
    <div class="account-card" style="margin-top: 2rem;">
        <div class="card-body">
            @if(isset($orders) && $orders->isEmpty())
                <p class="empty-state">You have not placed any orders yet.</p>
                <a href="/shop" class="btn-primary" style="margin-top: 1rem;">Start Shopping</a>
            @else
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('account.order_detail', $order->id) }}" class="btn-outline-small">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 2rem;">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
