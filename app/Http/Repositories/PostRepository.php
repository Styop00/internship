<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\Http\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(protected Post $post)
    {
    }

    public function all(): Collection
    {
        return $this->post->all();
    }

    public function find($data): Post|null
    {
        return $this->post->where($data)->first();
    }

    public function create(array $data): Post
    {
        return $this->post->create($data);
    }

    public function update(array $data, int $id): bool
    {
        return $this->post->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->post->destroy($id);
    }
}
