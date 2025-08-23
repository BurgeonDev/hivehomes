<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function providers()
    {
        return $this->hasMany(ServiceProvider::class, 'type_id');
    }
}
