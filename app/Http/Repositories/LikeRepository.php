<?php
namespace App\Http\Repositories;
use App\Http\Contracts\LikeRepositoryInterface;
use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface {

    public function __construct(protected Like $like){}

     public function create($data): Like
    {
        return $this->like->create($data);
    }
    public function getByParams($params): bool
    {
        return $this->like->where($params)->exists();
    }
    public function delete($id): bool
    {
        $data = $this->like->find($id);
        return $data?->delete();
    }
    public function deleteByParams(array $params): bool
    {
        $data = $this->like->where($params)->first();
        if ($data) {
            return $data->delete();
        }
        return true;
    }
}
