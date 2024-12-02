<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $table = 'users';

    protected $fillable = ['name', 'last_name', 'email', 'password'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public  function likes():HasMany
    {
        return $this->hasMany(Like::class);
    }



    /**
     * @return BelongsToMany
     */
    /*    public function specifications(): BelongsToMany
        {
            return $this->belongsToMany(Specification::class);
        }*/
}
