<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;

Route::view('/', 'welcome');

// Dashboard User
Route::middleware(['auth', 'verified'])
    ->get('/dashboard', [UserDashboard::class, 'index'])
    ->name('dashboard');

// Dashboard Admin
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])
            ->name('dashboard');
        
        // Users Management
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');
        
        // Products Management - CRUD LENGKAP
        Route::resource('products', ProductController::class);
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');
    });

// Profile (untuk user & admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';