<?php

namespace App\Http\Controllers;

use App\Http\Contracts\UserRepositoryInterface;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
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
        $users = $this->userRepository->all();

        return response()->json($users);
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function create(UserCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $user = $this->userRepository->create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($request->password),
            ]);

            $user->specifications()->attach([
                'specification_id' => 1
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully!',
                'data' => $user,
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
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * @param int $id
     * @param UserUpdateRequest $request
     * @return int
     */
    public function update(int $id, UserUpdateRequest $request): int
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
        return $this->userRepository->delete($id);
    }
}
