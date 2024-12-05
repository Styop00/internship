<?php

namespace App\Http\Controllers;

use App\Http\Contracts\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostRepositoryInterface $postRepository){}

    public function index(): JsonResponse
    {
        $posts = $this->postRepository->all();
        return response()->json([
            'posts' => $posts
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $post = $this->postRepository->create($request->all());
        return response()->json([
            'post' => $post
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);
        return response()->json([
            'post' => $post->load('comments')->loadCount('likes')
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $updated = $this->postRepository->update($request->all(), $id);
        return response()->json([
            'updated' => $updated
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->postRepository->delete($id);
        return response()->json([
            'deleted' => $deleted,
        ]);
    }
}
