@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">{{ $data->id ? 'Edit Coupon' : 'Create Coupon' }}</h5>
            <form action="{{ $data->id ? route('admin.ecom_coupons.update', $data->id) : route('admin.ecom_coupons.store') }}" method="POST" class="card-body">
                @csrf
                @if($data->id)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="code">Coupon Code</label>
                        <input type="text" id="code" name="code" class="form-control" style="text-transform: uppercase;" value="{{ old('code', $data->code) }}" required />
                        <small class="text-muted">E.g., SUMMER10, WELCOME20</small>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="type">Discount Type</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="percent" {{ old('type', $data->type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('type', $data->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="value">Discount Value</label>
                        <input type="number" step="0.01" id="value" name="value" class="form-control" value="{{ old('value', $data->value) }}" required />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="min_order_amount">Min Order Amount ($) (Optional)</label>
                        <input type="number" step="0.01" id="min_order_amount" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $data->min_order_amount) }}" />
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label" for="max_discount">Max Discount ($) (For % only)</label>
                        <input type="number" step="0.01" id="max_discount" name="max_discount" class="form-control" value="{{ old('max_discount', $data->max_discount) }}" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="usage_limit">Total Usage Limit (Optional)</label>
                        <input type="number" id="usage_limit" name="usage_limit" class="form-control" value="{{ old('usage_limit', $data->usage_limit) }}" placeholder="Leave blank for unlimited" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="expires_at">Expiry Date (Optional)</label>
                        <input type="datetime-local" id="expires_at" name="expires_at" class="form-control" value="{{ old('expires_at', $data->expires_at ? date('Y-m-d\TH:i', strtotime($data->expires_at)) : '') }}" />
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $data->is_active ?? 1) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">Active (Can be used by customers)</label>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ $data->id ? 'Update' : 'Create' }} Coupon</button>
                    <a href="{{ route('admin.ecom_coupons.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
