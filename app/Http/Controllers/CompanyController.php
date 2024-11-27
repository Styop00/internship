<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Support\Facades\DB;

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
    public function index(): JsonResponse
    {
//        $companies = Company::all();

        //        $users = User::query()
//            ->select(['users.id', 'users.name', 'users.email', 'specifications.title'])
//            ->leftJoin('specification_user', 'specification_user.user_id', '=', 'users.id')
//            ->leftJoin('specifications', 'specification_user.specification_id', '=', 'specifications.id')
//            ->get();

        $companies = $this->companyRepository->all(['owner', 'employees']);

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

        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $company = $this->companyRepository->create([
                'name' => $validatedData['name'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
            ]);

            if (isset($validatedData['owner'])) {
                $company->owner()->create([
                    'name' => $validatedData['owner']['name'],
                    'email' => $validatedData['owner']['email'],
                ]);
            }


            if (isset($validatedData['employees'])) {
                foreach ($validatedData['employees'] as $employeeData) {
                    $employee = $company->employees()->create([
                        'name' => $employeeData['name'],
                        'email' => $employeeData['email'],
                        'position' => $employeeData['position'],
                    ]);

                    if ($employeeData['position'] === 'developer' && isset($employeeData['specification'])) {

                        $employee->specifications()->attach(
                            [
                                'specification_id' => 1
                            ]
                        );

                    }

                    if (isset($employeeData['projects'])) {
                        $employee->projects()->attach($employeeData['projects']);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Company created successfully!',
                'data' => $company->load(['owner', 'employees.projects', 'employees.specifications']),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
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
     * @return JsonResponse
     */

    //pti dzvi

    public function update(int $id, CompanyUpdateRequest $request): JsonResponse
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

        $validatedData = $request->validated();
        $company = $this->companyRepository->find($id);

        try {
            DB::beginTransaction();


            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return Company::find($id)->update([
            'employees.*.position' => $request->position,
            'employees.*.specification' => $request->specification,
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
