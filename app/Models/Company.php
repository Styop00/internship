<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'email',
    ];


    public function employees(): BelongsToMany
    {
        return $this->belongsToMany( Employee::class);
    }

    public function owner(): HasOne
    {
        return $this->hasOne( Owner::class);
    }
}
