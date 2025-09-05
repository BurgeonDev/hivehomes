<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CascadesSoftDeletes;

class ServiceProvider extends Model
{
    use HasFactory, SoftDeletes, CascadesSoftDeletes;

    protected $fillable = [
        'society_id',
        'name',
        'type_id',
        'phone',
        'email',
        'cnic',
        'address',
        'bio',
        'profile_image',
        'is_approved',
        'is_active',
        'created_by',
    ];

    /**
     * Cascade delete reviews when provider is deleted.
     */
    protected $cascadeDeletes = ['reviews'];

    public function reviews()
    {
        return $this->hasMany(ServiceProviderReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : asset('images/default-avatar.png');
    }

    public function type()
    {
        return $this->belongsTo(ServiceProviderType::class, 'type_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
