<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
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
            $laporans = Laporan::where('siswa_id', $user->siswa->id)
                ->with(['penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
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
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'penempatan_id' => 'required|exists:penempatans,id',
        ]);

        $filePath = $request->file('file_laporan')->store('laporan_harian');

        Laporan::create([
            'siswa_id' => Auth::user()->siswa->id,
            'penempatan_id' => $request->penempatan_id,
            'file_path' => $filePath,
            'status_validasi' => 'menunggu',
            'keterangan_validasi' => '',
        ]);

        return redirect()->route('laporan-harian.index')->with('success', 'Laporan harian berhasil diunggah.');
    }

    public function show(Laporan $laporan)
    {
        // Simple authorization check
        $user = \Illuminate\Support\Facades\Auth::user();
        if (
            $user->role === 'admin' ||
            ($user->role === 'pembimbing' && $laporan->penempatan->pembimbing_id === $user->pembimbing->id) ||
            ($user->role === 'industri' && $laporan->penempatan->industri_id === $user->industri->id) ||
            ($user->role === 'siswa' && $laporan->siswa_id === $user->siswa->id)
        ) {
            return view('laporan-harian.show', compact('laporan'));
        }
        abort(403, 'Unauthorized action.');
    }
}
