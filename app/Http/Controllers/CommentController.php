<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CommentRepository;
use App\Http\Requests\CommentCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function __construct(protected CommentRepository $commentRepository)
    {
    }

    public function index(): JsonResponse
    {
    }

    public function create(CommentCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $comment = $this->commentRepository->create([
                'text' => $validatedData['text'],
                'user_id' => $validatedData['user_id'],
                'post_id' => $validatedData['post_id'],
                'parent_id' => $validatedData['parent_id'],
            ]);

            DB::commit();

            return response()->json($comment);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update()
    {

    }

    public function delete(int $id)
    {

    }
}

