<?php
namespace App\Http\Contracts;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface {
    public function all(): Collection;

    public function find(int $id): mixed;

    public function create(array $data): Comment;

    public function update(int $id, array $data): Comment;

    public function delete(int $id): bool;
}
