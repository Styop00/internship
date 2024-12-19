<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {

    }

    public function register(UserCreateRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name'      => $request->get('name'),
                'email'     => $request->get('email'),
                'last_name' => $request->get('last_name'),
                'password'  => Hash::make($request->get('password')),
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

    public function login(Request $request): JsonResponse
    {
        $user = $this->userRepository->find(['email' => $request->input('email')]);
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('token');
            return response()->json(['user' => $user, 'token' => $token->plainTextToken], 200);
        } else{
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }
    }
}
