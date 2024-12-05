<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $guarded = ['created_at', 'updated_at', 'deleted_at', 'password'];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function likedPosts()
    {
        return $this->hasMany(Like::class)->where('likeable_type', Post::class)->with('likeable');
    }
    public function likedComments()
    {
        return $this->hasMany(Like::class)->where('likeable_type', Comment::class)->with('likeable');
    }
}
