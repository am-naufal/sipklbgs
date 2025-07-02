<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;

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
}
