<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// publics routes 
// register routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('registrationUser', [RegisterController::class, 'registrationUser']);
// login routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
// logout routes
Route::post('logout', [LogoutController::class, 'logout']);
