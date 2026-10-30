@extends('admin.layouts.master')
@include('admin.layouts.partials.quill-full')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/editor.css') }}">
    <style>
        .service-editor { min-height: 260px; }
        .service-editor .ql-editor { min-height: 220px; }
        
    </style>
@endpush

@section('content')
    @php
        $pages = \App\Support\PageContentGroups::fromSections($sections);
        $requestedPage = request()->query('page');
        $selectedPage = is_string($requestedPage) && array_key_exists($requestedPage, $pages) ? $requestedPage : 'Home';
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ route('admin.systems.pages.save') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="selected_page" value="{{ $selectedPage }}">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="mb-1">{{ $selectedPage }}</h3>
                    <p class="text-muted mb-0">Manage page headings, descriptions, images, buttons and SEO. Individual services, projects and articles use their own modules.</p>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Save changes
                </button>
            </div>

            @include('admin.layouts.partials.messages')

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @php $page = $selectedPage; $pageSections = $pages[$selectedPage]; @endphp
                                @foreach ($pageSections as $section => $fields)
                                    <details class="card mb-3" {{ $loop->first ? 'open' : '' }}>
                                        <summary class="card-header">
                                            {{ ucwords(str_replace(['nafu-', '-'], ['', ' '], $section)) }}
                                        </summary>

                                        <div class="card-body">
                                            @if(str_contains($section, ' - Section '))
                                                <div class="d-flex justify-content-end mb-3">
                                                    <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.delete_section') }}?section={{ urlencode($section) }}" class="btn btn-sm btn-outline-danger" data-confirm="Delete this section? This cannot be undone.">
                                                        <i class="ti ti-trash me-1"></i> Xóa Section Này
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="row g-3">
                                                @foreach ($fields as $key => $field)
                                                    @continue(preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? ''))
                                                    @php
                                                        $dbValue = array_key_exists('nafu_home_'.$key, $values) ? $values['nafu_home_'.$key] : ($field['value'] ?? '');
                                                        $value = old('content.'.$key, $dbValue);
                                                    @endphp
                                                    @include('admin.layouts.partials.smart-field', [
                                                        'key' => $key, 
                                                        'field' => $field, 
                                                        'value' => $value, 
                                                        'inputName' => 'content['.$key.']'
                                                    ])
                                                @endforeach
                                            </div>
                                        </div>
                                    </details>
                                @endforeach
                                @if(in_array($page, ['Sale', 'About Us', 'Our Legacy', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds', 'FAQ']))
                                    <div class="card mb-3 bg-light border-dashed">
                                        <div class="card-body text-center py-4">
                                            <p class="mb-3 text-muted"><strong>Smart Layout: Dynamically Add Section</strong></p>
                                            <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.add_section') }}?type=text-image&page={{ urlencode($page) }}" class="btn btn-outline-primary me-2">
                                                <i class="ti ti-layout-align-left me-1"></i> Add Text & Image Section
                                            </button>
                                            <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.add_section') }}?type=card&page={{ urlencode($page) }}" class="btn btn-outline-secondary">
                                                <i class="ti ti-layout-grid me-1"></i> Add Feature Cards Section
                                            </button>
                                        </div>
                                    </div>
                                @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js') }}"></script>
    <script>
        (() => {
            // Find all dynamic editors and mount NafuQuill on them
            document.querySelectorAll('.nafu-dynamic-editor').forEach(editorDiv => {
                const id = editorDiv.id.replace('editor-', '');
                NafuQuill.mount('#' + editorDiv.id, '#input-' + id);
            });
        })();
    </script>
@endpush
