<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\Http\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(protected Post $post){}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->post->all();
    }

    /**
     * @param $data
     * @return Post|null
     */
    public function find($data): Post|null
    {
        return $this->post->where($data)->first();
    }

    /**
     * @param array $data
     * @return Post
     */
    public function create(array $data): Post
    {
        return $this->post->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->post->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->post->destroy($id);
    }
}
