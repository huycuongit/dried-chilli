@extends('admin.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ route('admin.systems.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="settings_section" value="general">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="mb-1">General settings</h3>
                    <p class="text-muted mb-0">Company information shared across the website header and footer.</p>
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    <i class="ti ti-device-floppy me-1"></i>Save changes
                </button>
            </div>

            @include('admin.layouts.partials.messages')

            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        @foreach ([
                            'company_name' => ['Company name', 'Nafu Services'],
                            'company_legal_name' => ['Registered business name', ''],
                            'company_tax_id' => ['Australian Business Number (ABN)', ''],
                            'company_email' => ['Email address', 'admin@nafuservices.com'],
                            'company_hotline' => ['Phone number', '0481 818 836'],
                            'company_address' => ['Business address', '265 Exhibition St, Melbourne VIC 3000'],
                            'company_tagline' => ['Header tagline', 'Trusted care for every home'],
                            'company_logo' => ['Company logo', 'assets/nafu/nafu-logo.png'],
                            'company_footer_description' => ['Footer description', 'A local Melbourne team for apartment repairs, painting, flooring and maintenance. Professional service, clear prices and care for every detail.'],
                            'company_copyright' => ['Copyright text', '© ' . date('Y') . ' Nafu Home Care. All rights reserved.'],
                            'company_footer_watermark' => ['Footer background text', 'Nafu'],
                            'google_site_verification' => ['Google Search Console verification code', ''],
                        ] as $key => [$label, $default])
                            <div class="col-md-6">
                                <label class="form-label" for="{{ $key }}">{{ $label }}</label>
                                @if ($key === 'company_logo')
                                    @include('admin.layouts.partials.image-upload', [
                                        'valueName' => $key, 'imageValue' => old($key, $data[$key]['content'] ?? $default),
                                        'uploadId' => $key,
                                    ])
                                @else
                                <input class="form-control" id="{{ $key }}" name="{{ $key }}"
                                    value="{{ old($key, $data[$key]['content'] ?? $default) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
