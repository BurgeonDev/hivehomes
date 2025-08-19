<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    // app/Models/Post.php
    protected $fillable = [
        'title',
        'body',
        'image',
        'status',
        'user_id',
        'society_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
}
