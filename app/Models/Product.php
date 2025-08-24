<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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

    // Scopes
    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }
    public function scopeForSociety($q, $societyId)
    {
        return $q->where('society_id', $societyId);
    }
    public function scopeSearch($q, $term)
    {
        if (!$term) return $q;
        return $q->where('title', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%");
    }
}
