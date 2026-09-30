@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">Edit Product</h5>
            <form action="{{ route('admin.ecom_products.update', $data->id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Product Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $data->name) }}" required />
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="price">Price ($)</label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $data->price) }}" required />
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="sale_price">Sale Price ($) (Optional)</label>
                        <input type="number" step="0.01" id="sale_price" name="sale_price" class="form-control" value="{{ old('sale_price', $data->sale_price) }}" />
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller" value="1" {{ old('is_best_seller', $data->is_best_seller) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_best_seller">Set as Best Seller</label>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Update Product</button>
                    <a href="{{ route('admin.ecom_products.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
