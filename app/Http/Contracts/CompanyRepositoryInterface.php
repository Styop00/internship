<?php

namespace App\Http\Contracts;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function all(array $relations = []): Collection;

    public function find(int $id, array $relations = []): Company|null;

    public function create(array $data): Company;

    public function update(array $data, int $id): bool;

    public function delete(int $id): int;
}
