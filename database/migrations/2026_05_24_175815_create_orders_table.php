<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица заказок
     * Сюда попадают  данные из формы оформления заказа
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();                                 // номер заказа
            $table->string('customer_name');              // имя покупателя
            $table->string('customer_phone');             // телефон
            $table->string('customer_email')->nullable(); // email (необязательно)
            $table->text('customer_comment')->nullable(); // комментарий к заказу
            $table->decimal('total_amount', 10, 2);       // общая сумма заказа
            $table->string('delivery_method')->nullable(); // способ доставки
            $table->string('payment_method')->nullable();  // способ оплаты
            $table->enum('status', ['new', 'processing', 'completed', 'cancelled'])
                  ->default('new');                       // статус заказа
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};