<?php

namespace App\Support;

class UploadLimits
{
    public static function bytes(string $setting): int
    {
        $value = trim((string) ini_get($setting));
        if ($value === '' || (float) $value <= 0) return 0;
        $multiplier = match (strtolower(substr($value, -1))) {
            'g' => 1024 ** 3,
            'm' => 1024 ** 2,
            'k' => 1024,
            default => 1,
        };
        return (int) ((float) $value * $multiplier);
    }

    public static function imageBytes(): int
    {
        $phpLimit = self::bytes('upload_max_filesize');
        $postLimit = self::bytes('post_max_size');
        $limits = [5 * 1024 * 1024];
        if ($phpLimit > 0) $limits[] = $phpLimit;
        if ($postLimit > 0) $limits[] = max(1024, $postLimit - 65536);
        return min($limits);
    }
}
