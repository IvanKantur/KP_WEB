<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создаем таблицу категорий товаров
     * Нужна для группировки товаров: процессоры, видеокарты и т.д.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                           // первичный ключ, автоинкремент
            $table->string('name');                 // название категории, например "Процессоры"
            $table->string('slug')->unique();       // url-псевдоним, чтобы в адресной строке было /catalog/processors
            $table->text('description')->nullable(); // описание категории, может быть пустым
            $table->integer('sort_order')->default(0); // порядок сортировки, чтобы выводить в нужной последовательности
            $table->timestamps();                   // created_at и updated_at автоматически
        });
    }

    /**
     * Откат миграции - удаляем таблицу
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};