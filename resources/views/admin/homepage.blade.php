@extends('admin.layouts.master')
@include('admin.layouts.partials.quill-full')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/editor.css') }}">
    <style>
        .service-editor { min-height: 260px; }
        .service-editor .ql-editor { min-height: 220px; }
        .about-editor-intro { background: #fff7f2; border: 1px solid #f5d7ca; border-radius: 14px; padding: 1.2rem 1.4rem; }
        .about-editor-intro ol { padding-left: 1.2rem; margin: .5rem 0 0; }
        .about-editor-section { border: 1px solid var(--bs-border-color); border-radius: 14px; overflow: hidden; }
        .about-editor-section summary { cursor: pointer; list-style: none; display: flex; align-items: center; gap: .9rem; padding: 1.1rem 1.25rem; }
        .about-editor-section summary::-webkit-details-marker { display: none; }
        .about-editor-section summary:focus-visible { outline: 3px solid var(--bs-primary); outline-offset: -3px; }
        .about-editor-section summary::after { content: '+'; margin-left: auto; font-size: 1.4rem; color: var(--bs-primary); }
        .about-editor-section[open] summary::after { content: '−'; }
        .about-editor-number { display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; flex: none; border-radius: 50%; background: #fff0e8; color: #b83819; font-weight: 700; }
        .about-editor-group { border-top: 1px solid var(--bs-border-color); padding: 1.2rem 0; }
        .about-editor-group:first-child { border-top: 0; padding-top: 0; }
        .about-editor-group:last-child { padding-bottom: 0; }
        .about-editor-group h6 { margin: 0 0 1rem; font-weight: 700; }
        .about-editor-group .form-label { font-weight: 600; }
        .about-editor-actions { position: sticky; bottom: 0; z-index: 5; background: rgba(255,255,255,.97); border-top: 1px solid var(--bs-border-color); padding: .9rem 1.2rem; margin: 1rem -1.25rem -1.25rem; }
        
    </style>
@endpush

@section('content')
    @php
        $pages = \App\Support\PageContentGroups::fromSections($sections);
        $requestedPage = request()->query('page');
        $selectedPage = is_string($requestedPage) && array_key_exists($requestedPage, $pages) ? $requestedPage : 'Home';
        $easyPages = ['Home', 'About Us', 'Our Legacy', 'Sale', 'Product Details', 'FAQ', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds', '404'];
        $isEasyPage = in_array($selectedPage, $easyPages, true);
        $aboutFields = $isEasyPage ? collect(array_merge(
            json_decode(file_get_contents(config_path('about-layout.json')), true, 512, JSON_THROW_ON_ERROR),
            json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR)
        ))->collapse()->all() : [];
        $previewRoutes = ['Home' => 'home', 'About Us' => 'page.about', 'Our Legacy' => 'page.legacy', 'Sale' => 'page.sale', 'FAQ' => 'page.faq', 'Privacy Policy' => 'page.privacy', 'Terms of Service' => 'page.terms', 'Shipping & Refunds' => 'page.shipping'];
        $aboutHelp = [
            'About Us - Hero' => ['Opening banner', 'The first heading and highlights visitors see.'],
            'About Us - Navigation' => ['Quick links', 'Labels for the links beneath the opening banner.'],
            'About Us - Who We Are' => ['Our story', 'Your introduction, highlights, photo and quote.'],
            'About Us - What We Do' => ['Our craft and products', 'The process steps and the three product cards.'],
            'About Us - Why Trust Us' => ['Why customers trust us', 'Your promises, quality standards and testimonial.'],
            'About Us - Call to Action' => ['Closing call to action', 'The final message and buttons at the bottom of the page.'],
        ];
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ route('admin.systems.pages.save') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="selected_page" value="{{ $selectedPage }}">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="mb-1">{{ $isEasyPage ? 'Edit ' . $selectedPage : $selectedPage }}</h3>
                    <p class="text-muted mb-0">Manage page headings, descriptions, images, buttons and SEO. Individual services, projects and articles use their own modules.</p>
                    @if ($selectedPage === 'About Us')
                        <p class="text-muted mb-0">Edit the existing page sections below. Each section can be shown or hidden; changes appear on the About Us page.</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Save changes
                </button>
            </div>

            @include('admin.layouts.partials.messages')

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @if ($isEasyPage)
                <div class="about-editor-intro mb-4">
                    <strong>How to edit this page</strong>
                    <ol><li>Open the part of the page you want to change.</li><li>Edit its text or images{{ $selectedPage === 'Home' ? '.' : ', and choose whether sections are visible where available.' }}</li><li>Click <strong>Save changes</strong>, then open the page to check your work.</li></ol>
                    @if (isset($previewRoutes[$selectedPage]))
                        <a href="{{ route($previewRoutes[$selectedPage]) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary mt-3">View {{ $selectedPage }} <span aria-hidden="true">↗</span></a>
                        <span class="small text-muted ms-2">The live page shows saved changes only.</span>
                    @elseif ($selectedPage === 'Product Details')
                        <p class="small text-muted mt-3 mb-0">To preview, open any product on the website. Product names, prices and images are managed in Products.</p>
                    @endif
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @php $page = $selectedPage; $pageSections = $pages[$selectedPage]; @endphp
                                @if ($page === 'FAQ')
                                    @php
                                        $faqRows = old('faq_entries', $faqs->map(fn ($faq) => ['id' => $faq->id, 'question' => $faq->question, 'answer' => $faq->answer, 'is_active' => (int) $faq->is_active, 'sort_order' => $faq->sort_order])->values()->all());
                                    @endphp
                                    <details class="about-editor-section mb-3" open>
                                        <summary><span class="about-editor-number">?</span><span><strong class="d-block">Published questions</strong><small class="text-muted">Add, edit or hide questions and answers.</small></span></summary>
                                        <div class="card-body border-top">
                                            <p class="small text-muted">When at least one question is published, these questions replace the default list. If none are published, the default questions appear.</p>
                                            <div id="faq-editor-rows" data-next="{{ count($faqRows) }}">
                                                @foreach ($faqRows as $row)
                                                    @include('admin.layouts.partials.faq-editor-row', ['row' => $row, 'rowIndex' => $loop->index])
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="add-faq-row">Add question</button>
                                            <template id="faq-editor-template">@include('admin.layouts.partials.faq-editor-row', ['row' => [], 'rowIndex' => '__INDEX__'])</template>
                                        </div>
                                    </details>
                                @endif
                                @foreach ($pageSections as $section => $fields)
                                    @if ($isEasyPage)
                                    @php
                                        $sectionHelp = $aboutHelp[$section] ?? [str_replace($page . ' - ', '', $section), str_contains($section, ' - Section ') ? 'An optional section you can publish on the page.' : 'Edit the content shown in this part of the page.'];
                                        $fieldGroups = collect($fields)->groupBy(fn ($field) => $field['group'] ?? 'Section settings', true);
                                    @endphp
                                    <details class="about-editor-section mb-3" {{ $loop->first ? 'open' : '' }}>
                                        <summary>
                                            <span class="about-editor-number">{{ $loop->iteration }}</span>
                                            <span><strong class="d-block">{{ $sectionHelp[0] }}</strong><small class="text-muted">{{ $sectionHelp[1] }}</small></span>
                                        </summary>
                                        <div class="card-body border-top">
                                            @if(str_contains($section, ' - Section '))
                                                <div class="d-flex justify-content-end mb-3">
                                                    <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.delete_section') }}?section={{ urlencode($section) }}" class="btn btn-sm btn-outline-danger" data-confirm="Delete this section? This cannot be undone, and unsaved changes on this page will be lost.">Delete section</button>
                                                </div>
                                            @endif
                                            @foreach ($fieldGroups as $group => $groupFields)
                                                <div class="about-editor-group">
                                                    <h6>{{ $group }}</h6>
                                                    @if ($page === 'FAQ' && $section === 'FAQ - Questions and answers')
                                                        <p class="small text-muted">These are the default questions shown only when there are no published questions above.</p>
                                                    @endif
                                                    @if ($group === 'Buttons' || str_starts_with($group, 'Product card'))
                                                        <p class="small text-muted">For links, use a page path such as <code>/shop</code> or a full https:// address.</p>
                                                    @endif
                                                    <div class="row g-3">
                                                        @foreach ($groupFields as $key => $field)
                                                            @continue(preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? ''))
                                                            @php
                                                                $defaultValue = isset($aboutFields[$key]) ? \App\Support\AboutPageContent::value($key, $aboutFields, $values) : ($values['nafu_home_'.$key] ?? $field['value'] ?? '');
                                                                $value = old('content.'.$key, $defaultValue);
                                                            @endphp
                                                            @include('admin.layouts.partials.smart-field', ['key' => $key, 'field' => $field, 'value' => $value, 'inputName' => 'content['.$key.']'])
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </details>
                                    @else
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
                                    @endif
                                @endforeach
                                @if(in_array($page, \App\Support\PageContentGroups::CUSTOM_PAGES, true))
                                    <div class="card mb-3 bg-light border-dashed">
                                        <div class="card-body text-center py-4">
                                            <p class="mb-2"><strong>Add another section</strong></p>
                                            <p class="small text-muted mb-3">Adding a section saves your current changes. New sections stay hidden until you publish them.</p>
                                            <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.add_section') }}?type=text-image&page={{ urlencode($page) }}" class="btn btn-outline-primary me-2">
                                                <i class="ti ti-layout-align-left me-1"></i> Add text and image
                                            </button>
                                            <button type="submit" formmethod="POST" formaction="{{ route('admin.systems.pages.add_section') }}?type=card&page={{ urlencode($page) }}" class="btn btn-outline-secondary">
                                                <i class="ti ti-layout-grid me-1"></i> Add three feature cards
                                            </button>
                                        </div>
                                    </div>
                                @endif
                    @if ($isEasyPage)
                        <div class="about-editor-actions d-flex flex-wrap align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <span class="small text-muted">Changes appear on the website after saving.</span>
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
            const faqRows = document.getElementById('faq-editor-rows');
            const addFaq = document.getElementById('add-faq-row');
            if (faqRows && addFaq) addFaq.addEventListener('click', () => {
                const index = Number(faqRows.dataset.next || 0);
                const template = document.getElementById('faq-editor-template').innerHTML.replaceAll('__INDEX__', String(index));
                faqRows.insertAdjacentHTML('beforeend', template);
                faqRows.dataset.next = String(index + 1);
            });
            if (faqRows) faqRows.addEventListener('change', async event => {
                const checkbox = event.target;
                if (!checkbox.matches('[data-faq-delete]') || !checkbox.checked) return;
                if (!await AdminUI.confirm('Delete this question when you save?')) checkbox.checked = false;
            });
            if (faqRows) faqRows.addEventListener('click', event => {
                const button = event.target.closest('[data-remove-new-faq]');
                if (button) button.closest('.card').remove();
            });
            // Find all dynamic editors and mount NafuQuill on them
            document.querySelectorAll('.nafu-dynamic-editor').forEach(editorDiv => {
                const id = editorDiv.id.replace('editor-', '');
                NafuQuill.mount('#' + editorDiv.id, '#input-' + id);
            });
        })();
    </script>
@endpush
