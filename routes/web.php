<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('app');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name(name: 'dashboard');
Route::get('/books', [BookController::class, 'index'])->name('books');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
