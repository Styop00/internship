<?php

namespace App\Http\Controllers;

use App\Http\Contracts\PostRepositoryInterface;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct(protected PostRepositoryInterface $postRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->all();

        return response()->json($posts);
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function create(PostCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $post = $this->postRepository->create([
                'title' => $validatedData['title'],
                'body' => $validatedData['body'],
                'user_id' => $validatedData['user_id'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Post created successfully!',
                'data' => $post,
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * @param int $id
     * @param PostUpdateRequest $request
     * @return int
     */
    public function update(int $id, PostUpdateRequest $request): int
    {
        return $this->postRepository->update([
            'title' => $request->title,
            'body' => $request->body,
        ], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->postRepository->delete($id);
    }
}
