<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name(name: 'dashboard');
Route::get('/buku', [BookController::class, 'index'])->name('buku');
Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori');
Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna');
Route::get('/anggota', [UserController::class, 'index'])->name('anggota');
