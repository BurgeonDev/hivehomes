<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'society_id',
        'name',
        'type',
        'phone',
        'email',
        'cnic',
        'address',
        'bio',
        'profile_image',
        'is_approved',
        'is_active',
    ];

    /**
     * The reviews left for this provider.
     */
    public function reviews()
    {
        return $this->hasMany(ServiceProviderReview::class);
    }

    /**
     * Average rating from all reviews.
     */
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
}
