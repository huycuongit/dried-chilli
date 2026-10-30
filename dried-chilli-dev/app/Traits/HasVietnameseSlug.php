<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasVietnameseSlug
{
    public static function bootHasVietnameseSlug()
    {
        static::saving(function ($model) {
            if (!$model->slug_vi && trim((string) $model->name_vi) !== '') {
                $base = Str::substr(Str::slug($model->name_vi, '-', 'vi') ?: 'bai-viet', 0, 240);
                $model->slug_vi = $model->makeUniqueSlug(
                    $base, $model->getTable(), 'slug_vi', $model->getKey()
                );
            }
        });
    }

    public function localizedSlug(?string $locale = null): string
    {
        return ($locale ?? app()->getLocale()) === 'vi'
            ? ($this->slug_vi ?: $this->slug)
            : $this->slug;
    }

    public function scopeForLocalizedSlug($query, string $slug, string $locale)
    {
        // Prefer the requested language when an old English slug overlaps.
        $column = $locale === 'vi' ? 'slug_vi' : 'slug';
        return $query->where(function ($query) use ($slug) {
            $query->where('slug', $slug)->orWhere('slug_vi', $slug);
        })->orderByRaw("CASE WHEN {$column} = ? THEN 0 ELSE 1 END", [$slug]);
    }
}
