<?php

namespace App\Http\Repositories;

use App\Http\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param User $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->user->all();
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->user->destroy($id);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id): User|null
    {
        return $this->user->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->user->where('id', $id)->update($data);
    }
}
