@extends('admin.layouts.master')

@section('content')
    @php
        $pageNames = ['Services', 'Service Details', 'Projects', 'Project Details', 'News', 'News Details', 'Contact', '404'];
        $pages = ['Home' => []];
        foreach ($sections as $section => $fields) {
            if (in_array($section, $pageNames, true)) {
                $pages[$section] = [$section => $fields];
            } else {
                $pages['Home'][$section] = $fields;
            }
        }
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ route('admin.systems.pages.save') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Pages</h3>
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
                <div class="card-header p-0 border-bottom">
                    <ul class="nav nav-tabs px-3 pt-3" role="tablist">
                        @foreach ($pages as $page => $pageSections)
                            <li class="nav-item" role="presentation">
                                <button type="button"
                                    class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="page-tab-{{ $loop->index }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#page-pane-{{ $loop->index }}"
                                    role="tab"
                                    aria-controls="page-pane-{{ $loop->index }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $page }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content p-0 shadow-none">
                        @foreach ($pages as $page => $pageSections)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="page-pane-{{ $loop->index }}"
                                role="tabpanel"
                                aria-labelledby="page-tab-{{ $loop->index }}">
                                @foreach ($pageSections as $section => $fields)
                                    <details class="card mb-3" {{ $loop->first ? 'open' : '' }}>
                                        <summary class="card-header">
                                            {{ ucwords(str_replace(['nafu-', '-'], ['', ' '], $section)) }}
                                        </summary>

                                        <div class="card-body">
                                            <div class="row g-3">
                                                @foreach ($fields as $key => $field)
                                                    @continue(preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? ''))
                                                    @php
                                                        $value = old('content.'.$key, $values['nafu_home_'.$key] ?? '');
                                                        $isLong = strlen($value) > 100;
                                                        $isImage = str_contains($key, '_image_');
                                                    @endphp
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="{{ $key }}">
                                                            {{ $isImage ? 'Image' : \Illuminate\Support\Str::limit(strip_tags($field['label']), 90) }}
                                                        </label>

                                                        @if ($isImage)
                                                            @include('admin.layouts.partials.image-upload', [
                                                                'valueName' => 'content['.$key.']', 'imageValue' => $value,
                                                                'uploadId' => $key,
                                                            ])
                                                        @elseif ($isLong)
                                                            <textarea id="{{ $key }}"
                                                                name="content[{{ $key }}]"
                                                                class="form-control"
                                                                rows="4">{{ $value }}</textarea>
                                                        @else
                                                            <input id="{{ $key }}"
                                                                name="content[{{ $key }}]"
                                                                class="form-control"
                                                                value="{{ $value }}">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
