<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah route utama aplikasi kamu.
| - /dashboard → hanya untuk user biasa (auth & verified)
| - /admin → hanya untuk admin (auth & verified)
| - /profile → hanya untuk user yang login
|
*/

// Halaman awal (guest)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard untuk user biasa
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard untuk admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

// Group route untuk profile (user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route auth bawaan Breeze
require __DIR__.'/auth.php';