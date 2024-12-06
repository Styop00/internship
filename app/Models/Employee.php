<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'email',
      'position',
    ];


    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class);
    }

    public function projects(): belongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
