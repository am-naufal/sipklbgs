<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\Penempatan;

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
}
