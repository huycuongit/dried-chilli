<?php

namespace App\Support;

class PagePaths
{
    public static function map(): PagePathMap
    {
        $state = json_decode((string) app(SystemSettings::class)->get('public_page_paths', '{}'), true);
        return new PagePathMap(is_array($state) ? $state : []);
    }

    public static function url(string $name, $parameters = [], bool $absolute = true): string
    {
        $page = $name === 'home' ? 'home' : explode('.', $name)[0];
        if (!in_array($name, ['home', 'services.index', 'services.show', 'news.index', 'news.show', 'projects.index', 'projects.show'], true)) {
            return route($name, $parameters, $absolute);
        }
        $parameters = is_array($parameters) ? $parameters : ['slug' => $parameters];
        $locale = 'en';
        $path = '';
        $segment = $page === 'services' ? 'services' : self::map()->current($page, $locale);
        if ($segment !== '') { $path .= '/' . $segment; }
        if (substr($name, -5) === '.show') {
            $path .= '/' . rawurlencode((string) ($parameters['slug'] ?? $parameters[0] ?? ''));
        }
        if ($path === '') { $path = '/'; }
        unset($parameters['locale'], $parameters['slug'], $parameters[0]);
        $url = $absolute ? url($path) : $path;
        return $parameters ? $url . '?' . http_build_query($parameters) : $url;
    }
}
