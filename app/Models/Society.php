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
        'admin_user_id'
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
}
