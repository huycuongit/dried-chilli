<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ResponsiveProductImages
{
    private const WIDTHS = [320, 640];

    public static function generate(string $path): void
    {
        $disk = Storage::disk('public');
        if (!preg_match('~^products/[a-zA-Z0-9_-]+\.(?:png|jpe?g|webp|gif)$~i', $path) || !$disk->exists($path)) return;
        $original = Image::make($disk->get($path));
        foreach (self::WIDTHS as $width) {
            if ($original->width() < $width) continue;
            $image = clone $original;
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if (!$disk->put(self::variantPath($path, $width), (string) $image->encode('webp', 78))) {
                throw new \RuntimeException('Failed to write product image variant: ' . $path);
            }
        }
    }

    public static function srcset(?string $path): string
    {
        if (!$path || !preg_match('~^storage/(products/[a-zA-Z0-9_-]+\.(?:png|jpe?g|webp|gif))$~i', $path, $match)) return '';
        $disk = Storage::disk('public');
        $sources = [];
        foreach (self::WIDTHS as $width) {
            $variant = self::variantPath($match[1], $width);
            if ($disk->exists($variant)) $sources[] = asset($disk->url($variant)) . ' ' . $width . 'w';
        }
        if ($sources && $disk->exists($match[1])) {
            $dimensions = @getimagesize($disk->path($match[1]));
            $largest = $disk->exists(self::variantPath($match[1], 640)) ? 640 : 320;
            if ($dimensions && $dimensions[0] > $largest) $sources[] = asset($disk->url($match[1])) . ' ' . $dimensions[0] . 'w';
        }
        return implode(', ', $sources);
    }

    public static function deleteVariants(string $path): void
    {
        if (!preg_match('~^products/[a-zA-Z0-9_-]+\.(?:png|jpe?g|webp|gif)$~i', $path)) return;
        foreach (self::WIDTHS as $width) Storage::disk('public')->delete(self::variantPath($path, $width));
    }

    private static function variantPath(string $path, int $width): string
    {
        return $path . '-' . $width . 'w.webp';
    }
}
