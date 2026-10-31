<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', ['services' => $this->publicServices()]);
    }

    public function show(string $slug)
    {
        $service = Service::query()->active()->with('meta')->where('slug', $slug)->firstOrFail();

        return view('services.show', [
            'slug' => $slug,
            'service' => $this->normalise($service),
            'allServices' => $this->publicServices(),
        ]);
    }

    private function publicServices(): Collection
    {
        $databaseServices = Service::query()
            ->where('active', true)
            ->with('meta')
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        return $databaseServices->map(fn (Service $service) => $this->normalise($service));
    }

    private function normalise(Service $service): array
    {
        $items = collect(preg_split('/\r\n|\r|\n/', (string) $service->benefits))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $fallback = config('dried-chilli-services.'.$service->slug, []);

        if (empty($items) && $service->description) {
            $items = [Str::limit(strip_tags($service->description), 100)];
        }

        return [
            'slug' => $service->slug,
            'name' => $service->name,
            'description' => $service->description,
            'content' => $service->content,
            'items' => $items,
            'icon' => $fallback['icon'] ?? 'repairs',
            'image_url' => $service->avatar
                ? (str_starts_with($service->avatar, 'assets/') || filter_var($service->avatar, FILTER_VALIDATE_URL)
                    ? asset($service->avatar)
                    : Storage::url($service->avatar))
                : asset('assets/imgs/default.png'),
            'seo_title' => $service->meta?->title,
            'seo_description' => $service->meta?->description,
            'seo_keywords' => $service->meta?->key_words,
        ];
    }
}
