<?php

namespace App\Http\Controllers;

use App\Http\Contracts\CompanyRepositoryInterface;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Models\Company;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(protected CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
//        $companies = Company::with("users")->get();
        $companies = $this->companyRepository->all();
        return response()->json($companies);
    }

    /**
     * @param CompanyCreateRequest $request
     * @return JsonResponse
     */
    public function create(CompanyCreateRequest $request) : JsonResponse {
        $request->validated();
        try {
            DB::beginTransaction();
//            $company =  Company::create([
            $company = $this->companyRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            DB::commit();
            return response()->json($company);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * @param CompanyUpdateRequest $request
     * @param int $id
     * @return int
     */
    public function update(CompanyUpdateRequest $request, int $id): int {
        $request->validated();
//        return Company::where('id', $id)->update([
//            'name' => $request->name,
//        ]);
        return $this->companyRepository->update(['name' => $request->name], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
//        return Company::where('id', $id)->delete();
        return $this->companyRepository->delete($id);
    }
}
