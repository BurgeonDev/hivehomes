<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProviderType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function providers()
    {
        return $this->hasMany(ServiceProvider::class, 'type_id');
    }
}
