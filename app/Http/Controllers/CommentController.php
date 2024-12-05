<?php

namespace App\Http\Controllers;

use App\Http\Contracts\CommentRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class CommentController extends Controller
{
    /**
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(protected CommentRepositoryInterface $commentRepository){}

    public function index(): JsonResponse
    {
        $comments = $this->commentRepository->all();
        return response()->json($comments);
    }

    public function create(Request $request): JsonResponse
    {
        $comment = $this->commentRepository->create($request->all());
        return response()->json($comment);
    }

    public function show($id): JsonResponse
    {
        $comment = $this->commentRepository->find($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $updated = $this->commentRepository->update($id, $request->all());
        return response()->json([
            'updated' => $updated
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->commentRepository->delete($id);
        return response()->json([
            'deleted' => $deleted
        ]);
    }

    public function likeComment(Request $request, int $id): JsonResponse
    {
        try {

            $comment = $this->commentRepository->find($id);
            $comment->likes()->create([
                'user_id'=> $request['user_id'],
            ]);
            return response()->json($comment);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
