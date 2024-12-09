<?php

namespace App\Http\Controllers;


use App\Http\Repositories\PostRepository;
use App\Http\Requests\PostCreateRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    public function index(): JsonResponse
    {
        $posts = $this->postRepository->all([]);
        foreach ($posts as $post) {
            $post->load([
               'comments'
            ]);

            $likes = Like::where([
                ['likeable_id', '=', $post->id],
                ['likeable_type', '=', 'App\\Models\\Post']
            ])->get();

            $post->likes = $likes;
            foreach($post->comments as $comments){
                $commentLikes = Like::where([
                    ['likeable_id', '=', $comments->id],
                    ['likeable_type', '=', 'App\\Models\\Comment']
                ]);

                $comments->likes = $commentLikes;
            }
        }

        return response()->json($posts);
    }

    public function create(PostCreateRequest $request): JsonResponse
    {

        $validatedPostData = $request->validated();

        try {
            DB::beginTransaction();
            if(Auth::check()){
                $user_id = Auth::id();

                $post = $this->postRepository->create([
                    'title' => $validatedPostData['title'],
                    'body' => $validatedPostData['body'],
                    'user_id' => $user_id,
                ]);
            }else{
                $post = response()->json([
                    'status' => 'error',
                    'message' => 'User are not authenticated'
                ]);
            }

            DB::commit();
            return response()->json($post);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function update(): int
    {
        return(123);
    }

    public function delete($id): int
    {
        return(123);
    }
}
