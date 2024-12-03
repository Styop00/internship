<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::group(['prefix' => 'company'], function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/', [CompanyController::class, 'create'])->name('company.create');
    Route::put('/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/{id}', [CompanyController::class, 'delete'])->name('company.delete');
});

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');


Route::group(['prefix' => 'users'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/', [UserController::class, 'create'])->name('user.create');
    });
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
});


Route::group(['prefix' => 'posts'], function () {
//    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::post('/', [PostController::class, 'create'])->name('post.create');
        Route::put('/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('/{post}', [PostController::class, 'show'])->name('post.show');
        Route::delete('/{id}', [PostController::class, 'delete'])->name('post.delete');
//    });
});

Route::group(['prefix' => 'comments'], function () {
//    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [CommentController::class, 'index'])->name('comment.index');
        Route::post('/', [CommentController::class, 'create'])->name('comment.create');
        Route::put('/{id}', [CommentController::class, 'update'])->name('comment.update');
        Route::get('/{comment}', [CommentController::class, 'show'])->name('comment.show');
        Route::delete('/{id}', [CommentController::class, 'delete'])->name('comment.delete');
//    });
});
