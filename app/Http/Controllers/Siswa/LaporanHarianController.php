<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanHarianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perPage = 10;

        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $laporans = LaporanHarian::where('siswa_id', $siswa->id)
            ->with(['penempatan.industri', 'penempatan.pembimbing'])
            ->latest()
            ->paginate($perPage);

        return view('siswa.laporan-harian.index', compact('laporans'));
    }

    public function create()
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $penempatan = Penempatan::where('siswa_id', $siswa->id)->first();
        if (!$penempatan) {
            return redirect()->back()->with('error', 'Anda belum memiliki penempatan');
        }

        return view('siswa.laporan-harian.create', compact('penempatan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'penempatan_id' => 'required|exists:penempatans,id',
            'kegiatan' => 'required|string|max:2000',
            'catatan' => 'nullable|string'
        ]);

        LaporanHarian::create([
            'siswa_id' => $siswa->id,
            'penempatan_id' => $request->penempatan_id,
            'kegiatan' => $request->kegiatan,
            'catatan' => $request->catatan,
            'tanggal' => now(),
            'status_validasi' => 'menunggu'
        ]);

        return redirect()->route('siswa.laporan-harian.index')
            ->with('success', 'Laporan harian berhasil dikirim!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $laporan = LaporanHarian::with(['penempatan.industri', 'penempatan.pembimbing'])
            ->where('siswa_id', $siswa->id)
            ->findOrFail($id);

        return view('siswa.laporan-harian.show', compact('laporan'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $laporan = LaporanHarian::where('siswa_id', $siswa->id)
            ->findOrFail($id);

        if ($laporan->status_validasi !== 'menunggu') {
            return redirect()->route('siswa.laporan-harian.index')
                ->with('error', 'Laporan yang sudah divalidasi tidak dapat diubah.');
        }

        $penempatan = $laporan->penempatan;

        return view('siswa.laporan-harian.edit', compact('laporan', 'penempatan'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $laporan = LaporanHarian::where('siswa_id', $siswa->id)
            ->findOrFail($id);

        if ($laporan->status_validasi !== 'menunggu') {
            return back()->with('error', 'Laporan yang sudah divalidasi tidak dapat diubah.');
        }

        $request->validate([
            'kegiatan' => 'required|string|min:20|max:2000',
            'catatan' => 'nullable|string|max:1000'
        ]);

        $laporan->update([
            'kegiatan' => $request->kegiatan,
            'catatan' => $request->catatan,
            'status_validasi' => 'menunggu'
        ]);

        return redirect()->route('siswa.laporan-harian.index')
            ->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa ?? null;
        if (!$siswa) {
            abort(403, 'Unauthorized');
        }

        $laporan = LaporanHarian::where('siswa_id', $siswa->id)
            ->findOrFail($id);

        if ($laporan->status_validasi !== 'menunggu') {
            return back()->with('error', 'Laporan yang sudah divalidasi tidak dapat dihapus.');
        }

        $laporan->delete();

        return redirect()->route('siswa.laporan-harian.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
