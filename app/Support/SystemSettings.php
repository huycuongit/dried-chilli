<?php

namespace App\Support;

use App\Models\System;

class SystemSettings
{
    private $values;

    /**
     * Load system settings once for the current request.
     */
    public function all(): array
    {
        if ($this->values === null) {
            $this->values = System::query()
                ->pluck('content', 'key')
                ->all();
        }

        return $this->values;
    }

    public function get(string $key, $default = null)
    {
        $values = $this->all();
        $value = $values[$key] ?? null;

        return $value !== null && $value !== '' ? $value : $default;
    }

    public function localized(string $key, string $locale, $default = null)
    {
        $value = $this->get($key, $default);

        if (is_array($value)) {
            return $value[$locale] ?? $default;
        }

        return $value;
    }

    /**
     * Resolve page content from systems; config only supplies field metadata/defaults.
     */
    public function page(string $page, string $key, string $locale, $default = '')
    {
        $pageSchema = config("page-content.{$page}", []);
        $prefix = $pageSchema['prefix'] ?? "page_{$page}";

        return $this->localized("{$prefix}_{$key}_{$locale}", $locale, $default);
    }

    public function forget(): void
    {
        $this->values = null;
    }
}
