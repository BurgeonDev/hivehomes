<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CascadesSoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, CascadesSoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'image',
        'status',
        'user_id',
        'society_id',
        'category_id'
    ];

    /**
     * Cascade soft deletes:
     * - comments: if a post is deleted, all comments go with it
     * - likedByUsers: likes are on a pivot, but we’ll handle them later
     */
    protected $cascadeDeletes = [
        'comments',
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

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_user_likes')
            ->withTimestamps();
    }
}
