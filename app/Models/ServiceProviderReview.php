<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProviderReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_provider_id',
        'user_id',
        'comment',
        'rating',
    ];

    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
