<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TaskController;
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

//Auth Routes
Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::post('auth/signup', 'signup')->middleware('guest');
    Route::post('auth/sigin', 'sigin')->middleware('guest');
    Route::get('auth/signout', 'signout')->middleware('auth:sanctum');
    Route::get('list', 'getAll')->middleware('auth:sanctum');
});

//Task Routes
Route::controller(TaskController::class)->prefix('task')->middleware('auth:sanctum')->group(function () {
    Route::post('create', 'create');
    Route::post('update', 'update');
    Route::delete('delete', 'delete');
    Route::get('list/users', 'getAll');
    Route::get('list', 'getTask');
});
