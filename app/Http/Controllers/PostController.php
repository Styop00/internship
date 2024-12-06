<?php

namespace App\Http\Controllers;


use App\Http\Repositories\PostRepository;
use App\Http\Requests\PostCreateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    public function index(): JsonResponse
    {
        $posts = $this->postRepository->all(['user_id', 'title', 'body']);

        return response()->json($posts);
    }

    public function create(PostCreateRequest $request): JsonResponse
    {
        $validatedPostData = $request->validated();

        try {
            DB::beginTransaction();

            $post = $this->postRepository->create([
                'title' => $validatedPostData['title'],
                'body' => $validatedPostData['body'],
                'user_id' => $validatedPostData['user_id'],
            ]);

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

    }

    public function delete($id): int
    {

    }
}
