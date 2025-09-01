<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// NEW: SoftDeletes & Cascades trait (added only, does not modify existing methods)
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CascadesSoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // preserve your original trait order but include SoftDeletes & Cascades
    use HasRoles, HasFactory, Notifiable, SoftDeletes, CascadesSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_pic',
        'is_active',
        'society_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATION NAMES TO BE CASCADED
     *
     * Minimal set for now — we will expand this list as we update child models.
     * This tells the CascadesSoftDeletes trait which relations to process.
     */
    protected $cascadeDeletes = [
        'posts',
        'comments',
        // don't include likedPosts (belongsToMany pivot) here yet — we'll convert likes to a model later if needed
    ];

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_likes')
            ->withTimestamps();
    }
}
