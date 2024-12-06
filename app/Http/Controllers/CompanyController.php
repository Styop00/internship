<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CompanyRepository;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
//    /**
//     * @param CompanyRepositoryInterface $companyRepository
//     */
    public function __construct(protected CompanyRepository $companyRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
//        $companies = Company::all();

//             $users = User::query()
//             ->select(['users.id', 'users.name', 'users.email', 'specifications.title'])
//             ->leftJoin('specification_user', 'specification_user.user_id', '=', 'users.id')
//             ->leftJoin('specifications', 'specification_user.specification_id', '=', 'specifications.id')
//             ->get();

        $companies = $this->companyRepository->all(['owner', 'employees']);

        return response()->json($companies);
    }
    public function create(CompanyCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $company = $this->companyRepository->create([
                'name' => $validatedData['name'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
            ]);

            if(isset($validatedData['owner'])){
                $company->owner()->create([
                    'name' => $validatedData['owner']['name'],
                    'email' => $validatedData['owner']['email'],
                ]);
            }

            if(isset($validatedData['employees'])){
                foreach ($validatedData['employees'] as $employeeData) {
                    $employee = $company->employees()->create([
                        'name' => $employeeData['name'],
                        'email' => $employeeData['email'],
                        'position' => $employeeData['position'],
                    ]);

                    if ($employeeData['position'] === 'developer' && isset($employeeData['specification'])) {
                        $employee->specifications()->attach([
                            'specification_id' => $employeeData['specification'] //todo get from request,
                            //DONE
                        ]);
                    }

                    if (isset($employeeData['projects'])) {
                        foreach ($employeeData['projects'] as $employeeProjects){
                            $project = $employee->projects()->create([
                                'title' => $employeeProjects,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return response()->json($company);

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
