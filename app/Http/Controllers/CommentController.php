<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CommentRepository;
use App\Http\Requests\CommentCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function __construct(protected CommentRepository $commentRepository)
    {
    }

    public function index(): JsonResponse
    {
        $comments = $this->commentRepository->all();
        foreach ($comments as $comment) {
            $comment->load([
                'SubComments'
            ]);

            $likes = Like::where([
                ['likeable_id', '=', $comment->id],
                ['likeable_type', '=', 'App\\Models\\Comment']
            ])->get();

            $comment->likes = $likes;

            foreach ($comment->subComments as $subComment) {
                $subCommentLikes = Like::where([
                    ['likeable_id', '=', $subComment->id],
                    ['likeable_type', '=', 'App\\Models\\Comment']
                ])->get();

                $subComment->likes = $subCommentLikes;
            }
        }

        return response()->json($comments);
    }

    public function create(CommentCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $user_id = Auth::id();

            $comment = $this->commentRepository->create([
                'text' => $validatedData['text'],
                'user_id' => $user_id,
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

