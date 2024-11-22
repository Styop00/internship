<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    /**
     * @param CompanyCreateRequest $request
     * @return JsonResponse
     */
    public function create(CompanyCreateRequest $request): JsonResponse
    {
//        $request->validated();
//        $request->input('key');
//        $request->get('key');
//        $request->all(['key']);
//        $request->all();
//        request()->all();

        try {
            DB::beginTransaction();
            $company = Company::create([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
            ]);

            DB::commit();
            return response()->json($company);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    /**
     * @param Company $company
     * @return JsonResponse
     */

    /*    public function show(Company $company) : JsonResponse {
            $company = Company::find($id);

            return response()->json($company);
        }*/

    /**
     * @param int $id
     * @param CompanyUpdateRequest $request
     * @return int
     */
    public function update(int $id, CompanyUpdateRequest $request): int
    {
//        $company = Company::find($id);
//        $company = $request->find($id);
//        if (!$company) return response()->json(['message' => 'Company not found'],404);
//        $validatedData = $request->validated();
//        $company->update($validatedData);
//
//        return response()->json([
//            'message' => 'Company updated successfully',
//            'data' => $company
//        ]);

        return Company::find($id)->update([
            'employees.*.position' => $request->position,
            'employees.*.specification' => $request->specification,
        ]);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return Company::find($id)->delete();
    }
}
