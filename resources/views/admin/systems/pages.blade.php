@extends('admin.layouts.master')

@push('css')
    <style>
        .page-tabs { overflow-x: auto; overflow-y: hidden; flex-wrap: nowrap; scrollbar-width: thin; }
        .page-tabs .nav-link { white-space: nowrap; }
        .page-section { border: 1px solid var(--bs-border-color); border-radius: 20px; overflow: hidden; }
        .page-section + .page-section { margin-top: 1rem; }
        .page-section summary { padding: 1rem 1.25rem; cursor: pointer; font-weight: 600; background: rgba(var(--bs-primary-rgb), .04); }
        .page-section__body { padding: 1.25rem; }
        .page-content-field { padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--bs-border-color); }
        .page-content-field:last-child { padding: 0; margin: 0; border: 0; }
        .setting-key { font-family: monospace; font-size: .72rem; color: var(--bs-secondary-color); }
    </style>
@endpush

@section('content')
    @php
        $pages = config('page-content', []);
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ route('admin.systems.update') }}">
            @csrf
            @method('PUT')

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Content các trang</h3>
                    <p class="text-muted mb-0">Select a page and section to edit its content.</p>
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    <i class="ti ti-device-floppy me-1"></i>Save thay đổi
                </button>
            </div>

            @include('admin.layouts.partials.messages')
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <details class="card mb-4"><summary class="card-header">Mẫu hợp đồng dùng chung</summary><div class="card-body"><p>Thiết lập một lần để tự điền khi tạo hợp đồng. Giá lấy từ từng dịch vụ. Mục không áp dụng ghi rõ “Không áp dụng”.</p><div class="row g-3">
                @foreach(config('website-contract.fields') as $fields)
                    @foreach($fields as $key => $label)
                        <div class="col-md-6"><label class="form-label" for="default-{{ $key }}">{{ $label }}</label><textarea id="default-{{ $key }}" class="form-control" name="contract_defaults[{{ $key }}]" rows="2">{{ old('contract_defaults.' . $key, $data['contract_default_' . $key]['content'] ?? config('website-contract.defaults.' . $key, '')) }}</textarea></div>
                    @endforeach
                @endforeach
            </div></div></details>
            <div class="card">
                <div class="card-header p-0 border-bottom">
                    <ul class="nav nav-tabs page-tabs px-3 pt-3" role="tablist">
                        @foreach ($pages as $pageKey => $page)
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-bs-toggle="tab" data-bs-target="#page-pane-{{ $pageKey }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $page['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0 shadow-none">
                        @foreach ($pages as $pageKey => $page)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="page-pane-{{ $pageKey }}">
                                @if(array_key_exists($pageKey, \App\Support\PagePathMap::DEFAULTS))
                                    <details class="page-section" open>
                                        <summary>Đường dẫn trang (URL)</summary>
                                        <div class="page-section__body">
                                            <div class="row g-3">
                                                @foreach(['en' => 'English'] as $pathLocale => $pathLabel)
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="path-{{ $pageKey }}-{{ $pathLocale }}">{{ $pathLabel }}</label>
                                                        <div class="input-group"><span class="input-group-text">/{{ $pathLocale }}/</span><input class="form-control" id="path-{{ $pageKey }}-{{ $pathLocale }}" name="page_paths[{{ $pageKey }}][{{ $pathLocale }}]" maxlength="100" pattern="[a-z0-9]+(-[a-z0-9]+)*" value="{{ old('page_paths.' . $pageKey . '.' . $pathLocale, \App\Support\PagePaths::map()->current($pageKey, $pathLocale)) }}" placeholder="{{ \App\Support\PagePathMap::DEFAULTS[$pageKey] }}"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <p class="text-muted small mt-3 mb-0">Chỉ nhập phần tên đường dẫn, không nhập dấu /. Dùng chữ thường không dấu, số và gạch ngang. {{ $pageKey === 'home' ? 'Để trống để dùng /en hoặc /vi.' : 'Để trống để dùng đường dẫn mặc định.' }} Đường dẫn cũ tự chuyển hướng sang đường dẫn mới.</p>
                                        </div>
                                    </details>
                                @elseif(in_array($pageKey, ['service_detail', 'news_detail'], true))
                                    <p class="text-muted">Tiền tố URL được chỉnh tại tab {{ $pageKey === 'service_detail' ? 'Services' : 'News' }}. Slug từng nội dung được quản lý ở mục nội dung tương ứng.</p>
                                @endif
                                @foreach ($page['sections'] as $section => $fields)
                                    <details class="page-section" {{ $loop->first ? 'open' : '' }}>
                                        <summary>{{ $section }}</summary>
                                        <div class="page-section__body">
                                            @foreach ($fields as $key => $field)
                                                <div class="page-content-field">
                                                    <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
                                                        <h6 class="mb-0">{{ $field['label'] }}</h6>
                                                        <code class="setting-key">{{ $page['prefix'] }}_{{ $key }}_[en|vi]</code>
                                                    </div>
                                                    <div class="row g-3">
                                                        @foreach (['en' => 'English'] as $locale => $localeLabel)
                                                            @php
                                                                $settingKey = "{$page['prefix']}_{$key}_{$locale}";
                                                                $value = old('page_content.' . $settingKey, $data[$settingKey]['content'] ?? $field[$locale] ?? '');
                                                                $isTextarea = ($field['type'] ?? null) === 'textarea' || strlen($value) > 100;
                                                            @endphp
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="{{ $settingKey }}">{{ $localeLabel }}</label>
                                                                @if ($isTextarea)
                                                                    <textarea class="form-control" rows="4" id="{{ $settingKey }}" name="page_content[{{ $settingKey }}]">{{ $value }}</textarea>
                                                                @else
                                                                    <input class="form-control" id="{{ $settingKey }}" name="page_content[{{ $settingKey }}]" value="{{ $value }}">
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
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

