<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица товаров интернет-магазина
     * Здесь будут храниться все товары: название, цена, остаток и т.д.
     * Связь с категориями через category_id
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                   // ID товара
            $table->foreignId('category_id')                // внешний ключ на категорию
                  ->constrained()                           // ссылается на categories.id
                  ->onDelete('cascade');                    // если удалили категорию, товары тоже удаляем
            $table->string('name');                         // название товара
            $table->string('slug')->unique();               // url-псевдоним
            $table->text('description')->nullable();        // описание товара
            $table->text('specifications')->nullable();     // характеристики (часто пихают JSON, пока текст)
            $table->decimal('price', 10, 2);                // цена, 10 цифр всего, 2 после запятой
            $table->integer('stock')->default(0);           // остаток на складе
            $table->string('image')->nullable();            // путь к картинке товара
            $table->boolean('is_active')->default(true);    // виден товар или скрыт
            $table->boolean('is_featured')->default(false); // рекомендуемый товар (на главную)
            $table->timestamps();                           // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};