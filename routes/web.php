<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- Import Auth Facade

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/auth/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/app/home', [HomeController::class, 'index'])->name('app.home');
});

// Root route
Route::get('/', function () {
    return redirect()->route('auth.login');
});
Route::get('/', function () {
    if (Auth::check()) {
        // Jika sudah login, arahkan ke home
        return redirect()->route('app.home');
    }
    // Jika belum login, arahkan ke login
    return redirect()->route('auth.login');
});