<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic as Image;

class Base64ImageStore
{
    public static function store(string $value, string $directory): string
    {
        if (!preg_match('/^data:image\/(jpeg|png|webp|gif);base64,(.+)$/s', $value, $matches)) {
            throw ValidationException::withMessages(['image' => 'Please select a valid JPG, PNG, GIF or WEBP image.']);
        }
        $binary = base64_decode($matches[2], true);
        if ($binary === false || strlen($binary) > 5 * 1024 * 1024) {
            throw ValidationException::withMessages(['image' => 'The image must not exceed 5 MB.']);
        }
        try {
            $image = Image::make($binary)->orientate();
        } catch (\Throwable) {
            throw ValidationException::withMessages(['image' => 'The selected image could not be processed.']);
        }
        $image->resize(1800, 1800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $path = trim($directory, '/') . '/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($path, (string) $image->encode('webp', 84));
        if (trim($directory, '/') === 'page-images') {
            try {
                ResponsivePageImages::generate($path);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }
        return Storage::disk('public')->url($path);
    }
}
