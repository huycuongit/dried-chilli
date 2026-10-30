<?php

namespace App\Support;

class WebsiteContractTemplate
{
    public static function resolve(?string $text, array $details, string $effectiveDate): string
    {
        $details['EFFECTIVE_DATE'] = $effectiveDate;
        return preg_replace_callback('/\[([A-Z_]+)\]/', function ($match) use ($details) {
            return isset($details[$match[1]]) && trim((string) $details[$match[1]]) !== ''
                ? $details[$match[1]] : $match[0];
        }, $text ?? '');
    }

    public static function incomplete(string $resolvedText, ?array $details, array $groups): bool
    {
        if ($details !== null) {
            foreach ($groups as $fields) {
                foreach ($fields as $key => $label) {
                    $value = trim((string) ($details[$key] ?? ''));
                    if ($value === '' || preg_match('/\[[A-Z_]+\]/', $value)) {
                        return true;
                    }
                }
            }
        }
        return (bool) preg_match('/\[[A-Z_]+\]/', $resolvedText);
    }
}
