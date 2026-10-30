<?php

namespace App\Support;

class PageContentGroups
{
    public static function fromSections(array $sections): array
    {
        $pageNames = ['Services', 'Service Details', 'Projects', 'Project Details', 'News', 'News Details', 'Contact', 'Sale', 'About Us', 'Our Legacy', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds', 'FAQ', '404'];
        $pages = ['Home' => []];
        foreach ($sections as $section => $fields) {
            $matchedPage = null;
            foreach ($pageNames as $pageName) {
                if (str_starts_with($section, $pageName)) {
                    $matchedPage = $pageName;
                    break;
                }
            }
            $pages[$matchedPage ?? 'Home'][$section] = $fields;
        }
        return $pages;
    }

    public static function all(): array
    {
        return self::fromSections(json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR));
    }
}
