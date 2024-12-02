<?php

namespace App\Http\Controllers;

use App\Http\Contracts\UserRepositoryInterface;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\Company;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $users = $this->userRepository->all();
//        $users = User::with(['specifications'])->get();

//        $users = User::all();
//        foreach ($users as $user) {
//            $user->load(['specifications']);
//        }


//        $users = User::query()
//            ->select(['users.id', 'users.name', 'users.email', 'specifications.title'])
//            ->leftJoin('specification_user', 'specification_user.user_id', '=', 'users.id')
//            ->leftJoin('specifications', 'specification_user.specification_id', '=', 'specifications.id')
//            ->get();


        return response()->json($users);
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function create(UserCreateRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $user =  $this->userRepository->create([
                'name'      => $request->name,
                'email'     => $request->email,
                'last_name' => $request->last_name,
                'password'  => Hash::make('password'),
            ]);

//            $specification = Specification::find(1);
//            $specification->users()->create(
//                [
//                    'name'      => $request->name,
//                    'email'     => $request->email,
//                    'last_name' => $request->last_name,
//                    'password'  => Hash::make('password'),
//                ]);

            $specification = Specification::where('title', $request->title)->first();
            $user->specifications()->attach([
                'specification_id' => $specification->id,
            ]);

            $company = Company::where('name', $request->company_name)->first();
            $user->companies()->attach([
                'company_id' => $company->id,
            ]);

            DB::commit();
            return response()->json($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
            ]);
        }

    }

    public function show(User $user): JsonResponse
    {
//        $user = User::find($id);
//        $user = User::where('id', $id)->first();

        return response()->json($user);
    }

    public function result(): JsonResponse {

        $users = User::with(['specifications', 'companies'])->get();

//        foreach ($users as $user) {
//            $specification = $user->specifications;
//            foreach ($specification as $specification) {
//                if ($specification->title === "fullstack") {
//                    return response()->json($specification->title);
//                }
//            }
//        }
        return response()->json($users);
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return int
     */
    public function update(int $id, UpdateUserRequest $request): int {
//        return User::where('id', $id)->update([
//            'name' => $request->name,
//        ]);
        return $this->userRepository->update(['name' => $request->name], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
//        $user = User::find($id);
//        if ($user) {
//            $user->delete();
//        }
//        return User::where('id', $id)->delete();
        return $this->userRepository->delete($id);
    }
}
