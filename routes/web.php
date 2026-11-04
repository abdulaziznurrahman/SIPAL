<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserBorrowingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminToolController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Root: langsung arahkan ke login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/logout-dev', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// ============ SISWA  ============
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [UserBorrowingController::class, 'dashboard']);
    Route::get('/katalog', [ToolController::class, 'index']);
    Route::get('/katalog/{tool}', [ToolController::class, 'show']);

    Route::get('/pinjam/{tool}', [UserBorrowingController::class, 'create']);
    Route::post('/pinjam', [UserBorrowingController::class, 'store']);

    Route::get('/riwayat', [UserBorrowingController::class, 'history']);
});

// ============ ADMIN ============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/export/pdf', [AdminDashboardController::class, 'exportPdf']);
    Route::get('/export/excel', [AdminDashboardController::class, 'exportExcel']);
    
    // Kelola User (Siswa & Guru)
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}/edit', [UserController::class, 'edit']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    // Verifikasi Peminjaman
    Route::put('/borrowings/{borrowing}/approve', [AdminDashboardController::class, 'approve']);
    Route::put('/borrowings/{borrowing}/reject', [AdminDashboardController::class, 'reject']);
    Route::put('/borrowings/{borrowing}/return', [AdminDashboardController::class, 'returnTool']);

    // Kategori
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Alat
    Route::get('/tools', [AdminToolController::class, 'index']);
    Route::get('/tools/create', [AdminToolController::class, 'create']);
    Route::post('/tools', [AdminToolController::class, 'store']);
    Route::get('/tools/{tool}/edit', [AdminToolController::class, 'edit']);
    Route::put('/tools/{tool}', [AdminToolController::class, 'update']);
    Route::delete('/tools/{tool}', [AdminToolController::class, 'destroy']);
});

// Profil (Bisa diakses Admin, Siswa, dan Guru)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']); 
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']);
});