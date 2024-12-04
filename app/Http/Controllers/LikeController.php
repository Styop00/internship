<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $likes = Like::with(['likeable', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $likes,
        ], 200);
    }

    /**
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function toggleLike(LikeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $likeableType = $validated['likeable_type'] === 'post' ? Post::class : Comment::class;
        $likeableId = $validated['likeable_id'];
        $userId = Auth::id();

        $like = Like::where('user_id', $userId)
            ->where('likeable_id', $likeableId)
            ->where('likeable_type', $likeableType)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Unliked successfully!',
            ], 200);
        }

        Like::create([
            'user_id' => $userId,
            'likeable_id' => $likeableId,
            'likeable_type' => $likeableType,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Liked successfully!',
        ], 201);
    }
}
