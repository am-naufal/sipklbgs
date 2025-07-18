<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Siswa\PenempatanController\PenempatanController as SiswaPenempatanController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\LaporanController;
use App\Models\Industri;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest-page.home');
});



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::resource('users', UserController::class)->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('siswas', SiswaController::class);
    Route::resource('pembimbings', PembimbingController::class);
    Route::resource('industris', IndustriController::class);
    Route::resource('laporans', LaporanController::class);
    Route::resource('penempatans', PenempatanController::class);
});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswaIndex'])->name('siswa.dashboard');
    Route::get('/profile', [ProfileController::class, 'siswaEdit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'siswaUpdate'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'siswaDestroy'])->name('profile.destroy');
    Route::get('/list-industri', [IndustriController::class, 'list'])->name('siswa.list-industri');
    Route::resource('penempatans', \App\Http\Controllers\Siswa\PenempatanController::class);
    Route::resource('laporan-harian', \App\Http\Controllers\LaporanHarianController::class);
});
require __DIR__ . '/auth.php';
Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    return 'Cache cleared!';
});
