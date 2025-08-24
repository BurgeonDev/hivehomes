<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    // Automatically set slug from name if not provided
    public static function booted()
    {
        static::creating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });

        static::updating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
