<div class="card-header p-0 border-bottom">
    <ul class="nav nav-tabs homepage-tabs px-3 pt-3" role="tablist">
        @foreach (config('homepage', []) as $section => $fields)
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }}"
                    id="homepage-tab-{{ $loop->index }}"
                    data-bs-toggle="tab"
                    data-bs-target="#homepage-pane-{{ $loop->index }}"
                    role="tab"
                    aria-controls="homepage-pane-{{ $loop->index }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $section }}
                </button>
            </li>
        @endforeach
    </ul>
</div>

<div class="card-body">
    <div class="tab-content p-0 shadow-none">
        @foreach (config('homepage', []) as $section => $fields)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="homepage-pane-{{ $loop->index }}"
                role="tabpanel"
                aria-labelledby="homepage-tab-{{ $loop->index }}">
                <div class="mb-4">
                    <h4 class="mb-1">{{ $section }}</h4>
                    <p class="text-muted mb-0">Các trường có hỗ trợ HTML cơ bản như &lt;br&gt;, &lt;strong&gt; và &lt;em&gt;.</p>
                </div>

                @foreach ($fields as $key => $field)
                    <div class="homepage-field">
                        <h6 class="mb-3">{{ $field['label'] }}</h6>
                        <div class="row g-3">
                            @foreach (['en' => 'English'] as $locale => $localeLabel)
                                @php
                                    $settingKey = "home_{$key}_{$locale}";
                                    $value = $data[$settingKey]['content'] ?? $field[$locale] ?? '';
                                    $isTextarea = ($field['type'] ?? null) === 'textarea' || strlen($value) > 100;
                                @endphp
                                <div class="col-md-6">
                                    <label class="form-label" for="{{ $settingKey }}">{{ $localeLabel }}</label>
                                    @if ($isTextarea)
                                        <textarea class="form-control" rows="3" id="{{ $settingKey }}"
                                            name="homepage[{{ $settingKey }}]">{{ $value }}</textarea>
                                    @else
                                        <input class="form-control" type="text" id="{{ $settingKey }}"
                                            name="homepage[{{ $settingKey }}]" value="{{ $value }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
