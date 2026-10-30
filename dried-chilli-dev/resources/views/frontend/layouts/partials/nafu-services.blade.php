@php
    $homeServices = isset($services) && $services && $services->isNotEmpty()
        ? $services->map(function ($model) {
            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', (string) $model->content, $matches);
            $items = collect($matches[1] ?? [])->map(fn ($item) => trim(strip_tags($item)))->filter()->values()->all();
            $fallback = config('nafu-services.'.$model->slug, []);

            if (empty($items) && $model->description) {
                $items = [$model->description];
            }

            return [
                'slug' => $model->slug,
                'name' => $model->name,
                'description' => $model->description,
                'items' => $items,
                'icon' => $fallback['icon'] ?? 'repairs',
            ];
        })->values()
        : collect(config('nafu-services', []))
            ->map(fn ($service, $slug) => array_merge($service, ['slug' => $slug]))
            ->values();
@endphp

<section class="service-1-section section-padding" id="home-services">
    <div class="w-layout-blockcontainer container w-container">
        <div class="service-1-section-inner">
            @foreach($homeServices as $service)
                <div class="service-1-list-wrapper w-dyn-list">
                    <div role="list" class="w-dyn-items">
                        <div role="listitem" class="w-dyn-item">
                            <div class="service-1-block {{ $loop->first ? 'service-1-active' : '' }}" data-service-slug="{{ $service['slug'] }}">
                                <div class="service-1-icon-block">
                                    <img src="{{ asset('assets/nafu/service-' . $service['icon'] . '.svg') }}" loading="lazy" alt="" class="service-1-icon">
                                </div>
                                <div class="service-1-content-block">
                                    <div class="service-1-title-block">
                                        <h3 class="service-1-item-title">{{ $service['name'] }}</h3>
                                        <img src="{{ asset('assets/nafu/67efbd230969474fe26fa7dc_right-arrow-down.svg') }}" loading="lazy" alt="" class="service-1-arrow-icon">
                                    </div>
                                    <div class="service-1-content" @if(!$loop->first) hidden @endif>
                                        <p class="service-1-desc">{{ $service['description'] }}</p>
                                        <div class="service-1-rich-text-list w-richtext">
                                            <ul role="list">
                                                @foreach($service['items'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="service-1-btn-block">
                                            <a href="{{ page_route('services.show', $service['slug']) }}" class="btn-block dark-btn w-inline-block">
                                                <div class="btn-text">View details</div>
                                                <div class="btn-overlay bg-skin"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
