<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\BestTrickController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/besttricks', BestTrickController::class);
Route::apiResource('/posts', PostsController::class);
Route::apiResource('/files', FilesController::class);
Route::apiResource('/comments', CommentsController::class);
Route::post('/register', [RegisterController::class, 'post']);
Route::post('/login', [LoginController::class, 'post']);
Route::post('/logout', [LogoutController::class, 'post']);
Route::get('/user', [UsersController::class, 'get']);
Route::get('/user/{user}', [UsersController::class, 'show']);
Route::put('/user/{user}', [UsersController::class, 'put']);
Route::post('/like', [LikesController::class, 'post']);
Route::delete('/like', [LikesController::class, 'delete']);
