<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::create([
            'title' => 'Скидки на видеокарты до 20%',
            'slug' => 'discount-video-cards-20',
            'announce' => 'Только до конца месяца скидки на все видеокарты NVIDIA и AMD',
            'content' => 'Подробное описание акции...',
            'is_active' => true,
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Поступление новых процессоров Intel',
            'slug' => 'new-intel-processors',
            'announce' => 'В продажу поступили процессоры Intel Core 14-го поколения',
            'content' => 'Характеристики и цены...',
            'is_active' => true,
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'График работы в праздничные дни',
            'slug' => 'holiday-schedule',
            'announce' => 'Уважаемые клиенты, ознакомьтесь с графиком работы магазина',
            'content' => 'Магазин работает...',
            'is_active' => true,
            'published_at' => now(),
        ]);
    }
}