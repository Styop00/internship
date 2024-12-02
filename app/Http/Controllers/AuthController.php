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
    public function __construct(protected UserRepository $userRepository) {}
    public function register(Request $request) {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name'      => $request->name,
                'email'     => $request->email,
                'last_name' => $request->last_name,
                'password'  => Hash::make($request->password),
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

    public function login(Request $request) {
        $user = $this->userRepository->find(['email' => $request->input('email')]);
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('token');
            return response()->json(['user' => $user, 'token' => $token->plainTextToken]);
        }
        return response()->json([
            'status' => 'Error',
            'message' => 'Invalid credentials',
        ], 404);
    }
}
