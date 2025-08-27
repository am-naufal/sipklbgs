<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\Penempatan;
use App\Models\Laporan;
use App\Models\LaporanHarian;
use App\Models\Penilaian;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSiswas = Siswa::count();
        $totalIndustris = Industri::count();
        $totalPembimbings = Pembimbing::count();
        return view('admin.dashboard', compact('totalUsers', 'totalSiswas', 'totalIndustris', 'totalPembimbings'));
    }

    public function siswaIndex()
    {
        // dd(Auth::user());
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if (!$siswa) {
            abort(404, 'Siswa not found.');
        }
        $penempatan = Penempatan::with('industri', 'pembimbing', 'siswa')->where('siswa_id', $siswa->id)->first();
        $totalPenempatan = Penempatan::where('siswa_id', $siswa->id)->count();
        return view('siswa.dashboard', compact('totalPenempatan', 'penempatan'));
    }

    public function kepalaSekolahIndex()
    {
        $totalSiswas = Siswa::count();
        $totalPembimbings = Pembimbing::count();
        $totalIndustris = Industri::count();
        $totalPenempatans = Penempatan::count();
        $totalLaporanHarian = LaporanHarian::count();
        $totalLaporanAkhir = Laporan::count();
        $totalPenilaian = Penilaian::count();

        // Count active PKL students (students with active placements)
        $siswaAktifPKL = Penempatan::where('status', 'active')->count();

        return view('kepala_sekolah.dashboard', compact(
            'totalSiswas',
            'totalPembimbings',
            'totalIndustris',
            'totalPenempatans',
            'totalLaporanHarian',
            'totalLaporanAkhir',
            'totalPenilaian',
            'siswaAktifPKL'
        ));
    }
}
