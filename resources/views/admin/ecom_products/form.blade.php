@extends('admin.layouts.master')

@push('css')
<style>
    .image-dropzone-box {
        border: 2px dashed rgba(228, 93, 62, 0.4);
        background-color: #FDF9F1;
        border-radius: 12px;
        padding: 32px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .image-dropzone-box:hover, .image-dropzone-box.dragover {
        border-color: var(--chili-primary);
        background-color: rgba(228, 93, 62, 0.08);
        transform: translateY(-2px);
    }
    .gallery-preview-card {
        position: relative;
        border: 1px solid var(--chili-border);
        border-radius: 10px;
        overflow: hidden;
        background: #FFFFFF;
        box-shadow: 0 2px 8px rgba(40, 18, 11, 0.06);
        transition: all 0.2s ease;
    }
    .gallery-preview-card:hover {
        box-shadow: 0 4px 14px rgba(40, 18, 11, 0.12);
    }
    .gallery-preview-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
    }
    .primary-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: linear-gradient(135deg, #E45D3E 0%, #C73B1B 100%);
        color: #FFFFFF;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(199, 59, 27, 0.35);
        z-index: 2;
    }
    .gallery-actions {
        padding: 8px;
        display: flex;
        gap: 6px;
        justify-content: space-between;
        background: #FAFAFA;
        border-top: 1px solid var(--chili-border);
    }
</style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card mb-4">
            <h5 class="card-header">{{ $data->id ? 'Edit Product' : 'Create Product' }}</h5>
            <form action="{{ $data->id ? route('admin.ecom_products.update', $data->id) : route('admin.ecom_products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="productForm" 
                  class="card-body">
                @csrf
                @if($data->id)
                    @method('PUT')
                @endif

                <input type="hidden" name="primary_image_id" id="primary_image_id" value="{{ optional($data->images->where('is_primary', true)->first())->id ?? '' }}">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $data->name) }}" required />
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="price">Price ($ AUD) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $data->price) }}" required />
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label" for="sale_price">Sale Price ($ AUD) (Optional)</label>
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

                    <!-- ================= MULTIPLE IMAGES GALLERY ================= -->
                    <div class="col-md-12 mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <label class="form-label mb-0 fw-bold fs-6">
                                    <i class="ti ti-photo me-1 text-primary"></i> Product Image Gallery (Nhiều hình ảnh)
                                </label>
                                <p class="text-muted small mb-0">Tải lên một hoặc nhiều hình ảnh cho sản phẩm. Bạn có thể chọn ảnh chính (Main Image) và xóa ảnh không cần thiết.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('product_images').click()">
                                <i class="ti ti-upload me-1"></i> Chọn thêm ảnh
                            </button>
                        </div>

                        <!-- Dropzone Area -->
                        <div class="image-dropzone-box" id="dropzoneBox" onclick="document.getElementById('product_images').click()">
                            <i class="ti ti-cloud-upload text-primary" style="font-size: 2.4rem;"></i>
                            <h6 class="mt-2 mb-1 fw-bold">Kéo thả hoặc bấm vào đây để chọn ảnh</h6>
                            <p class="text-muted small mb-0">Hỗ trợ JPG, PNG, WEBP, GIF (tối đa 5MB mỗi ảnh). Giữ phím Ctrl hoặc Shift để chọn nhiều ảnh cùng lúc.</p>
                            <input type="file" id="product_images" name="images[]" multiple accept="image/*" class="d-none" onchange="previewNewImages(this)">
                        </div>

                        <!-- New Selected Images Preview (Before Upload) -->
                        <div id="newImagesContainer" class="mt-3 d-none">
                            <h6 class="small fw-bold text-primary mb-2"><i class="ti ti-clock me-1"></i> Ảnh mới chuẩn bị tải lên:</h6>
                            <div class="row g-3" id="newImagesGrid"></div>
                        </div>

                        <!-- Existing Images Gallery -->
                        @if($data->id && ($data->images->count() > 0 || !empty($data->image)))
                            <div class="mt-4" id="existingImagesSection">
                                <h6 class="small fw-bold text-dark mb-2"><i class="ti ti-library-photo me-1"></i> Thư viện ảnh hiện tại của sản phẩm:</h6>
                                <div class="row g-3" id="existingImagesGrid">
                                    @php
                                        $primaryImgId = optional($data->images->where('is_primary', true)->first())->id;
                                    @endphp

                                    @forelse($data->images as $img)
                                        @php
                                            $isMain = $img->is_primary || ($data->image === $img->image_path);
                                        @endphp
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 image-card-wrapper" id="img-card-{{ $img->id }}">
                                            <div class="gallery-preview-card {{ $isMain ? 'border-primary' : '' }}">
                                                @if($isMain)
                                                    <span class="primary-badge" id="badge-{{ $img->id }}"><i class="ti ti-star me-1"></i>Ảnh chính</span>
                                                @else
                                                    <span class="primary-badge d-none" id="badge-{{ $img->id }}"><i class="ti ti-star me-1"></i>Ảnh chính</span>
                                                @endif
                                                <img src="{{ $img->url }}" class="gallery-preview-img" alt="Product Image">
                                                <div class="gallery-actions">
                                                    <button type="button" 
                                                            class="btn btn-xs {{ $isMain ? 'btn-primary' : 'btn-outline-primary' }} w-100 btn-set-primary" 
                                                            id="btn-primary-{{ $img->id }}"
                                                            onclick="setPrimaryImage({{ $data->id }}, {{ $img->id }})"
                                                            title="Đặt làm ảnh đại diện chính">
                                                        <i class="ti ti-star me-1"></i>{{ $isMain ? 'Chính' : 'Đặt làm chính' }}
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-xs btn-outline-danger" 
                                                            onclick="deleteExistingImage({{ $data->id }}, {{ $img->id }})"
                                                            title="Xóa ảnh này">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        @if(!empty($data->image))
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                <div class="gallery-preview-card border-primary">
                                                    <span class="primary-badge"><i class="ti ti-star me-1"></i>Ảnh chính</span>
                                                    <img src="{{ $data->image_url }}" class="gallery-preview-img" alt="{{ $data->name }}">
                                                    <div class="p-2 text-center bg-light">
                                                        <small class="text-muted">Ảnh cover hiện tại</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforelse
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- ================= END MULTIPLE IMAGES ================= -->
                    
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
                <div class="pt-4 border-top mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">
                        <i class="ti ti-device-floppy me-1"></i> {{ $data->id ? 'Update' : 'Create' }} Product
                    </button>
                    <a href="{{ route('admin.ecom_products.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Drag and drop handlers
    const dropzone = document.getElementById('dropzoneBox');
    const fileInput = document.getElementById('product_images');

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        }, false);
    });

    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        previewNewImages(fileInput);
    }, false);

    // Client-side preview of selected new images
    function previewNewImages(input) {
        const container = document.getElementById('newImagesContainer');
        const grid = document.getElementById('newImagesGrid');
        grid.innerHTML = '';

        if (input.files && input.files.length > 0) {
            container.classList.remove('d-none');
            Array.from(input.files).forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
                    col.innerHTML = `
                        <div class="gallery-preview-card">
                            <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Mới #${index + 1}</span>
                            <img src="${e.target.result}" class="gallery-preview-img" alt="Preview">
                            <div class="p-2 text-center bg-light">
                                <small class="text-truncate d-block" title="${file.name}">${file.name}</small>
                            </div>
                        </div>
                    `;
                    grid.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('d-none');
        }
    }

    // Set existing image as primary via AJAX
    function setPrimaryImage(productId, imageId) {
        const url = `/admin/dried-chili/ecom-products/${productId}/images/${imageId}/primary`;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update UI state
                document.getElementById('primary_image_id').value = imageId;
                document.querySelectorAll('.primary-badge').forEach(b => b.classList.add('d-none'));
                document.querySelectorAll('.btn-set-primary').forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                    btn.innerHTML = '<i class="ti ti-star me-1"></i>Đặt làm chính';
                });

                const targetBadge = document.getElementById(`badge-${imageId}`);
                if (targetBadge) targetBadge.classList.remove('d-none');

                const targetBtn = document.getElementById(`btn-primary-${imageId}`);
                if (targetBtn) {
                    targetBtn.classList.remove('btn-outline-primary');
                    targetBtn.classList.add('btn-primary');
                    targetBtn.innerHTML = '<i class="ti ti-star me-1"></i>Chính';
                }
            }
        })
        .catch(err => console.error('Error setting primary image:', err));
    }

    // Delete existing image via AJAX
    function deleteExistingImage(productId, imageId) {
        if (!confirm('Bạn có chắc chắn muốn xóa ảnh này khỏi sản phẩm?')) return;

        const url = `/admin/dried-chili/ecom-products/${productId}/images/${imageId}`;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const card = document.getElementById(`img-card-${imageId}`);
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => card.remove(), 300);
                }
            }
        })
        .catch(err => console.error('Error deleting image:', err));
    }
</script>
@endpush
