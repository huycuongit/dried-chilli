@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">{{ isset($bundle) ? 'Edit Bundle' : 'Create Bundle' }}</h5>
            <form action="{{ isset($bundle) ? route('admin.ecom_bundles.update', $bundle->id) : route('admin.ecom_bundles.store') }}" method="POST" class="card-body">
                @csrf
                @if(isset($bundle)) @method('PUT') @endif
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Bundle Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $bundle->name ?? '') }}" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="price">Bundle Fixed Price ($)</label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $bundle->price ?? '') }}" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control">{{ old('description', $bundle->description ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $bundle->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                
                <h6>Products in Bundle</h6>
                <div id="bundle-items-container">
                    @php 
                        $items = isset($bundle) ? $bundle->items : (old('products') ?? [[]]); 
                    @endphp
                    @foreach($items as $index => $item)
                        <div class="row g-3 bundle-item-row mb-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Select Product</label>
                                <select name="products[{{ $index }}][product_id]" class="form-control" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}" {{ (isset($item['product_id']) && $item['product_id'] == $prod->id) || (isset($item->product_id) && $item->product_id == $prod->id) ? 'selected' : '' }}>{{ $prod->name }} - ${{ $prod->price }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Required Quantity</label>
                                <input type="number" name="products[{{ $index }}][required_quantity]" class="form-control" value="{{ $item['required_quantity'] ?? $item->required_quantity ?? 1 }}" required min="1">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-remove-item"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-info btn-sm mt-2" id="btn-add-item"><i class="ti ti-plus"></i> Add Product to Bundle</button>

                <div class="pt-4 mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Bundle</button>
                    <a href="{{ route('admin.ecom_bundles.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = {{ count($items) }};
        
        document.getElementById('btn-add-item').addEventListener('click', function() {
            const container = document.getElementById('bundle-items-container');
            const newRow = document.querySelector('.bundle-item-row').cloneNode(true);
            
            // Update names to have correct index
            newRow.querySelector('select').name = `products[${itemIndex}][product_id]`;
            newRow.querySelector('select').value = "";
            newRow.querySelector('input').name = `products[${itemIndex}][required_quantity]`;
            newRow.querySelector('input').value = "1";
            
            container.appendChild(newRow);
            itemIndex++;
        });

        document.getElementById('bundle-items-container').addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-item')) {
                const rows = document.querySelectorAll('.bundle-item-row');
                if (rows.length > 1) {
                    e.target.closest('.bundle-item-row').remove();
                } else {
                    AdminUI.toast('A bundle must have at least one product.', 'error');
                }
            }
        });
    });
</script>
@endpush
