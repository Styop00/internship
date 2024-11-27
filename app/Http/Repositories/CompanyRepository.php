<?php

namespace App\Http\Repositories;

use App\Http\Contracts\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{

    /**
     * @param Company $company
     */
    public function __construct(protected Company $company)
    {
    }

    /**
     * @param array $relations
     * @return Collection
     */
    public function all(array $relations = []): Collection
    {
        return $this->company->with($relations)->get();
    }

    /**
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company
    {
        return $this->company->create($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->company->where('id', $id)->delete();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Company|null
     */
    public function find(int $id, array $relations = []): Company|null
    {
        return $this->company->where('id', $id)->with($relations)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        $company = $this->company->find($id);
        return $company ? $company->update($data) : false;
    }
}
