<?php

namespace App\Console\Commands;

use App\Support\ResponsiveProductImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateProductImageVariants extends Command
{
    protected $signature = 'images:generate-product-variants';
    protected $description = 'Generate responsive versions of existing product images';

    public function handle()
    {
        $count = 0;
        $failures = 0;
        foreach (Storage::disk('public')->files('products') as $path) {
            if (!preg_match('~^products/[a-zA-Z0-9_-]+\.(?:png|jpe?g|webp|gif)$~i', $path)) continue;
            try {
                ResponsiveProductImages::generate($path);
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
