<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'user/login', 301);

Route::get('user/login', [UserController::class, 'index'])->middleware('guest')->name('auth.login');
Route::get('user/registration', [UserController::class, 'registration'])->middleware('guest')->name('auth.registration');
Route::post('user/dashboard', [DashboardController::class, 'index'])->middleware('auth');
