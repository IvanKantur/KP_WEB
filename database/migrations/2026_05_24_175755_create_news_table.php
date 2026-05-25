<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица для новостей и акций
     * Будет выводиться на главной и в разделе новостей
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();                           // ID новости
            $table->string('title');                // заголовок новости
            $table->string('slug')->unique();       // url-псевдоним
            $table->text('announce')->nullable();   // краткий анонс (для списка новостей)
            $table->longText('content')->nullable(); // полный текст новости
            $table->string('image')->nullable();    // картинка-превью
            $table->boolean('is_active')->default(true); // опубликовано или черновик
            $table->date('published_at')->nullable();    // дата публикации (можно запланировать)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};