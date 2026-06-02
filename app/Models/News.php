<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\NewsImage;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'announce', 'content', 'image', 'is_active', 'published_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'date'
    ];
    public function images()
    {
        return $this->hasMany(NewsImage::class)->orderBy('sort_order');
    }

    public function getFirstImageAttribute()
    {
        return $this->images->first();
    }
}