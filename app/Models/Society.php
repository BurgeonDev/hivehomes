<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'logo',
        'admin_user_id',
        'is_active'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class);
    }
}
