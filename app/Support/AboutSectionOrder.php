<?php

namespace App\Support;

class AboutSectionOrder
{
    public const STORAGE_KEY = 'nafu_home_about_section_order';

    public static function arrange(array $sections, ?string $saved): array
    {
        // The existing public page places custom sections before the closing call to action.
        $closing = $sections['About Us - Call to Action'] ?? null;
        unset($sections['About Us - Call to Action']);
        if ($closing !== null) $sections['About Us - Call to Action'] = $closing;

        $order = json_decode($saved ?? '', true);
        if (!is_array($order)) return $sections;
        $result = [];
        foreach ($order as $name) {
            if (is_string($name) && array_key_exists($name, $sections) && !array_key_exists($name, $result)) {
                $result[$name] = $sections[$name];
                if ($name === 'About Us - Why Trust Us' && !in_array('About Us - Customer reviews', $order, true) && isset($sections['About Us - Customer reviews'])) {
                    $result['About Us - Customer reviews'] = $sections['About Us - Customer reviews'];
                }
            }
        }
        foreach ($sections as $name => $fields) {
            if (!array_key_exists($name, $result)) $result[$name] = $fields;
        }
        return $result;
    }
}
