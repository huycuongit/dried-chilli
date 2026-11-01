<?php

namespace App\Support;

class AboutReviewers
{
    public const STORAGE_KEY = 'nafu_home_about_reviewers';

    public static function read(?string $json): array
    {
        $rows = json_decode($json ?? '', true);
        if (!is_array($rows) || !array_is_list($rows)) return [];
        return array_values(array_filter($rows, 'is_array'));
    }

    public static function isSafeImage($value): bool
    {
        return is_string($value) && preg_match('~^(?:/(?!/)|https?://)~i', trim($value)) === 1;
    }
}
