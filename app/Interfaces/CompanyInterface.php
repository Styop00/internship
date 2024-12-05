<?php
namespace App\Interfaces;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
interface CompanyInterface
{
    public function find(int $id): Company|null;
    public function store(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function all(): Collection;
}
