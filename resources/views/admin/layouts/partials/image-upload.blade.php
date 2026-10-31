@once
@push('css')
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.css') }}">
<style>.nafu-system-dropzone{min-height:260px;display:flex;align-items:center;justify-content:center;overflow:hidden}.nafu-system-dropzone .dz-preview{margin:0}</style>
@endpush
@endonce

<div class="dropzone needsclick rounded nafu-system-dropzone" id="dropzone-{{ $uploadId }}" data-input="{{ $uploadId }}">
    <div class="dz-message needsclick">
        <i class="ti ti-upload fs-1 d-block mb-2"></i>
        Drag an image here or click to select
        <span class="note needsclick d-block mt-2">PNG, JPG, GIF or WEBP — maximum 5 MB</span>
    </div>
</div>
<input type="hidden" id="{{ $uploadId }}" name="{{ $valueName }}" value="{{ $imageValue }}">

@once
@push('js')
<script src="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/admin/js/dried-chilli-dropzone.js') }}?v=20260919-1"></script>
<script>
(() => {
    document.querySelectorAll('.nafu-system-dropzone').forEach(element => {
        const hiddenInput = document.getElementById(element.dataset.input);
        if (!hiddenInput) return;
        if (hiddenInput.value && !hiddenInput.value.startsWith('http') && !hiddenInput.value.startsWith('data:')) hiddenInput.value = @json(asset('/')) + hiddenInput.value.replace(/^\//, '');
        NafuDropzone.mount(element, hiddenInput, 'Current image');
    });
})();
</script>
@endpush
@endonce
