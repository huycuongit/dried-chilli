@extends('admin.layouts.master')
@include('admin.layouts.partials.quill-full')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/editor.css') }}">
    <style>
        #dropzone-avatar { min-height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        #dropzone-avatar .dz-preview { margin: 0; }
        .service-editor { min-height: 260px; }
        .service-editor .ql-editor { min-height: 220px; }
    </style>
@endpush

@section('content')
    @php
        $existingAvatar = isset($data) && $data->avatar
            ? (str_starts_with($data->avatar, 'assets/') ? asset($data->avatar) : Storage::url($data->avatar))
            : '';
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ isset($data) ? route('admin.services.update', ['id' => $data->id]) : route('admin.services.store') }}">
            @csrf
            @if (isset($data)) @method('PUT') @endif

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="mb-1">{{ isset($data) ? 'Update service' : 'Create service' }}</h3>
                    <p class="text-muted mb-0">Manage the service card and service detail page content.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-label-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

            @include('admin.layouts.partials.messages')

            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <div class="dropzone needsclick rounded" id="dropzone-avatar" data-hidden-input-id="avatar">
                                <div class="dz-message needsclick">
                                    <i class="ti ti-upload fs-1 d-block mb-2"></i>
                                    Drag an image here or click to select
                                    <span class="note needsclick d-block mt-2">PNG, JPG or WEBP — maximum 5 MB</span>
                                </div>
                                <div class="fallback"><input name="file" type="file" accept="image/*"></div>
                            </div>
                            <input type="hidden" id="avatar" name="avatar" value="{{ old('avatar', $existingAvatar) }}">
                            @error('avatar')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-12"><label class="form-label" for="contract-price">Service price for contracts (AUD)</label><input id="contract-price" class="form-control" name="contract_price" type="number" min="0" step="0.01" value="{{ old('contract_price', $data->contract_price ?? '') }}"><div class="form-text">This amount is added automatically when the service is selected in a contract. Leave blank if not priced.</div>@error('contract_price')<div class="text-danger small">{{ $message }}</div>@enderror</div>
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Service name  <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" required value="{{ old('name', $data->name ?? '') }}">
                                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                
                                @foreach (['slug' => 'EN'] as $slugField => $slugLocale)
                                    <div class="col-md-6">
                                        <label class="form-label" for="{{ $slugField }}">Slug ({{ $slugLocale }})</label>
                                        <div class="input-group"><span class="input-group-text">{{ page_route('services.index', ['locale' => strtolower($slugLocale)], false) }}/</span><input class="form-control" id="{{ $slugField }}" name="{{ $slugField }}" maxlength="240" pattern="[a-z0-9]+(-[a-z0-9]+)*" value="{{ old($slugField, $data->{$slugField} ?? '') }}" placeholder="apartment-repairs"></div>
                                        <div class="form-text">Leave blank to generate it from the {{ $slugLocale }}. Use lowercase letters, numbers and hyphens.</div>
                                        @error($slugField)<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <label class="form-label" for="description">Short description  <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $data->description ?? '') }}</textarea>
                                    @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="benefits">Service benefits</label>
                                    <textarea class="form-control" id="benefits" name="benefits" rows="5" placeholder="Enter one benefit per line">{{ old('benefits', $data->benefits ?? '') }}</textarea>
                                    <div class="form-text">Each line becomes one bullet on the Services page.</div>
                                    @error('benefits')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                

                                <div class="col-12">
                                    <label class="form-label">Detailed content</label>
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#service-content-en">English</button></li>
                                    </ul>
                                    <div class="tab-content p-0 shadow-none">
                                        <div class="tab-pane fade show active" id="service-content-en">
                                            <textarea class="d-none" id="content" name="content">{{ old('content', $data->content ?? '') }}</textarea>
                                            <div class="service-editor" id="editor-content">{{ old('content', $data->content ?? '') }}</div>
                                            @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-12">
                                    <x-admin.admin-meta-data :metaData="$metaData ?? null" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="position">Position</label>
                                    <input class="form-control" id="position" name="position" type="number" min="0" value="{{ old('position', $data->position ?? 0) }}">
                                    @error('position')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input type="hidden" name="active" value="0">
                                        <input class="form-check-input" id="active" name="active" type="checkbox" value="1" {{ old('active', isset($data) ? $data->active : true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Show on homepage</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/admin/js/nafu-dropzone.js') }}?v=20260919-1"></script>
    <script>
        (() => {
            NafuQuill.mount('#editor-content', '#content');

            const element = document.querySelector('#dropzone-avatar');
            const hiddenInput = document.querySelector('#avatar');
            if (!element || !hiddenInput) return;
            NafuDropzone.mount(element, hiddenInput, 'Service image');
        })();
    </script>
@endpush
