<?php

namespace App\Support;

class PageContentGroups
{
    public const CUSTOM_PAGES = ['About Us', 'Our Legacy', 'Sale', 'Product Details', 'FAQ', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds'];

    public static function fromSections(array $sections): array
    {
        $pageNames = ['Product Details', 'Services', 'Service Details', 'Projects', 'Project Details', 'News', 'News Details', 'Contact', 'Sale', 'About Us', 'Our Legacy', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds', 'FAQ', '404'];
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
        return self::fromSections(self::sections());
    }

    public static function sections(): array
    {
        $sections = json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        $about = json_decode(file_get_contents(config_path('about-layout.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($about as &$fields) {
            $fields = array_filter($fields, fn ($field) => empty($field['editor_hidden']));
        }
        unset($fields);
        $custom = [];
        foreach (self::CUSTOM_PAGES as $page) $custom += self::customPageSections($page, $sections);
        $result = [];
        $inserted = false;
        foreach ($sections as $name => $fields) {
            if ((string) $name === '404') $name = '404 - Error page';
            if (str_starts_with($name, 'About Us - ')) {
                if (!$inserted) {
                    $result = array_merge($result, $about);
                    $inserted = true;
                }
                continue;
            }
            foreach (self::CUSTOM_PAGES as $page) {
                if (str_starts_with($name, $page . ' - Section ')) continue 2;
            }
            $result[$name] = $fields;
        }
        if (!$inserted) $result = array_merge($result, $about);
        $oldGroups = self::fromSections($result);
        foreach (array_keys($oldGroups['Home'] ?? []) as $name) unset($result[$name]);
        foreach (['Our Legacy', 'Privacy Policy', 'Terms of Service', 'Shipping & Refunds', 'FAQ'] as $page) {
            foreach ($oldGroups[$page] ?? [] as $name => $fields) {
                if ($page !== 'Our Legacy' && $name === $page . ' - Hero') {
                    $result[$name] = array_filter($fields, fn ($key) => preg_match('/_(?:badge|title|subtitle|desc|stat[123]_(?:title|desc))$/', $key), ARRAY_FILTER_USE_KEY);
                    continue;
                }
                unset($result[$name]);
            }
        }
        $publicLayout = json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR);
        $result = array_merge($result, $publicLayout);
        foreach ($custom as $name => $fields) {
            foreach ($fields as $key => &$field) {
                if (str_ends_with($key, '_type')) $field['type'] = 'fixed';
            }
            unset($field);
            foreach ($fields as $key => $field) {
                if (!str_ends_with($key, '_active')) continue;
                unset($fields[$key]);
                $publishedKey = substr($key, 0, -7) . '_published';
                $fields = [$publishedKey => [
                    'value' => '0', 'label' => 'Publish this additional section', 'type' => 'select',
                    'options' => ['0' => 'Hidden', '1' => 'Published'],
                ]] + $fields;
                break;
            }
            $result[$name] = $fields;
        }
        return $result;
    }

    public static function customAboutSections(?array $sections = null): array
    {
        return self::customPageSections('About Us', $sections);
    }

    public static function customSchemaKey(string $page): string
    {
        if (!in_array($page, self::CUSTOM_PAGES, true)) throw new \InvalidArgumentException('Unsupported page.');
        return $page === 'About Us' ? 'about_custom_sections_schema' : 'page_custom_sections_' . \Illuminate\Support\Str::slug($page, '_');
    }

    public static function customPageSections(string $page, ?array $sections = null): array
    {
        $saved = app(SystemSettings::class)->get(self::customSchemaKey($page));
        if ($saved !== null) return json_decode($saved, true, 512, JSON_THROW_ON_ERROR);
        $sections = $sections ?? json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        return array_filter($sections, fn ($name) => str_starts_with($name, $page . ' - Section '), ARRAY_FILTER_USE_KEY);
    }
}
