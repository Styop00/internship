<?php

namespace App\Http\Controllers;

use App\Http\Contracts\UserRepositoryInterface;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function index(): JsonResponse
    {
//        $users = User::query()
//            ->select(['users.id', 'users.name', 'users.email', 'specifications.title'])
//            ->leftJoin('specification_user', 'specification_user.user_id', '=', 'users.id')
//            ->leftJoin('specifications', 'specification_user.specification_id', '=', 'specifications.id')
//            ->get();

        $users = $this->userRepository->all();

        return response()->json($users);
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function create(UserCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'last_name' => $request->last_name,
                'password' => Hash::make('password'),
            ]);

            $user->specifications()->attach([
                'specification_id' => 1
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

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
//        with(['employees.projects', 'owners']);
//        $user = User::find($id);
//        $user = User::where('id', $id)->first();

        return response()->json($user);
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return int
     */
    public function update(int $id, UpdateUserRequest $request): int
    {
        return $this->userRepository->update([
            'name' => $request->name
        ], $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
//        $user = User::find($id);
//        if ($user) {
//            $user->delete();
//        }
        return $this->userRepository->delete($id);
    }
}
