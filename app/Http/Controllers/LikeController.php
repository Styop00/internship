<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;

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
    #[NoReturn] public function toggle(LikeRequest $request): JsonResponse
    {
        $validatedLike = $request->validated();

        if($validatedLike['likeable_type'] == 'post'){
            $likeableType = Post::class;
        } else{
            $likeableType = Comment::class;
        }

        $userId = Auth::id();

        $like = Like::where([
            ['user_id', '=', $userId],
            ['likeable_id', '=', $validatedLike['likeable_id']],
            ['likeable_type', '=', $likeableType]
        ])->first();

        if ($like) {
            $like->delete();
            return response()->json([
                'msg' => 'Like successfully deleted'
            ]);
        }

        Like::create([
            'user_id' => $userId,
            'likeable_id' => $validatedLike['likeable_id'],
            'likeable_type' => $likeableType,
        ]);

        return response()->json([
            'msg' => "Liked successfully"
        ]);
    }
}
