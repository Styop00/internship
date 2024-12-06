<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\Http\Contracts\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(protected Comment $comment)
    {
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->comment->all();
    }

    /**
     * @param $data
     * @return Comment|null
     */
    public function find($data): Comment|null
    {
        return $this->comment->where($data)->first();
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        return $this->comment->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->comment->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        return $this->comment->destroy($id);
    }
}
