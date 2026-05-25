<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Добавляем тестовые категории товаров
     * Для компьютерной тематики
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Процессоры', 'slug' => 'processors', 'sort_order' => 1],
            ['name' => 'Видеокарты', 'slug' => 'video-cards', 'sort_order' => 2],
            ['name' => 'Материнские платы', 'slug' => 'motherboards', 'sort_order' => 3],
            ['name' => 'Оперативная память', 'slug' => 'ram', 'sort_order' => 4],
            ['name' => 'Накопители SSD/HDD', 'slug' => 'drives', 'sort_order' => 5],
            ['name' => 'Ноутбуки', 'slug' => 'notebooks', 'sort_order' => 6],
            ['name' => 'Периферия', 'slug' => 'peripherals', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}