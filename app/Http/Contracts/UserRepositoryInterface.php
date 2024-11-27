<?php

namespace App\Http\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): User|null;

    public function create(array $data): User;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;
}
