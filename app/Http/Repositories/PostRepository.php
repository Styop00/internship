<?php
namespace App\Http\Repositories;
use App\Http\Contracts\PostRepositoryInterface;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
    {
        public function __construct(protected Post $post){}

        public function all(): Collection
        {
            return $this->post->with(['likes' , 'comments.likes' ])->get();
        }

        public function find($id): ?Post
        {
            return $this->post->find($id);
        }

        public function create(array $data): Post
        {
            return $this->post->create($data);
        }

        public function update(array $data, int $postId): Post
        {
            return $this->post->find($postId)->update($data);
        }

        public function delete(int $id): bool
        {
            return $this->post->find($id)->delete();
        }
    }
