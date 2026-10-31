@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-service-content.css') }}?v=20260919-1">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dried-chilli-quill.css') }}?v=20260919-1">
@endpush

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/quill/katex.js') }}"></script>
    <script>window.nafuEditorUploadUrl = @json(route('admin.editor.images'));</script>
    <script src="{{ asset('assets/admin/js/dried-chilli-quill.js') }}?v=20260919-2"></script>
@endpush
