<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//Route::group(['prefix' => 'users'], function () {
//    Route::get('/', [UserController::class, 'index'])->name('user.index');
//    Route::post('/', [UserController::class, 'create'])->name('user.create');
//    Route::put('/test', [UserController::class, 'test']);
//    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
//    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
//});

//Route::group(['prefix' => 'users'], function () {
//    Route::get('/', [UserController::class, 'index'])->name('user.index');
//    Route::get('/result', [UserController::class, 'result']);
//    Route::post('/', [UserController::class, 'create'])->name('user.create');
//    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
//    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
//    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
//});

//Route::group(['prefix' => 'company'], function () {
//    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
//    Route::post('/', [CompanyController::class, 'create'])->name('company.create');
//    Route::put('/{id}', [CompanyController::class, 'update'])->name('company.update');
//    Route::delete('/{id}', [CompanyController::class, 'delete'])->name('company.delete');
//});
//
//Route::group(['prefix' => 'specification'], function () {
//    Route::get('/', [SpecificationController::class, 'index']);
//    Route::post('/', [SpecificationController::class, 'create']);
//    Route::put('/{id}', [SpecificationController::class, 'update']);
//    Route::delete('/{id}', [SpecificationController::class, 'delete']);
//});

//Route::group(['prefix' => 'users'], function () {
//    Route::get('/', [UserController::class, 'index'])->name('user.index');
//    Route::post('/', [UserController::class, 'create'])->name('user.create');
//    Route::group(['middleware' => ['auth:sanctum']], function () {
//        Route::get('/', [UserController::class, 'index'])->name('user.index');
//        Route::post('/', [UserController::class, 'create'])->name('user.create');
//    });
//    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
//    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
//    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
//});


Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/', [UserController::class, 'create'])->name('user.create');
    Route::put('/test', [UserController::class, 'test']);
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
});

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['prefix' => 'posts', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'create']);
    Route::post('/{post_id}', [PostController::class, 'createPostLike']);
});

Route::group(['prefix' => 'comments', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/{parent_comment_id?}', [CommentController::class, 'create']);
    Route::post('/{comment_id}/like', [CommentController::class, 'createCommentLike']);
});






































