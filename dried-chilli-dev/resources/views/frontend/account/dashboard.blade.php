@extends('frontend.account.layout')

@section('title', 'Dashboard')

@section('account-content')
    <h2 class="serif-title">Dashboard</h2>
    <p class="welcome-text">Welcome back, <strong>{{ $user->name ?? 'Guest' }}</strong>! ({{ $user->email }})</p>
    
    <div class="account-card">
        <div class="card-header">Recent Orders</div>
        <div class="card-body">
            @if(isset($recentOrders) && $recentOrders->isEmpty())
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
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td><a href="{{ route('account.order_detail', $order->id) }}" class="btn-outline-small">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
