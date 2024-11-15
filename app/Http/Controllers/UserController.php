<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{
    //
    public function index():string {
        return "Get method";
    }

    //
    // @param Request $request
    // @return string
    public function create(UserCreateRequest $request, int $test = 3):string { //:string|int|null {
        // dd($request);
        // dd($request->name);
        // dd($request->input('name'));
        // dd($request->all());
        // $request->all([key]);
        // $request->all();
        // request->all();
        // dd($request->all('name', 'age'));
        // dd($request->validated());
        return "Create method";
    }

    public function test():string {
        return "test method";
    }

    /**
     * @param int $id
     * @return string
     */
    // 
    public function update(int $id):string {
        return "Update method with id: " . $id;
    }

    // 
    public function delete(int $id):string {
        return "Delete method with id: " . $id;
    }
}
