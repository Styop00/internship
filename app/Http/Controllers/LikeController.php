<?php

namespace App\Http\Controllers;

use App\Http\Contracts\LikeRepositoryInterface;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Termwind\Components\Li;

class LikeController extends Controller
{
    public function __construct(protected LikeRepositoryInterface $likeRepository){}

    public function create(Request $request): JsonResponse
    {
         $requestData = $request->all();
         $type = $requestData['type'] === 'post' ? Post::class : Comment::class;
         $exists = $this->likeRepository->getByParams([
             'user_id'=> $requestData['user_id'],
             'likeable_id'=>$requestData['id'],
             'likeable_type' => $type,
         ]);
         if($exists){
             return response()->json(['messege'=> 'Already Liked']);
         }
         $like = $this->likeRepository->create([
             'user_id' => $requestData['user_id'],
             'likeable_type' => $type,
             'likeable_id' => $requestData['id']
         ]);
         return response()->json($like);
    }

    public function delete(Request $request): JsonResponse
    {
        $requestData = $request->all();
        $type = $requestData['type'] === 'post' ? Post::class : Comment::class;
        $delete = $this->likeRepository->deleteByParams([
            'user_id'=> $requestData['user_id'],
            'likeable_id'=> $requestData['id'],
            'likeable_type'=> $type
        ]);
        return response()->json([
            'message' => 'Like Deleted',
            'deleted' => $delete
        ]);
    }
}
