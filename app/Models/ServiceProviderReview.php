<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'user_id',
        'comment',
        'rating',
    ];

    /**
     * The service provider being reviewed.
     */
    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    /**
     * The user who left this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
