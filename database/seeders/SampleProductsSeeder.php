<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\System;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SampleProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create categories
        $categories = [
            'whole-chillies' => Category::updateOrCreate(
                ['slug' => 'whole-chillies'],
                ['name' => 'Whole Dried Chillies', 'is_active' => true]
            ),
            'flakes-powders' => Category::updateOrCreate(
                ['slug' => 'flakes-powders'],
                ['name' => 'Flakes & Powders', 'is_active' => true]
            ),
            'sauces-oils' => Category::updateOrCreate(
                ['slug' => 'sauces-oils'],
                ['name' => 'Artisanal Hot Sauces & Oils', 'is_active' => true]
            ),
            'spices-seasonings' => Category::updateOrCreate(
                ['slug' => 'spices-seasonings'],
                ['name' => 'Spices & Seasonings', 'is_active' => true]
            ),
        ];

        // 2. Sample Products with full attributes
        $now = Carbon::now();
        $products = [
            // Best Sellers
            [
                'name' => 'Dried Ancho Chilies',
                'category_slug' => 'whole-chillies',
                'price' => 12.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => true,
                'image' => 'images/cat_chillies.jpg',
                'stock' => 50,
                'description' => 'Mild, sweet, and smoky sun-dried poblano chilies. Perfect for authentic Mexican mole, enchiladas, and braised meats.'
            ],
            [
                'name' => 'Ghost Pepper Flakes',
                'category_slug' => 'flakes-powders',
                'price' => 15.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => true,
                'image' => 'images/cat_powders.jpg',
                'stock' => 35,
                'description' => 'Fiery Bhut Jolokia flakes for true chili lovers. Adds an explosive kick to pizzas, pastas, and stir-fries.'
            ],
            [
                'name' => 'Smoked Paprika Blend',
                'category_slug' => 'spices-seasonings',
                'price' => 9.50,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => true,
                'image' => 'images/cat_blends.jpg',
                'stock' => 45,
                'description' => 'Oak-smoked pimentón ground to perfection. Imparts a deep, woody aroma and brilliant red color to any dish.'
            ],
            [
                'name' => 'Sichuan Peppercorns',
                'category_slug' => 'whole-chillies',
                'price' => 14.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => true,
                'image' => 'images/product_hero.png',
                'stock' => 40,
                'description' => 'Authentic red Sichuan peppercorns with a distinctive citrusy aroma and characteristic mouth-tingling numbness.'
            ],

            // Daily Flash Sale Products (Appears on Sale Page Flash Sale with Countdown)
            [
                'name' => 'Habanero Hot Sauce',
                'category_slug' => 'sauces-oils',
                'price' => 11.00,
                'sale_price' => 8.50,
                'is_sale' => true,
                'is_limited_sale' => false,
                'sale_type' => 'daily_flash',
                'sale_start_date' => $now->copy()->subHours(6),
                'sale_end_date' => $now->copy()->addHours(24),
                'is_best_seller' => false,
                'image' => 'images/product_hero.png',
                'stock' => 25,
                'description' => 'Bright, fiery habanero mash balanced with tangy citrus and fresh aromatics. Ideal for tacos, wings, and eggs.'
            ],
            [
                'name' => 'Jalapeno Green Powder',
                'category_slug' => 'flakes-powders',
                'price' => 8.00,
                'sale_price' => 6.00,
                'is_sale' => true,
                'is_limited_sale' => false,
                'sale_type' => 'daily_flash',
                'sale_start_date' => $now->copy()->subHours(4),
                'sale_end_date' => $now->copy()->addHours(20),
                'is_best_seller' => false,
                'image' => 'images/cat_powders.jpg',
                'stock' => 30,
                'description' => 'Dehydrated green jalapeño peppers ground into a zesty, mildly spicy seasoning powder.'
            ],

            // Limited Big Sale Products (Appears on Sale Page Big Sale Tier)
            [
                'name' => 'Extra Garlic Chili Crunch',
                'category_slug' => 'sauces-oils',
                'price' => 22.00,
                'sale_price' => 18.00,
                'is_sale' => true,
                'is_limited_sale' => true,
                'sale_type' => 'limited_big',
                'sale_start_date' => $now->copy()->subDays(2),
                'sale_end_date' => $now->copy()->addDays(7),
                'is_best_seller' => false,
                'image' => 'images/product_khong_nen.png',
                'stock' => 60,
                'description' => 'Crispy fried shallots, roasted garlic, and crunchy crushed chilies submerged in rich infused umami oil.'
            ],
            [
                'name' => 'Crispy Shrimp Chili Oil',
                'category_slug' => 'sauces-oils',
                'price' => 24.00,
                'sale_price' => 19.50,
                'is_sale' => true,
                'is_limited_sale' => true,
                'sale_type' => 'limited_big',
                'sale_start_date' => $now->copy()->subDays(1),
                'sale_end_date' => $now->copy()->addDays(10),
                'is_best_seller' => true,
                'image' => 'images/shrimp_chilli.png',
                'stock' => 50,
                'description' => 'Premium dried shrimp wok-fried with fiery crushed chilies and shallots in fragrant sesame chili oil.'
            ],
            [
                'name' => 'Starter Duo Gift Pack',
                'category_slug' => 'spices-seasonings',
                'price' => 34.00,
                'sale_price' => 28.90,
                'is_sale' => true,
                'is_limited_sale' => true,
                'sale_type' => 'limited_big',
                'sale_start_date' => $now->copy()->subDays(1),
                'sale_end_date' => $now->copy()->addDays(14),
                'is_best_seller' => true,
                'image' => 'images/product_hero.png',
                'stock' => 40,
                'description' => 'Our two bestselling jars paired in a gift-ready kraft box with custom recipe cards.'
            ],

            // Regular Pantry Staples
            [
                'name' => 'Chipotle Meco Pods',
                'category_slug' => 'whole-chillies',
                'price' => 16.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => false,
                'image' => 'images/cat_chillies.jpg',
                'stock' => 20,
                'description' => 'Slow-smoked ripe jalapeños with an intensely smoky and earthy flavor profile for authentic chili con carne.'
            ],
            [
                'name' => 'Bird\'s Eye Thai Chili',
                'category_slug' => 'whole-chillies',
                'price' => 13.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => false,
                'image' => 'images/product_hero.png',
                'stock' => 35,
                'description' => 'Pungent, highly fiery small red chilies from Southeast Asia. Packs an immediate intense heat.'
            ],
            [
                'name' => 'Carolina Reaper Pods',
                'category_slug' => 'whole-chillies',
                'price' => 25.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => false,
                'image' => 'images/cat_chillies.jpg',
                'stock' => 15,
                'description' => 'The legendary record-breaking hot chili pepper. Handle with extreme care and use sparingly!'
            ],
            [
                'name' => 'Crushed Red Pepper Flakes',
                'category_slug' => 'flakes-powders',
                'price' => 5.00,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => false,
                'image' => 'images/cat_powders.jpg',
                'stock' => 80,
                'description' => 'Classic pizzeria-style chili flakes. A versatile pantry staple for every kitchen.'
            ],
            [
                'name' => 'Cayenne Pepper Powder',
                'category_slug' => 'flakes-powders',
                'price' => 6.50,
                'sale_price' => null,
                'is_sale' => false,
                'is_limited_sale' => false,
                'sale_type' => 'none',
                'sale_start_date' => null,
                'sale_end_date' => null,
                'is_best_seller' => false,
                'image' => 'images/cat_powders.jpg',
                'stock' => 70,
                'description' => 'Fine-milled cayenne pepper providing clean, direct heat without altering the dish flavor profile.'
            ],
        ];

        // 3. Upsert into Database
        foreach ($products as $p) {
            $cat = $categories[$p['category_slug']] ?? $categories['spices-seasonings'];
            $slug = Str::slug($p['name']);

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $cat->id,
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'],
                    'is_sale' => $p['is_sale'],
                    'is_limited_sale' => $p['is_limited_sale'],
                    'sale_type' => $p['sale_type'],
                    'sale_start_date' => $p['sale_start_date'],
                    'sale_end_date' => $p['sale_end_date'],
                    'is_best_seller' => $p['is_best_seller'],
                    'is_active' => true,
                    'image' => $p['image'],
                    'description' => $p['description'],
                ]
            );

            Inventory::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $p['stock'],
                    'low_stock_threshold' => 5,
                ]
            );
        }

        // 4. Ensure Big Sale is enabled in System settings
        System::updateOrCreate(
            ['key' => 'nafu_home_sale_page_active_big_sale'],
            ['content' => '1', 'active' => true]
        );
        System::updateOrCreate(
            ['key' => 'nafu_home_sale_page_title'],
            ['content' => 'SUPER HOT DEALS', 'active' => true]
        );
    }
}
