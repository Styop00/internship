<?php

namespace App\Http\Contracts;

use App\Models\Specification;
use Illuminate\Database\Eloquent\Collection;

interface SpecificationRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Specification|null;

    public function create(array $data): Specification;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;
}
