<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        $order = 1000;

        foreach (config('page-content', []) as $page) {
            $prefix = $page['prefix'];

            foreach (($page['sections'] ?? []) as $fields) {
                foreach ($fields as $key => $field) {
                    foreach (['en'] as $locale) {
                        System::firstOrCreate(
                            ['key' => "{$prefix}_{$key}_{$locale}"],
                            [
                                'content' => $field[$locale] ?? '',
                                'active' => true,
                                'order' => $order++,
                            ]
                        );
                    }
                }
            }
        }
    }
}
