<?php

namespace App\Http\Controllers;

use App\Http\Contracts\CommentRepositoryInterface;
use App\Http\Requests\CommentCreateRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(protected CommentRepositoryInterface $commentRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $comments = $this->commentRepository->all();

        return response()->json($comments);
    }

    /**
     * @param CommentCreateRequest $request
     * @return JsonResponse
     */
    public function create(CommentCreateRequest $request, ?int $parent_comment_id = null) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $comment = $this->commentRepository->create([
                'text' => $request->text,
                'post_id' => $request->post_id,
                'user_id' => Auth::user()->id,
                'parent_comment_id' => $parent_comment_id,
            ]);

            DB::commit();
            return response()->json($comment);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * @param $comment_id
     * @return JsonResponse
     */
    public function createCommentLike($comment_id) : JsonResponse {
        $comment = Comment::find($comment_id);
        $comment->likes()->create([
            'user_id' => Auth::user()->id,
        ]);
        return response()->json('Comment liked!');
    }

}
