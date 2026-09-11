<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Selamat datang di Toko sinar sejahtera! Kami menjual berbagai kebutuhan sehari-hari dengan harga yang sangat terjangkau';
});

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/categories', function () {
        return 'Halaman kelola kategori (khusus admin)';
    })->name('categories.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', function () {
        return 'Halaman kelola akun kasir (khusus admin)';
    })->name('users.index');
});