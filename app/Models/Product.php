<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'specifications',
        'price',
        'stock',
        'image',
        'is_active',
        'is_featured',
    ];

    // Связь с категорией (товар принадлежит категории)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}