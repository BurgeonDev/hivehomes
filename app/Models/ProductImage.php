<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'order', 'is_primary'];
    protected $casts = ['is_primary' => 'boolean'];

    // ensure 'url' is included when model is converted to array/JSON
    protected $appends = ['url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // accessor: $image->url
    public function getUrlAttribute()
    {
        if (!$this->path) return null;

        // This uses the configured disk's url (public disk -> /storage/...)
        return Storage::url($this->path);
    }
}
