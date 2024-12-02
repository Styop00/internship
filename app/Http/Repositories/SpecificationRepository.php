<?php

namespace App\Http\Repositories;

use App\Http\Contracts\SpecificationRepositoryInterface;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Collection;

class SpecificationRepository implements SpecificationRepositoryInterface
{

    /**'
     * @param Specification $specification
     */
    public function __construct(protected Specification $specification) {}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->specification->all();
    }

    /**
     * @param array $data
     * @return Specification
     */
    public function create(array $data): Specification
    {
        return $this->specification->create($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->specification->destroy($id);
    }

    /**
     * @param int $id
     * @return Specification|null
     */
    public function find(int $id): Specification|null
    {
        return $this->specification->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->specification->where('id', $id)->update($data);
    }

}
