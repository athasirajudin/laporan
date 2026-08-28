<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\KosController;
use App\Http\Controllers\SuperAdmin\WilayahController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('role:super_admin')->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/', [AdminController::class, 'store'])->name('store');
            Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
            Route::patch('/{admin}/status', [AdminController::class, 'toggleStatus'])->name('status');
        });

        Route::prefix('wilayah')->name('wilayah.')->group(function () {
            Route::get('/', [WilayahController::class, 'index'])->name('index');
            Route::get('/create', [WilayahController::class, 'create'])->name('create');
            Route::post('/', [WilayahController::class, 'store'])->name('store');
            Route::get('/{wilayah}', [WilayahController::class, 'show'])->name('show');
            Route::get('/{wilayah}/edit', [WilayahController::class, 'edit'])->name('edit');
            Route::put('/{wilayah}', [WilayahController::class, 'update'])->name('update');
        });

        Route::prefix('kos')->name('kos.')->group(function () {
            Route::get('/', [KosController::class, 'index'])->name('index');
            Route::get('/{kos}', [KosController::class, 'show'])->name('show');
            Route::patch('/{kos}/verify', [KosController::class, 'verify'])->name('verify');
            Route::patch('/{kos}/reject', [KosController::class, 'reject'])->name('reject');
        });
    });
});
