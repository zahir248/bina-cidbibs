<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\PageController;

use App\Http\Controllers\Admin\AuthController;

// client 
Route::get('/', [PageController::class, 'home'])->name('client.home');

// admin
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'loginPage'])->name('login'); 
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Routes for authenticated users only
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/logout', function () { 
    return redirect()->route('admin.dashboard'); 
});
});