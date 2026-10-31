<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ResponsivePageImages
{
    private const WIDTHS = [320, 480, 800];

    public static function generate(string $path): void
    {
        $disk = Storage::disk('public');
        if (!preg_match('~^page-images/[a-zA-Z0-9_-]+\.webp$~', $path) || !$disk->exists($path)) {
            return;
        }
        $original = Image::make($disk->get($path));
        foreach (self::WIDTHS as $width) {
            if ($original->width() <= $width) continue;
            $variant = clone $original;
            $variant->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if (!$disk->put(self::variantPath($path, $width), (string) $variant->encode('webp', 78))) {
                throw new \RuntimeException('Failed to write responsive image: ' . self::variantPath($path, $width));
            }
        }
    }

    public static function srcset(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        if ($host !== null && strcasecmp($host, request()->getHost()) !== 0) return '';
        $path = parse_url($url, PHP_URL_PATH);
        if (!is_string($path) || !preg_match('~^/storage/(page-images/[a-zA-Z0-9_-]+\.webp)$~', $path, $match)) return '';
        $disk = Storage::disk('public');
        $sources = [];
        $largestWidth = 0;
        foreach (self::WIDTHS as $width) {
            $variant = self::variantPath($match[1], $width);
            if ($disk->exists($variant)) {
                $sources[] = asset($disk->url($variant)) . ' ' . $width . 'w';
                $largestWidth = $width;
            }
        }
        if (!$sources || !$disk->exists($match[1])) return '';
        $dimensions = @getimagesize($disk->path($match[1]));
        if ($dimensions && $dimensions[0] > $largestWidth) {
            $sources[] = asset($url) . ' ' . $dimensions[0] . 'w';
        }
        return implode(', ', $sources);
    }

    private static function variantPath(string $path, int $width): string
    {
        return substr($path, 0, -5) . '-' . $width . 'w.webp';
    }
}
