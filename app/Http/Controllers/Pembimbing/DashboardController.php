<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembimbing;
use App\Models\Penempatan;
use App\Models\LaporanHarian;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembimbing = $user->pembimbing;
        // Total siswa bimbingan
        $totalSiswa = Penempatan::where('pembimbing_id', $pembimbing->id)->count();
        // Laporan harian yang belum diverifikasi
        $laporanHarianPending = LaporanHarian::whereHas('penempatan', function ($q) use ($pembimbing) {
            $q->where('pembimbing_id', $pembimbing->id);
        })->where('status_validasi', 'menunggu')->count();
        // Laporan akhir yang menunggu pengecekan
        // Kolom status sudah benar, namun jika error, cek migrasi dan field pada tabel laporans
        $laporanAkhirPending = Laporan::whereHas('penempatan', function ($q) use ($pembimbing) {
            $q->where('pembimbing_id', $pembimbing->id);
        });
        // Pastikan field status ada di tabel laporans
        if (\Schema::hasColumn('laporans', 'status')) {
            $laporanAkhirPending = $laporanAkhirPending->where('status', 'menunggu')->count();
        } else {
            // fallback jika field masih bernama status_validasi
            $laporanAkhirPending = $laporanAkhirPending->where('status_validasi', 'menunggu')->count();
        }
        // Total catatan bimbingan (misal: dari laporan harian yang diverifikasi atau catatan bimbingan lain)
        $totalCatatan = LaporanHarian::whereHas('penempatan', function ($q) use ($pembimbing) {
            $q->where('pembimbing_id', $pembimbing->id);
        })->whereNotNull('catatan')->count();
        return view('pembimbing.dashboard', compact('totalSiswa', 'laporanHarianPending', 'laporanAkhirPending', 'totalCatatan'));
    }
}
