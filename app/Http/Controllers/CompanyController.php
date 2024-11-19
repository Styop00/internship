<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyDeleteRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    /**
     * @return string
     */
    public function index(Request $request): string
    {
        $companies = $request->all();
        return response()->json([
            'message' => 'Company updated successfully',
            'data' => $companies
        ]);
    }

    /**
     * @param CompanyCreateRequest $request
     * @return string
     */
    public function create(CompanyCreateRequest $request): string
    {
//        $request->validated();
//        $request->input('key');
//        $request->get('key');
//        $request->all(['key']);
//        $request->all();
//        request()->all();

//        $validatedData = $request->validated();
//        $company = Company::create($validatedData);

        $company = $request->all();

//        return response()->json([
//            'message' => 'Company created successfully',
//            'data' => $company
//        ], 201);
        return response()->json([
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * @param int $id
     * @return string
     */
    public function update(CompanyUpdateRequest $request, int $id): string
    {
//        $company = Company::find($id);
        $company = $request->find($id);
//        if (!$company) return response()->json(['message' => 'Company not found'],404);
//        $validatedData = $request->validated();
//        $company->update($validatedData);
//
//        return response()->json([
//            'message' => 'Company updated successfully',
//            'data' => $company
//        ]);
        return response()->json([
            'message' => 'Company updated successfully',
            'data' => $company
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function delete(CompanyDeleteRequest $request, int $id): string
    {
//        $company = Company::find($id);
//        $company = $request->find($id);

//        if (!$company) return response()->json(['message' => 'Company not found', 404]);
//        $validatedData = $request->validated();
//        $company->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }
}
