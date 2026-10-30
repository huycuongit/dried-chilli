<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class SampleProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create a default category
        $category = Category::firstOrCreate(
            ['slug' => 'spices'],
            ['name' => 'Spices & Seasonings', 'is_active' => true]
        );

        // 2. Define 12 sample products
        $products = [
            // 4 Best Sellers
            ['name' => 'Dried Ancho Chilies', 'price' => 12.00, 'sale_price' => null, 'is_best_seller' => true],
            ['name' => 'Ghost Pepper Flakes', 'price' => 15.00, 'sale_price' => null, 'is_best_seller' => true],
            ['name' => 'Smoked Paprika Blend', 'price' => 9.50, 'sale_price' => null, 'is_best_seller' => true],
            ['name' => 'Sichuan Peppercorns', 'price' => 14.00, 'sale_price' => null, 'is_best_seller' => true],
            
            // 3 Sale Products
            ['name' => 'Extra Garlic Crunch', 'price' => 22.00, 'sale_price' => 18.00, 'is_best_seller' => false],
            ['name' => 'Habanero Hot Sauce', 'price' => 11.00, 'sale_price' => 8.50, 'is_best_seller' => false],
            ['name' => 'Jalapeno Powder', 'price' => 8.00, 'sale_price' => 6.00, 'is_best_seller' => false],
            
            // 5 Regular Products
            ['name' => 'Crushed Red Pepper', 'price' => 5.00, 'sale_price' => null, 'is_best_seller' => false],
            ['name' => 'Cayenne Pepper', 'price' => 6.50, 'sale_price' => null, 'is_best_seller' => false],
            ['name' => 'Chipotle Meco', 'price' => 16.00, 'sale_price' => null, 'is_best_seller' => false],
            ['name' => 'Bird\'s Eye Chili', 'price' => 13.00, 'sale_price' => null, 'is_best_seller' => false],
            ['name' => 'Carolina Reaper Pods', 'price' => 25.00, 'sale_price' => null, 'is_best_seller' => false],
        ];

        // 3. Insert into Database
        foreach ($products as $p) {
            $product = Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'],
                    'is_best_seller' => $p['is_best_seller'],
                    'is_active' => true,
                    'description' => 'A delicious sample product to spice up your life.'
                ]
            );

            \App\Models\Inventory::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => 30,
                    'low_stock_threshold' => 5,
                ]
            );
        }
    }
}
