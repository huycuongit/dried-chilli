<?php

namespace App\Support;

class AboutPageContent
{
    public static function value(string $key, array $fields, array $settings): string
    {
        $storedKey = 'nafu_home_' . $key;
        if (array_key_exists($storedKey, $settings) && $settings[$storedKey] !== null) {
            return (string) $settings[$storedKey];
        }
        $field = $fields[$key] ?? [];
        if (isset($field['parts'])) {
            $parts = array_map(static function ($part) use ($fields, $settings) {
                return (string) ($settings['nafu_home_' . $part] ?? $fields[$part]['value'] ?? '');
            }, $field['parts']);
            return implode(' ', $parts) . ($field['suffix'] ?? '');
        }
        return (string) ($field['value'] ?? '');
    }
}
