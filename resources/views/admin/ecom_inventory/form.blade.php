@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">Edit Inventory for: {{ $data->product->name ?? 'Unknown' }} {{ $data->variant ? ' - ' . $data->variant->sku : '' }}</h5>
            <form action="{{ route('admin.ecom_inventory.update', $data->id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="quantity">Available Quantity (Stock)</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $data->quantity) }}" required min="0" />
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="low_stock_threshold">Low Stock Alert Threshold</label>
                        <input type="number" id="low_stock_threshold" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $data->low_stock_threshold) }}" required min="0" />
                        <small class="text-muted">A badge will turn red if stock is below this amount.</small>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Update Stock</button>
                    <a href="{{ route('admin.ecom_inventory.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
