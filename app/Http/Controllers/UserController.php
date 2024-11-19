<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $users = User::with(['specifications'])->get();
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
            $user =  User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'last_name' => $request->last_name,
                'password'  => Hash::make('password'),
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

    public function show(User $user): JsonResponse
    {
//        $user = User::find($id);
//        $user = User::where('id', $id)->first();

        return response()->json($user);
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return int
     */
    public function update(int $id, UpdateUserRequest $request): int {
        return User::where('id', $id)->update([
            'name' => $request->name,
        ]);
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
        return User::where('id', $id)->delete();
    }
}
