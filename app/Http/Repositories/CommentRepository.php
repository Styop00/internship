<?php
namespace App\Http\Repositories;
use App\Http\Contracts\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{

    public function __construct(protected Comment $comment){}

    public function all(): Collection
    {
        return $this->comment->get()->loadCount('likes');
    }

    public function find(int $id): mixed
    {
        return $this->comment->with('subComments.subComments')->find($id);
    }

    public function create(array $data): Comment
    {
        return $this->comment->create($data);
    }

    public function update(int $id, array $data): Comment
    {
        return $this->comment->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->comment->delete($id);
    }

}
