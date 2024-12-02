<?php

namespace App\Http\Repositories;

use App\Http\Contracts\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{

    /**'
     * @param Company $company
     */
    public function __construct(protected Company $company) {}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->company->all();
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
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->company->destroy($id);
    }

    /**
     * @param int $id
     * @return Company|null
     */
    public function find(int $id): Company|null
    {
        return $this->company->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->company->where('id', $id)->update($data);
    }

}
