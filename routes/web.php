<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KosController as AdminKosController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemilikKos\DashboardController as PemilikKosDashboardController;
use App\Http\Controllers\PemilikKos\KosController as PemilikKosKosController;
use App\Http\Controllers\PemilikKos\LaporanController as PemilikKosLaporanController;
use App\Http\Controllers\PemilikKos\PenghuniController as PemilikKosPenghuniController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\KosController;
use App\Http\Controllers\SuperAdmin\LaporanController as SuperAdminLaporanController;
use App\Http\Controllers\SuperAdmin\WilayahController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    // Logout must remain available to authenticated users, including inactive accounts.
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('super-admin')->name('super-admin.')->middleware('role:super_admin')->group(function () {
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

        Route::get('/laporan', [SuperAdminLaporanController::class, 'index'])->name('laporan.index');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/kos', [AdminKosController::class, 'index'])->name('kos.index');
        Route::get('/kos/{kos}', [AdminKosController::class, 'show'])->name('kos.show');
        Route::patch('/kos/{kos}/verify', [AdminKosController::class, 'verify'])->name('kos.verify');
        Route::patch('/kos/{kos}/reject', [AdminKosController::class, 'reject'])->name('kos.reject');
        Route::get('/penghuni', [AdminPenghuniController::class, 'index'])->name('penghuni.index');
        Route::get('/penghuni/{penghuni}', [AdminPenghuniController::class, 'show'])->name('penghuni.show');
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    });

    Route::prefix('pemilik-kos')->name('pemilik-kos.')->middleware('role:pemilik_kos')->group(function () {
        Route::get('/dashboard', PemilikKosDashboardController::class)->name('dashboard');

        Route::prefix('kos')->name('kos.')->group(function () {
            Route::get('/', [PemilikKosKosController::class, 'index'])->name('index');
            Route::get('/create', [PemilikKosKosController::class, 'create'])->name('create');
            Route::post('/', [PemilikKosKosController::class, 'store'])->name('store');
            Route::get('/{kos}', [PemilikKosKosController::class, 'show'])->name('show');
            Route::get('/{kos}/edit', [PemilikKosKosController::class, 'edit'])->name('edit');
            Route::put('/{kos}', [PemilikKosKosController::class, 'update'])->name('update');
        });

        Route::prefix('penghuni')->name('penghuni.')->group(function () {
            Route::get('/', [PemilikKosPenghuniController::class, 'index'])->name('index');
            Route::get('/riwayat', [PemilikKosPenghuniController::class, 'history'])->name('history');
            Route::get('/create', [PemilikKosPenghuniController::class, 'create'])->name('create');
            Route::post('/', [PemilikKosPenghuniController::class, 'store'])->name('store');
            Route::get('/{penghuni}', [PemilikKosPenghuniController::class, 'show'])->name('show');
            Route::get('/{penghuni}/edit', [PemilikKosPenghuniController::class, 'edit'])->name('edit');
            Route::put('/{penghuni}', [PemilikKosPenghuniController::class, 'update'])->name('update');
            Route::patch('/{penghuni}/keluar', [PemilikKosPenghuniController::class, 'markAsExited'])->name('keluar');
        });

        Route::get('/laporan', [PemilikKosLaporanController::class, 'index'])->name('laporan.index');
    });
});
