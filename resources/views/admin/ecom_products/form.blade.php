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
                                    <i class="ti ti-photo me-1 text-primary"></i> Product Image Gallery
                                </label>
                                <p class="text-muted small mb-0">Upload one or more images. Choose a primary image and remove images you no longer need.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('product_images').click()">
                                <i class="ti ti-upload me-1"></i> Add images
                            </button>
                        </div>

                        <!-- Dropzone Area -->
                        <div class="image-dropzone-box" id="dropzoneBox" onclick="document.getElementById('product_images').click()">
                            <i class="ti ti-cloud-upload text-primary" style="font-size: 2.4rem;"></i>
                            <h6 class="mt-2 mb-1 fw-bold">Drag and drop images here, or click to select</h6>
                            <p class="text-muted small mb-0">JPG, PNG, WEBP or GIF, up to {{ rtrim(rtrim(number_format(\App\Support\UploadLimits::imageBytes() / 1048576, 2), '0'), '.') }} MB per image. You can select multiple images.</p>
                            <input type="file" id="product_images" name="images[]" multiple accept="image/*" class="d-none" onchange="addImages(this.files)" onclick="event.stopPropagation()">
                        </div>

                        <!-- New Selected Images Preview (Before Upload) -->
                        <div id="newImagesContainer" class="mt-3 d-none">
                            <h6 class="small fw-bold text-primary mb-2"><i class="ti ti-clock me-1"></i> Images ready to upload:</h6>
                            <div class="row g-3" id="newImagesGrid"></div>
                        </div>

                        <!-- Existing Images Gallery -->
                        @if($data->id && ($data->images->count() > 0 || !empty($data->image)))
                            <div class="mt-4" id="existingImagesSection">
                                <h6 class="small fw-bold text-dark mb-2"><i class="ti ti-library-photo me-1"></i> Current product images:</h6>
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
                                                    <span class="primary-badge" id="badge-{{ $img->id }}"><i class="ti ti-star me-1"></i>Primary</span>
                                                @else
                                                    <span class="primary-badge d-none" id="badge-{{ $img->id }}"><i class="ti ti-star me-1"></i>Primary</span>
                                                @endif
                                                <img src="{{ $img->url }}" class="gallery-preview-img" alt="Product Image">
                                                <div class="gallery-actions">
                                                    <button type="button" 
                                                            class="btn btn-xs {{ $isMain ? 'btn-primary' : 'btn-outline-primary' }} w-100 btn-set-primary" 
                                                            id="btn-primary-{{ $img->id }}"
                                                            onclick="setPrimaryImage({{ $img->id }}, this.dataset.url)"
                                                            data-url="{{ route('admin.ecom_products.images.primary', [$data->id, $img->id]) }}"
                                                            title="Set as primary image">
                                                        <i class="ti ti-star me-1"></i>{{ $isMain ? 'Primary' : 'Set as primary' }}
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-xs btn-outline-danger" 
                                                            onclick="deleteExistingImage({{ $img->id }}, this.dataset.url)"
                                                            data-url="{{ route('admin.ecom_products.images.destroy', [$data->id, $img->id]) }}"
                                                            title="Delete this image">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        @if(!empty($data->image))
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                <div class="gallery-preview-card border-primary">
                                                    <span class="primary-badge"><i class="ti ti-star me-1"></i>Primary</span>
                                                    <img src="{{ $data->image_url }}" class="gallery-preview-img" alt="{{ $data->name }}">
                                                    <div class="p-2 text-center bg-light">
                                                        <small class="text-muted">Current cover image</small>
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
    const dropzone = document.getElementById('dropzoneBox');
    const fileInput = document.getElementById('product_images');
    const maxImageBytes = @json(\App\Support\UploadLimits::imageBytes());
    const maxPostBytes = @json(\App\Support\UploadLimits::bytes('post_max_size'));
    const maxFiles = @json((int) ini_get('max_file_uploads'));
    let selectedImages = [];

    function syncImages() {
        const transfer = new DataTransfer();
        selectedImages.forEach(file => transfer.items.add(file));
        fileInput.files = transfer.files;
        const grid = document.getElementById('newImagesGrid');
        grid.replaceChildren();
        document.getElementById('newImagesContainer').classList.toggle('d-none', selectedImages.length === 0);
        selectedImages.forEach((file, index) => {
            const column = document.createElement('div');
            column.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
            const card = document.createElement('div');
            card.className = 'gallery-preview-card';
            const image = document.createElement('img');
            image.className = 'gallery-preview-img';
            image.alt = 'New image preview';
            const imageUrl = URL.createObjectURL(file);
            image.src = imageUrl;
            image.onload = () => URL.revokeObjectURL(imageUrl);
            image.onerror = () => URL.revokeObjectURL(imageUrl);
            const actions = document.createElement('div');
            actions.className = 'gallery-actions';
            const name = document.createElement('small');
            name.className = 'text-truncate';
            name.textContent = file.name;
            name.title = file.name;
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'btn btn-xs btn-outline-danger';
            remove.textContent = 'Remove';
            remove.setAttribute('aria-label', 'Remove ' + file.name);
            remove.addEventListener('click', () => { selectedImages.splice(index, 1); syncImages(); });
            actions.append(name, remove);
            card.append(image, actions);
            column.append(card);
            grid.append(column);
        });
    }

    function addImages(files) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        const incoming = Array.from(files);
        if (incoming.some(file => !allowedTypes.includes(file.type) || file.size > maxImageBytes)) {
            AdminUI.toast(`Choose JPG, PNG, WEBP or GIF images no larger than ${(maxImageBytes / 1048576).toFixed(2)} MB each.`, 'error');
        }
        const valid = incoming.filter(file => allowedTypes.includes(file.type) && file.size <= maxImageBytes);
        if (maxFiles > 0 && selectedImages.length + valid.length > maxFiles) {
            AdminUI.toast(`You can upload at most ${maxFiles} images at a time.`, 'error');
        } else {
            selectedImages.push(...valid);
        }
        syncImages();
    }

    document.getElementById('productForm').addEventListener('submit', event => {
        const fileBytes = selectedImages.reduce((total, file) => total + file.size, 0);
        const formBytes = Array.from(new FormData(event.currentTarget).values())
            .reduce((total, value) => total + (typeof value === 'string' ? new TextEncoder().encode(value).length : 0), 0);
        if (maxPostBytes > 0 && fileBytes + formBytes + 65536 > maxPostBytes) {
            event.preventDefault();
            AdminUI.toast(`The selected images exceed this server's ${(maxPostBytes / 1048576).toFixed(1)} MB request limit. Remove some images and upload them in batches.`, 'error');
        }
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(name => {
        dropzone.addEventListener(name, event => {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.toggle('dragover', name === 'dragenter' || name === 'dragover');
            if (name === 'drop') addImages(event.dataTransfer.files);
        });
    });

    async function imageRequest(url, method) {
        const response = await fetch(url, { method, headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'
        }});
        if (!response.ok) throw new Error('The image operation failed. Please try again.');
        return response.json();
    }

    function updatePrimary(primaryId) {
        document.getElementById('primary_image_id').value = primaryId || '';
        document.querySelectorAll('.btn-set-primary').forEach(button => {
            const isPrimary = button.id === `btn-primary-${primaryId}`;
            button.classList.toggle('btn-primary', isPrimary);
            button.classList.toggle('btn-outline-primary', !isPrimary);
            button.textContent = isPrimary ? 'Primary' : 'Set as primary';
            button.closest('.gallery-preview-card').classList.toggle('border-primary', isPrimary);
        });
        document.querySelectorAll('[id^="badge-"]').forEach(badge => {
            badge.classList.toggle('d-none', badge.id !== `badge-${primaryId}`);
        });
    }

    async function setPrimaryImage(imageId, url) {
        try { await imageRequest(url, 'POST'); updatePrimary(imageId); }
        catch (error) { AdminUI.toast(error.message, 'error'); }
    }

    async function deleteExistingImage(imageId, url) {
        if (!await AdminUI.confirm('Remove this image from the product?')) return;
        try {
            const result = await imageRequest(url, 'DELETE');
            document.getElementById(`img-card-${imageId}`).remove();
            updatePrimary(result.primary_image_id);
        } catch (error) { AdminUI.toast(error.message, 'error'); }
    }
</script>
@endpush
