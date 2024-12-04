<?php

namespace App\Http\Controllers;

use App\Http\Contracts\CommentRepositoryInterface;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    /**
     * @return JsonResponse
     */
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

    /**
     * @param CommentCreateRequest $request
     * @return JsonResponse
     */
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

            return response()->json([
                'status' => 'success',
                'message' => 'Comment created successfully!',
                'data' => $comment,
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
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment)
    {
        $comment->load([
            'subComments',
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

        return response()->json($comment);
    }

    /**
     * @param int $id
     * @param CommentUpdateRequest $request
     * @return int
     */
    public function update(int $id, CommentUpdateRequest $request): int
    {
        return $this->commentRepository->update([
            'text' => $request->text
        ], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->commentRepository->delete($id);
    }
}
