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
            <h2>Order History</h2>
            
            <div class="card mt-4">
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="alert alert-info">You have not placed any orders yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
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
                                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'canceled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('account.order_detail', $order->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
