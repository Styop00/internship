<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/users', [UserController::class, 'index'])->name('user.index');
//Route::post('/users', [UserController::class, 'create'])->name('user.create');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
//Route::delete('/users/{id}', [UserController::class, 'delete'])->name('user.delete');

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/', [UserController::class, 'create'])->name('user.create');
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
});
