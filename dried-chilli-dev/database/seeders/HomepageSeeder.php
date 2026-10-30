<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        $sections = json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($sections as $fields) {
            foreach ($fields as $key => $field) {
                if (!DB::table('systems')->where('key', 'nafu_home_'.$key)->exists()) {
                    DB::table('systems')->insert([
                        'key' => 'nafu_home_'.$key,
                        'content' => html_entity_decode($field['value'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}