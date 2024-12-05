<?php
namespace App\Http\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
    {
        public function all(): Collection;

        public function find(int $id): ?Post;

        public function create(array $data): Post;

        public function update(array $data, int $postId): Post;

        public function delete(int $id): bool;
    }
