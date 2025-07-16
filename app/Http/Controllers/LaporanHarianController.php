<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\LaporanHarian;
use App\Models\Penempatan;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanHarianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perPage = 10; // Number of items per page

        if ($user->role === 'admin') {
            $laporans = Laporan::with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
        } elseif ($user->role === 'pembimbing') {
            $laporans = Laporan::whereHas('penempatan', function ($query) use ($user) {
                $query->where('pembimbing_id', $user->pembimbing->id);
            })
                ->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
        } elseif ($user->role === 'industri') {
            $laporans = Laporan::whereHas('penempatan', function ($query) use ($user) {
                $query->where('industri_id', $user->industri->id);
            })
                ->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
        } elseif ($user->role === 'siswa') {
            if ($user->role !== 'siswa') {
                return redirect()->route('dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
            $siswa = Siswa::where('user_id', $user->id)->first();
            // Ambil data laporan harian siswa
            $laporans = LaporanHarian::where('siswa_id', $siswa->id)
                ->with(['penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
            return view('laporan-harian.index', compact('laporans'));
        } else {
            $laporans = Laporan::query()->paginate($perPage); // Empty paginated collection
        }

        return view('laporan-harian.index', compact('laporans'));
    }

    public function create()
    {
        $siswa = Siswa::find(Auth::user()->id);
        $penempatan = Penempatan::where('siswa_id', $siswa->id)->first();
        if (!$penempatan) {
            return redirect()->back()->with('error', 'Anda belum memiliki penempatan');
        }
        if ($penempatan) {
            $penempatan->tanggal_penempatan = Carbon::parse($penempatan->tanggal_penempatan);
        }
        return view('laporan-harian.create', compact('penempatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penempatan_id' => 'required|exists:penempatans,id',
            'kegiatan' => 'required|string|max:2000',
            'catatan' => 'nullable|string'
        ]);

        LaporanHarian::create([
            'siswa_id' => $request->siswa_id,
            'penempatan_id' => $request->penempatan_id,
            'kegiatan' => $request->kegiatan,
            'catatan' => $request->catatan,
            'tanggal' => now(),
            'status_validasi' => 'menunggu'
        ]);

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan harian berhasil dikirim!');
    }

    public function show(LaporanHarian $laporanharian, $id)
    {

        $laporan = LaporanHarian::with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
            ->findOrFail($id);
        return view('laporan-harian.show', compact('laporan'));
    }
}
