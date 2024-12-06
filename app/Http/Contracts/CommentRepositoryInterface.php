<?php

namespace App\Http\Contracts;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param array $data
     * @return Comment|null
     */
    public function find(array $data): Comment|null;

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment;

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
