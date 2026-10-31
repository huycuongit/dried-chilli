<?php

namespace App\Console\Commands;

use App\Support\ResponsivePageImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GeneratePageImageVariants extends Command
{
    protected $signature = 'images:generate-page-variants';
    protected $description = 'Generate responsive versions of existing page images';

    public function handle()
    {
        $count = 0;
        $failures = 0;
        foreach (Storage::disk('public')->files('page-images') as $path) {
            if (!preg_match('~^page-images/[a-zA-Z0-9_-]+\.webp$~', $path) || preg_match('/-\d+w\.webp$/', $path)) continue;
            try {
                ResponsivePageImages::generate($path);
                $count++;
            } catch (\Throwable $exception) {
                $failures++;
                $this->error($path . ': ' . $exception->getMessage());
            }
        }
        $this->info("Processed {$count} images; {$failures} failed.");
        return $failures ? 1 : 0;
    }
}
