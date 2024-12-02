<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Contracts\SpecificationRepositoryInterface;
use App\Http\Requests\SpecificationCreateRequest;
use App\Http\Requests\SpecificationUpdateRequest;
use Illuminate\Support\Facades\DB;

class SpecificationController extends Controller
{
    /**
     * @param SpecificationRepositoryInterface $specificationRepository
     */
    public function __construct(protected SpecificationRepositoryInterface $specificationRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
//        $companies = Specification::with("users")->get();
        $companies = $this->specificationRepository->all();
        return response()->json($companies);
    }

    /**
     * @param SpecificationCreateRequest $request
     * @return JsonResponse
     */
    public function create(SpecificationCreateRequest $request) : JsonResponse {
        $request->validated();
        try {
            DB::beginTransaction();
//            $company =  Specification::create([
            $company = $this->specificationRepository->create([
                'title' => $request->title,
            ]);

            DB::commit();
            return response()->json($company);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * @param SpecificationUpdateRequest $request
     * @param int $id
     * @return int
     */
    public function update(SpecificationUpdateRequest $request, int $id): int {
        $request->validated();
//        return Specification::where('id', $id)->update([
//            'title' => $request->title,
//        ]);
        return $this->specificationRepository->update(['title' => $request->title], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
//        return Specification::where('id', $id)->delete();
        return $this->specificationRepository->delete($id);
    }
}
