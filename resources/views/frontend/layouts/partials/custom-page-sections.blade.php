@php
    $customPageSections = collect(\App\Support\PageContentGroups::sections())
        ->filter(fn ($fields, $name) => str_starts_with($name, $customPageName . ' - Section '));
@endphp
<style>
.custom-page-sections .about-pillar-section { padding: 4rem 0; background: #f7f1e8; }
.custom-page-sections .about-custom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
.custom-page-sections .about-custom-grid > img { width: 100%; max-height: 32rem; object-fit: cover; border-radius: 20px; }
.custom-page-sections .about-custom-image-right > img { order: 2; }
.custom-page-sections .about-custom-full { grid-template-columns: 1fr; }
.custom-page-sections .about-custom-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.custom-page-sections .trust-card { padding: 1.5rem; background: white; border-radius: 20px; }
@media(max-width:767px) { .custom-page-sections .about-custom-grid, .custom-page-sections .about-custom-cards { grid-template-columns: 1fr; } .custom-page-sections .about-custom-image-right > img { order: 0; } }
</style>
<div class="custom-page-sections">
    @foreach($customPageSections as $sectionFields)
        @php
            $activeKey = collect(array_keys($sectionFields))->first(fn ($key) => str_ends_with($key, '_published'));
            $prefix = $activeKey ? substr($activeKey, 0, -10) : '';
            $customValue = static function (string $suffix) use ($prefix, $sectionFields, $systemSettings) {
                $key = $prefix . '_' . $suffix;
                return (string) ($systemSettings['nafu_home_' . $key] ?? $sectionFields[$key]['value'] ?? '');
            };
        @endphp
        @if($activeKey && $customValue('published') === '1')
            @php
                $purifierConfig = \HTMLPurifier_Config::createDefault();
                $purifierConfig->set('Cache.DefinitionImpl', null);
                $purifier = new \HTMLPurifier($purifierConfig);
                $layout = $customValue('layout');
                $image = $customValue('image');
            @endphp
            <section class="about-pillar-section bg-alt about-custom-section">
                <div class="container">
                    @if($customValue('type') === 'card')
                        <div class="section-center-head"><h2 class="pillar-heading">{{ $customValue('title') }}</h2><p>{{ $customValue('text') }}</p></div>
                        <div class="about-custom-cards">
                            @for($index = 1; $index <= 3; $index++)
                                <article class="trust-card"><span>{{ $customValue('icon_' . $index) }}</span><h3>{{ $customValue('title_' . $index) }}</h3><p>{{ $customValue('text_' . $index) }}</p></article>
                            @endfor
                        </div>
                    @else
                        <div class="about-custom-grid {{ $layout === 'full-text' || !$image ? 'about-custom-full' : '' }} {{ $layout === 'reverse' ? 'about-custom-image-right' : '' }}">
                            @if($image && $layout !== 'full-text')<img src="{{ asset($image) }}" alt="" loading="lazy" decoding="async">@endif
                            <div><h2 class="pillar-heading">{{ $customValue('title') }}</h2><div class="about-custom-content">{!! $purifier->purify($customValue('text')) !!}</div></div>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endforeach
</div>
