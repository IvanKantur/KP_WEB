<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // Разрешаем массовое заполнение
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'image',
    ];

    // Поля, которые будут преобразованы в даты
    protected $dates = ['deleted_at'];

    // Связь с товарами
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}