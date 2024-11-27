<?php

namespace App\Http\Contracts;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    /**
     * @param array $relations
     * @return Collection
     */
    public function all(array $relations = []): Collection;

    /**
     * @param int $id
     * @param array $relations
     * @return Company|null
     */
    public function find(int $id, array $relations = []): Company|null;

    /**
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company;

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
    public function delete(int $id): int;
}
