<?php

namespace App\Http\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param array $data
     * @return Post|null
     */
    public function find(array $data): Post|null;

    /**
     * @param array $data
     * @return Post
     */
    public function create(array $data): Post;

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
