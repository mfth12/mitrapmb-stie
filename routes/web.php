<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\PendaftaranController;

// Rute "/" universal, tidak pakai middleware
Route::get('/', fn() => redirect()->route(Auth::check() ? 'dashboard.index' : 'login'));

// Rute masuk
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [MasukController::class, 'index'])->name('login');
    Route::post('/login', [MasukController::class, 'masuk'])->name('login.do');
});

// Rute dasbor dengan permission
Route::middleware(['auth'])->group(function () {
    // Dashboard routes - semua role yang login bisa akses dashboard
    Route::get('/dasbor', [DasborController::class, 'index'])->name('dashboard.index')
        ->middleware('permission:dashboard_view');

    Route::get('/dasbor_lawas', [DasborController::class, 'index_lawas'])->name('dashboard.lawas')
        ->middleware('permission:dashboard_view');

    Route::post('/keluar', [MasukController::class, 'keluar'])->name('logout');

    // Rute Profil Pribadi
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'show'])->name('profil.show');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/update', [ProfilController::class, 'update'])->name('profil.update');
        Route::put('/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update-password');
        Route::delete('/avatar', [ProfilController::class, 'deleteAvatar'])->name('profil.avatar.delete');
    });

    // Manajemen Pengguna Routes - hanya untuk superadmin dan baak
    Route::prefix('pengguna')->middleware(['permission:user_view'])->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/buat', [PenggunaController::class, 'create'])->name('pengguna.create')
            ->middleware('permission:user_create');
        Route::post('/', [PenggunaController::class, 'store'])->name('pengguna.store')
            ->middleware('permission:user_create');
        Route::get('/{pengguna}', [PenggunaController::class, 'show'])->name('pengguna.show');
        Route::get('/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit')
            ->middleware('permission:user_edit');
        Route::put('/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update')
            ->middleware('permission:user_edit');
        Route::delete('/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy')
            ->middleware('permission:user_delete');
        Route::post('/{pengguna}/reset-password', [PenggunaController::class, 'resetPassword'])->name('pengguna.reset-password')
            ->middleware('permission:user_edit');
        Route::delete('/{pengguna}/avatar', [PenggunaController::class, 'deleteAvatar'])->name('pengguna.avatar.delete')
            ->middleware('permission:user_edit');
    });

    // Pendaftaran Routes - bisa diakses oleh multiple roles
    Route::prefix('pendaftaran')->middleware(['permission:pendaftaran_view'])->group(function () {
        Route::get('/', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create')
            ->middleware('permission:pendaftaran_create');
        Route::post('/', [PendaftaranController::class, 'store'])->name('pendaftaran.store')
            ->middleware('permission:pendaftaran_create');
        Route::get('/{pendaftaran}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::get('/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit')
            ->middleware('permission:pendaftaran_edit');
        Route::put('/{pendaftaran}', [PendaftaranController::class, 'update'])->name('pendaftaran.update')
            ->middleware('permission:pendaftaran_edit');
        Route::delete('/{pendaftaran}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy')
            ->middleware('permission:pendaftaran_delete');
    });
});


// Approval Routes - untuk baak dan prodi
Route::prefix('approval')->middleware(['permission:approval_view'])->group(function () {
    Route::get('/', [ApprovalController::class, 'index'])->name('approval.index');
    Route::get('/{pendaftaran}', [ApprovalController::class, 'show'])->name('approval.show');
    Route::post('/{pendaftaran}/approve', [ApprovalController::class, 'approve'])->name('approval.approve')
        ->middleware('permission:approval_approve');
    Route::post('/{pendaftaran}/reject', [ApprovalController::class, 'reject'])->name('approval.reject')
        ->middleware('permission:approval_reject');
    Route::post('/{pendaftaran}/verify', [ApprovalController::class, 'verify'])->name('approval.verify')
        ->middleware('permission:approval_verify');
});

// Keuangan Routes - khusus untuk role keuangan
Route::prefix('keuangan')->middleware(['permission:keuangan_view'])->group(function () {
    Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/{pendaftaran}/process', [KeuanganController::class, 'process'])->name('keuangan.process')
        ->middleware('permission:keuangan_manage');
});

// Akademik Routes - untuk prodi dan dosen
Route::prefix('akademik')->middleware(['permission:akademik_view'])->group(function () {
    Route::get('/', [AkademikController::class, 'index'])->name('akademik.index');
    Route::post('/manage', [AkademikController::class, 'manage'])->name('akademik.manage')
        ->middleware('permission:akademik_manage');
});
