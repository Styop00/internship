<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * @return BelongsToMany
     */
    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class);
    }

    /**
     * Get the user's image.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable');
    }
        public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'likeable');
    }
        public function post(): HasMany
    {
        return $this->hasMany(Post::class,);
    }

}
