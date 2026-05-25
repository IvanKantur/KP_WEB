<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Находим ID категорий
        $cpu = Category::where('slug', 'processors')->first()->id;
        $gpu = Category::where('slug', 'video-cards')->first()->id;
        $laptop = Category::where('slug', 'notebooks')->first()->id;

        $products = [
            [
                'category_id' => $cpu,
                'name' => 'Intel Core i5-13400',
                'slug' => 'intel-core-i5-13400',
                'price' => 18500,
                'stock' => 15,
                'is_featured' => true,
            ],
            [
                'category_id' => $cpu,
                'name' => 'AMD Ryzen 5 7600',
                'slug' => 'amd-ryzen-5-7600',
                'price' => 19200,
                'stock' => 8,
                'is_featured' => true,
            ],
            [
                'category_id' => $gpu,
                'name' => 'RTX 4060 8GB',
                'slug' => 'rtx-4060-8gb',
                'price' => 34900,
                'stock' => 5,
                'is_featured' => true,
            ],
            [
                'category_id' => $laptop,
                'name' => 'Honor MagicBook 16',
                'slug' => 'honor-magicbook-16',
                'price' => 69900,
                'stock' => 3,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}