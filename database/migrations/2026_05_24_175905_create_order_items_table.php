<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица позиций заказа
     * Нужна потому что в одном заказе может быть несколько товаров
     * Связь с заказами и товарами
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();                                       // ID позиции
            $table->foreignId('order_id')                       // ссылка на заказ
                  ->constrained()                               // связь с orders.id
                  ->onDelete('cascade');                        // удалили заказ - удалили позиции
            $table->foreignId('product_id')                     // ссылка на товар
                  ->constrained()                               // связь с products.id
                  ->onDelete('cascade');
            $table->integer('quantity');                        // сколько штук купили
            $table->decimal('price', 10, 2);                    // цена на момент покупки (на случай, если потом цена изменится)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};