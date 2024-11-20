<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return string
     */
    public function index(): string {
        return 'Get method';
    }

    /**
     * @param UserCreateRequest $request
     * @return string
     */
    public function create(UserCreateRequest $request): string {

        DB::enableQueryLog();
        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'last_name' => $request->last_name,
            'password' => Hash::make('password'),
        ]);

        DB::commit();
        return $user;
    }

    /**
     * @param int $id
     * @return string
     */
    public function update(int $id): string {
        return 'Update method with id: '.$id;
    }
    /**
     * @return string
     */
    public function test(): string {
        return 'Test method';
    }

    /**
     * @param int $id
     * @return string
     */
    public function delete(int $id): string {
        return 'Delete method with id: '.$id;
    }
}
