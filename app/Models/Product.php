<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CascadesSoftDeletes;

class Product extends Model
{
    use SoftDeletes, CascadesSoftDeletes;

    protected $fillable = [
        'society_id',
        'user_id',
        'title',
        'description',
        'category_id',
        'price',
        'quantity',
        'condition',
        'is_negotiable',
        'is_featured',
        'featured_until',
        'status'
    ];

    protected $casts = [
        'is_negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    /**
     * Cascade soft deletes:
     * - images: delete/restore product images together with the product
     */
    protected $cascadeDeletes = [
        'images',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
