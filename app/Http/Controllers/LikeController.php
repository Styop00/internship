<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(): JsonResponse
    {
        $likes = Like::with(['likeable', 'user'])->get();
    }
}
