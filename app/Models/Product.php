<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Поля, разрешенные для массового заполнения
     */
    protected $fillable = [
        'category_id',      // ID категории
        'name',             // Название товара
        'slug',             // URL-псевдоним
        'description',      // Описание
        'specifications',   // Характеристики
        'price',            // Цена
        'stock',            // Остаток на складе
        'image',            // Путь к картинке
        'is_active',        // Активен (виден на сайте)
        'is_featured',      // Рекомендуемый (на главную)
    ];

    /**
     * Поля, которые должны быть преобразованы в определенные типы
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Связь с категорией (товар принадлежит категории)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с позициями заказа
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Получить цену с форматированием
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }

    /**
     * Проверить, есть ли товар в наличии
     */
    public function inStock()
    {
        return $this->stock > 0 && $this->is_active;
    }
}