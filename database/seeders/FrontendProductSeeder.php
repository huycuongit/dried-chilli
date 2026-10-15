<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class FrontendProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'id' => 101,
                'name' => 'Starter Duo',
                'slug' => 'starter-duo',
                'price' => 34,
                'sale_price' => 28.9,
                'category_id' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 102,
                'name' => 'Four-Pack of Yum',
                'slug' => 'four-pack-of-yum',
                'price' => 60,
                'sale_price' => 51.0,
                'category_id' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 103,
                'name' => '6 Bundle Mix',
                'slug' => '6-bundle-mix',
                'price' => 90,
                'sale_price' => 76.5,
                'category_id' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 104,
                'name' => 'Premium Kashmiri Chilli Powder',
                'slug' => 'kashmiri-chilli',
                'price' => 15.0,
                'sale_price' => 12.5,
                'category_id' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 105,
                'name' => 'Organic Ground Turmeric',
                'slug' => 'turmeric',
                'price' => 9.0,
                'sale_price' => null,
                'category_id' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 106,
                'name' => 'Dried Whole Ghost Peppers',
                'slug' => 'whole-ghost',
                'price' => 18.5,
                'sale_price' => null,
                'category_id' => 1,
                'is_active' => 1,
            ]
        ];

        // Create a dummy category first just in case
        \App\Models\Category::updateOrCreate(['id' => 1], [
            'name' => 'Spices',
            'slug' => 'spices',
            'is_active' => 1
        ]);

        foreach ($products as $p) {
            Product::updateOrCreate(['id' => $p['id']], $p);
        }
    }
}
