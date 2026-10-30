@extends('admin.layouts.master')
@include('admin.layouts.partials.quill-full')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/typography.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/editor.css') }}">
<style>
#dropzone-avatar{min-height:300px;display:flex;align-items:center;justify-content:center;overflow:hidden}
#dropzone-avatar .dz-preview{margin:0}
.project-editor,.project-editor .ql-editor{min-height:250px}
</style>
@endpush

@section('content')
@php($existingAvatar = isset($data) && $data->avatar ? $data->image_url : '')
<div class="container-xxl flex-grow-1 container-p-y">
<form method="POST" action="{{ isset($data) ? route('admin.projects.update', ['id' => $data->id]) : route('admin.projects.store') }}">
@csrf @if(isset($data)) @method('PUT') @endif
<div class="d-flex align-items-center justify-content-between mb-4"><div><h3 class="mb-1">{{ isset($data) ? 'Update project' : 'Create project' }}</h3><p class="text-muted mb-0">This content powers the Projects page, homepage completed work and Project Details.</p></div><div class="d-flex gap-2"><a href="{{ route('admin.projects.index') }}" class="btn btn-label-secondary">Cancel</a><button class="btn btn-primary" type="submit">Save project</button></div></div>
@include('admin.layouts.partials.messages')
<div class="row g-4">
<div class="col-xl-4"><div class="card"><div class="card-body"><label class="form-label">Project image <span class="text-danger">*</span></label><div class="dropzone needsclick rounded" id="dropzone-avatar"><div class="dz-message needsclick"><i class="ti ti-upload fs-1 d-block mb-2"></i>Drag an image here or click to select<span class="note d-block mt-2">PNG, JPG or WEBP — maximum 5 MB</span></div></div><input type="hidden" id="avatar" name="avatar" value="{{ old('avatar', $existingAvatar) }}">@error('avatar')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
</div></div></div>
<div class="col-xl-8"><div class="card"><div class="card-body"><div class="mb-3"><label class="form-label" for="title">Name *</label><input class="form-control" id="title" name="title" required value="{{ old('title', $data->title ?? '') }}">@error('title')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label" for="description">Short description *</label><textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $data->description ?? '') }}</textarea>@error('description')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label" for="editor-content">Content</label><textarea class="d-none" id="content" name="content">{{ old('content', $data->content ?? '') }}</textarea><div class="project-editor" id="editor-content"></div>@error('content')<div class="text-danger small">{{ $message }}</div>@enderror</div>
</div></div></div>
</div></form></div>
@endsection

@push('js')
<script src="{{ asset('assets/admin/vendor/libs/quill/quill.js') }}"></script><script src="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/admin/js/nafu-dropzone.js') }}?v=20260919-1"></script>
<script>(()=>{NafuQuill.mount('#editor-content','#content');NafuDropzone.mount(document.querySelector('#dropzone-avatar'),document.querySelector('#avatar'),'Project image')})();</script>
@endpush
