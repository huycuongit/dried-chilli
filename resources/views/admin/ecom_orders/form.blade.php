@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">Edit Order #{{ $data->id }}</h5>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Customer Info</h6>
                        <p>User ID: {{ $data->user_id }}</p>
                        <p>Total: ${{ number_format($data->total_amount, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Order Items</h6>
                        <ul>
                            @foreach($data->items as $item)
                                <li>Product #{{ $item->product_id }} - Qty: {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <form action="{{ route('admin.ecom_orders.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="status">Order Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $data->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ $data->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update Status</button>
                        <a href="{{ route('admin.ecom_orders.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
