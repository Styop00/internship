<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function register(UserCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'last_name' => $validatedData['last_name'],
                'password' => Hash::make($validatedData['password']),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully!',
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
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->userRepository->find(['email' => $request->input('email')]);

        if ($user && Hash::check($request->input('password'), $user->password)) {

            $token = $user->createToken('token');

            return response()->json(['user' => $user, 'token' => $token->plainTextToken]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ], 404);
    }
}
