<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KepalaSekolah\DashboardController as KepalaSekolahDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Siswa\PenempatanController\PenempatanController as SiswaPenempatanController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\Siswa\LaporanHarianController as SiswaLaporanHarianController;
use App\Http\Controllers\Pembimbing\LaporanHarianController as pPembimbingLaporanHarianController;
use App\Http\Controllers\Pembimbing\LaporanController as PembimbingLaporanController;
use App\Http\Controllers\Pembimbing\LaporanHarianController as PembimbingLaporanHarianController;
use App\Http\Controllers\Pembimbing\PenempatanController as PembimbingPenempatanController;
use App\Http\Controllers\PenilaianController;
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
    //laporans
    Route::resource('laporans', LaporanController::class);
    Route::get('/laporans/download/{laporans}', [LaporanController::class, 'adminDownload'])->name('laporans.download');
    Route::resource('penempatans', PenempatanController::class);
    Route::get('/laporans/show/list/{id}', [LaporanController::class, 'showList'])->name('laporans.show.list');
    Route::post('/laporans/{id}/validasi', [LaporanController::class, 'validasi'])
        ->name('laporans.validasi');
    //laporan-harian
    Route::resource('laporan-harian', LaporanHarianController::class);
    Route::get('laporan-harian/siswa/{siswa_id}', [LaporanHarianController::class, 'showBySiswa'])->name('laporan-harian.bysiswa');
    Route::post('/laporan-harian/{id}/validasi', [LaporanHarianController::class, 'validasi'])
        ->name('laporan-harian.validasi');
    //penilaian
    Route::resource('penilaian', PenilaianController::class);
    Route::get('penilaian/teknis/create', [PenilaianController::class, 'createTeknis'])->name('penilaian.teknis.create');
    Route::post('penilaian/teknis', [PenilaianController::class, 'storeTeknis'])->name('penilaian.teknis.store');
    Route::get('penilaian/non-teknis/create', [PenilaianController::class, 'createNonTeknis'])->name('penilaian.nonteknis.create');
    Route::post('penilaian/non-teknis', [PenilaianController::class, 'storeNonTeknis'])->name('penilaian.nonteknis.store');
});


Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswaIndex'])->name('siswa.dashboard');
    Route::get('/profile', [ProfileController::class, 'siswaEdit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'siswaUpdate'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'siswaDestroy'])->name('profile.destroy');
    Route::get('/list-industri', [IndustriController::class, 'list'])->name('siswa.list-industri');
    Route::resource('penempatans', \App\Http\Controllers\Siswa\PenempatanController::class);
    Route::resource('laporan-harian', SiswaLaporanHarianController::class);
    Route::get('/laporan', [LaporanController::class, 'indexSiswa'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/download/{laporan}', [LaporanController::class, 'download'])->name('laporan.download');
});
// Route khusus pembimbing
Route::middleware(['auth', 'role:industri'])->prefix('industri')->name('industri.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\IndustriController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'industriEdit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'industriUpdate'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'industriDestroy'])->name('profile.destroy');
    Route::resource('laporan-harian', LaporanHarianController::class);
});
Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->name('pembimbing.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('laporan-harian', PembimbingLaporanHarianController::class);
    Route::resource('laporans', PembimbingLaporanController::class);
    Route::resource('penempatans', PenempatanController::class);
    //laporan
    Route::get('/laporans/{laporan}', [PembimbingLaporanController::class, 'show'])->name('laporans.show');
    Route::get('/laporans/download/{laporan}', [PembimbingLaporanController::class, 'download'])->name('laporans.download');
    Route::get('/laporans/show/list/{id}', [PembimbingLaporanController::class, 'showList'])->name('laporans.show.list');
    Route::post('/laporans/{id}/validasi', [PembimbingLaporanController::class, 'validasi'])
        ->name('laporans.validasi');
    //penempatan
    Route::get('/penempatan', [PenempatanController::class, 'index'])->name('penempatan.index');
    Route::get('/siswa-bimbingan', [SiswaController::class, 'siswaBimbingan'])->name('siswas.index');
    Route::get('/siswa-bimbingan/show/{siswa}', [SiswaController::class, 'showForPembimbing'])->name('siswas.show');
    //laporan-harian
    Route::get('laporan-harian/siswa/{siswa_id}', [PembimbingLaporanHarianController::class, 'showBySiswa'])->name('laporan-harian.bysiswa');
    Route::post('/laporan-harian/{id}/validasi', [PembimbingLaporanHarianController::class, 'validasi'])
        ->name('laporan-harian.validasi');
});

// Routes khusus Kepala Sekolah
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala_sekolah.')->group(function () {
    Route::get('/dashboard', [KepalaSekolahDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan-statistik', [KepalaSekolahDashboardController::class, 'laporanStatistik'])->name('laporan.statistik');
    Route::get('/penilaian-overview', [KepalaSekolahDashboardController::class, 'penilaianOverview'])->name('penilaian.overview');
});

require __DIR__ . '/auth.php';
Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    return 'Cache cleared!' . 'ok';
});
