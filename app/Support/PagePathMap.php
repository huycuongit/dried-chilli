<?php

namespace App\Support;

use InvalidArgumentException;

class PagePathMap
{
    public const DEFAULTS = ['home' => '', 'services' => 'services', 'news' => 'news', 'projects' => 'projects'];

    public function __construct(private array $state = []) {}

    public function current(string $page, string $locale): string
    {
        return $this->state['paths'][$locale][$page] ?? self::DEFAULTS[$page];
    }

    public function resolve(string $path, string $locale): ?string
    {
        foreach (self::DEFAULTS as $page => $default) {
            if ($path === $this->current($page, $locale) || $path === $default || in_array($path, $this->state['history'][$locale][$page] ?? [], true)) {
                return $page;
            }
        }
        return null;
    }

    public function updated(array $input): array
    {
        $state = $this->state;
        foreach (['en'] as $locale) {
            $used = [];
            foreach (self::DEFAULTS as $page => $default) {
                $path = trim((string) (array_key_exists($locale, $input[$page] ?? []) ? $input[$page][$locale] : $this->current($page, $locale)));
                if ($page !== 'home' && $path === '') { $path = $default; }
                if (strlen($path) > 100 || ($path !== '' && !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D', $path))) {
                    throw new InvalidArgumentException("The {$page} path may contain lowercase letters, numbers and hyphens only, up to 100 characters.");
                }
                $owner = $this->resolve($path, $locale);
                if (($owner !== null && $owner !== $page) || isset($used[$path])) {
                    throw new InvalidArgumentException("The path /{$path} conflicts with another page or a previous page path.");
                }
                $used[$path] = $page;
                $history = $state['history'][$locale][$page] ?? [];
                $history[] = $this->current($page, $locale);
                $state['history'][$locale][$page] = array_values(array_unique($history));
                $state['paths'][$locale][$page] = $path;
            }
        }
        return $state;
    }
}
