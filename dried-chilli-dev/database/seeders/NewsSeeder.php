<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        foreach (config('nafu-articles', []) as $position => $article) {
            if (DB::table('news')->where('slug', $article['slug'])->exists()) {
                continue;
            }
            DB::table('news')->insert([
                'name' => $article['name'],
                'slug' => $article['slug'],
                'category_name' => $article['category_name'],
                'avatar' => $article['avatar'],
                'description' => $article['description'],
                'content' => $article['content'],
                'publish_time' => $article['publish_time'] . ' 09:00:00',
                'active' => true,
                'position' => $position + 1,
                'views' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
