<?php

namespace App\Http\Controllers;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Interfaces\CompanyInterface;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CompanyController extends Controller
{

    public function __construct(private CompanyInterface $companyInterface){}

    public function index(): JsonResponse
    {
        $company = $this->companyInterface->all();
        return response()->json($company);
    }

    public function create(CompanyCreateRequest $request): JsonResponse
    {
        $data = $request->all();
        $company = $this->companyInterface->store($data);
        return response()->json($company);
    }

    public function update(CompanyUpdateRequest $request, Company $company): JsonResponse
    {
        $data = $request->all();
        $company->update($data);
        return response()->json($company);
    }

    public function delete(int $id): JsonResponse
    {
        $deleted = $this->companyInterface->delete($id);
        return response()->json([
            'deleted' => $deleted
        ]);
    }

    public function show(Company $company): JsonResponse
    {
        return response()->json($company);
    }
}
