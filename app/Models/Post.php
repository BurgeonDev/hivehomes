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
        'society_id',
        'category_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'post_user_likes')
            ->withTimestamps();
    }
}
