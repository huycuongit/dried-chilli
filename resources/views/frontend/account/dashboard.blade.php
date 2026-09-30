@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Order History</a>
                <a href="#" class="list-group-item list-group-item-action">Address Book</a>
                <a href="#" class="list-group-item list-group-item-action">Account Details</a>
                <a href="#" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h2>My Dashboard</h2>
            <p>Welcome back, <strong>{{ $user->name ?? 'Guest' }}</strong>!</p>
            
            <div class="card mt-4">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                    @if($recentOrders->isEmpty())
                        <p>You have not placed any orders yet.</p>
                    @else
                        <table class="table">
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
                                        <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'canceled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
