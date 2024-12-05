<?php
namespace App\Repositories;

use App\Interfaces\CompanyInterface;
use App\Models\Company;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyInterface
{
    protected $company;
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
    public function find(int $id): Company|null
    {
        return $this->company->where('id', $id)->first();
    }
    public function all(): Collection
    {
        return $this->company->all();
    }
    public function store(array $data): Company
    {
        return $this->company->create($data);
    }
    public function update(array $data, $id): int
    {
        return $this->company->where('id', $id)->update($data);
    }
    public function delete(int $id): int
    {
        $this->company->destroy($id);
    }

}
