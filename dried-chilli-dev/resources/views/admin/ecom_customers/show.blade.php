@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header">Customer Profile #{{ $customer->id }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Personal Info</h6>
                        <ul class="list-unstyled">
                            <li><strong>Name:</strong> {{ $customer->name }}</li>
                            <li><strong>Email:</strong> {{ $customer->email }}</li>
                            <li><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</li>
                            <li><strong>Joined:</strong> {{ $customer->created_at->format('M d, Y') }}</li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <h6>Order History ({{ $orders->count() }} Orders)</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            @if($order->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($order->payment_status) }}</td>
                                        <td>
                                            <a href="{{ route('admin.ecom_orders.edit', $order->id) }}" class="btn btn-sm btn-primary">View Order</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found for this customer.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.ecom_customers.index') }}" class="btn btn-secondary">Back to Customers</a>
                </div>
            </div>
        </div>
    </div>
@endsection
