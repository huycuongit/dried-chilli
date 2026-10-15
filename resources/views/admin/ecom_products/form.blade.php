@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">{{ $data->id ? 'Edit Product' : 'Create Product' }}</h5>
            <form action="{{ $data->id ? route('admin.ecom_products.update', $data->id) : route('admin.ecom_products.store') }}" method="POST" class="card-body">
                @csrf
                @if($data->id)
                    @method('PUT')
                @endif
                
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

                    <div class="col-md-3 mt-3">
                        <label class="form-label" for="sale_type">Sale Type</label>
                        <select id="sale_type" name="sale_type" class="form-select">
                            <option value="none" {{ old('sale_type', $data->sale_type) === 'none' ? 'selected' : '' }}>None</option>
                            <option value="daily_flash" {{ old('sale_type', $data->sale_type) === 'daily_flash' ? 'selected' : '' }}>Daily Flash Sale</option>
                            <option value="limited_big" {{ old('sale_type', $data->sale_type) === 'limited_big' ? 'selected' : '' }}>Limited Big Sale</option>
                        </select>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label" for="sale_start_date">Sale Start Date (Optional)</label>
                        <input type="datetime-local" id="sale_start_date" name="sale_start_date" class="form-control" value="{{ old('sale_start_date', $data->sale_start_date ? \Carbon\Carbon::parse($data->sale_start_date)->format('Y-m-d\TH:i') : '') }}" />
                    </div>

                    <div class="col-md-5 mt-3">
                        <label class="form-label" for="sale_end_date">Sale End Date (Optional)</label>
                        <input type="datetime-local" id="sale_end_date" name="sale_end_date" class="form-control" value="{{ old('sale_end_date', $data->sale_end_date ? \Carbon\Carbon::parse($data->sale_end_date)->format('Y-m-d\TH:i') : '') }}" />
                        <small class="text-muted">Required for Flash Sales</small>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label" for="quantity" style="font-weight: bold; color: var(--bs-primary);">Initial Inventory Quantity</label>
                        <input type="number" step="1" min="0" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $data->inventory ? $data->inventory->quantity : 0) }}" />
                        <small class="text-muted">Set the stock quantity for this product. You can manage detailed stock later in the Inventory section.</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $data->description) }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mt-4 d-flex gap-4 flex-wrap">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $data->is_active ?? 1) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">Active (Visible on site)</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller" value="1" {{ old('is_best_seller', $data->is_best_seller) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_best_seller">Set as Best Seller</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_sale" name="is_sale" value="1" {{ old('is_sale', $data->is_sale) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_sale">Is Sale Product</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_limited_sale" name="is_limited_sale" value="1" {{ old('is_limited_sale', $data->is_limited_sale) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_limited_sale">Limited Sale (Show on /sale page)</label>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ $data->id ? 'Update' : 'Create' }} Product</button>
                    <a href="{{ route('admin.ecom_products.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
