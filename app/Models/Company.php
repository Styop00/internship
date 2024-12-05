<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['created_at' , 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class , 'company_user');    }
    }
