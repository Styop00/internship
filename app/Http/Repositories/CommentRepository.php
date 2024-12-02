<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\Http\Contracts\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(protected Comment $comment)
    {
    }

    public function all(): Collection
    {
        return $this->comment->all();
    }

    public function find($data): Comment|null
    {
        return $this->comment->where($data)->first();
    }

    public function create(array $data): Comment
    {
        return $this->comment->create($data);
    }

    public function update(array $data, int $id): bool
    {
        return $this->comment->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->comment->destroy($id);
    }
}
