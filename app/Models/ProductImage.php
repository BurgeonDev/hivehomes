<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'order', 'is_primary'];
    protected $casts = ['is_primary' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // helper url
    public function url()
    {
        return asset('storage/' . $this->path);
    }
}
