<?php
namespace App\Http\Contracts;

use App\Models\Like;

interface LikeRepositoryInterface {

    public function create($data): Like;

    public function getByParams($params): bool;

    public function delete($id): bool;

    public function deleteByParams(array $params): bool;

}
