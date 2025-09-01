<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CascadesSoftDeletes;

class Society extends Model
{
    use SoftDeletes, CascadesSoftDeletes;

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

    /**
     * Relations that should be cascaded when a society is deleted/restored.
     * - users: members of the society
     * - products: marketplace items belonging to this society
     * - serviceProviders: service providers registered under this society
     * - posts: posts associated with this society
     *
     * The CascadesSoftDeletes trait will:
     *  - on soft-delete: soft-delete active children and set deleted_by_parent_at
     *  - on restore: restore children that have deleted_by_parent_at set (and whose own parents are active)
     *  - on forceDelete: permanently remove children
     */
    protected $cascadeDeletes = [
        'users',
        'products',
        'serviceProviders',
        'posts',
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
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
