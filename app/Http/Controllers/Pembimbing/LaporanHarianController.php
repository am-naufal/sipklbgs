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

        if (in_array($user->role, ['admin', 'pembimbing', 'industri'])) {
            if ($user->role === 'pembimbing') {
                // Ambil siswa bimbingan pembimbing
                $siswaIds = $user->pembimbing->penempatans()->pluck('siswa_id')->toArray();
                $laporansQuery = LaporanHarian::whereIn('siswa_id', $siswaIds);
            } elseif ($user->role === 'industri') {
                $laporansQuery = LaporanHarian::whereHas('penempatan', function ($query) use ($user) {
                    $query->where('industri_id', $user->industri->id);
                });
            } else {
                $laporansQuery = LaporanHarian::query();
            }

            $laporansAll = $laporansQuery->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->get();

            $uniqueLaporans = [];
            $siswaIds = [];

            foreach ($laporansAll as $laporan) {
                if (!in_array($laporan->siswa_id, $siswaIds)) {
                    $uniqueLaporans[] = $laporan;
                    $siswaIds[] = $laporan->siswa_id;
                }
            }

            // Manual pagination for $uniqueLaporans array
            $currentPage = request()->get('page', 1);
            $itemsForCurrentPage = array_slice($uniqueLaporans, ($currentPage - 1) * $perPage, $perPage);
            $laporans = new \Illuminate\Pagination\LengthAwarePaginator(
                $itemsForCurrentPage,
                count($uniqueLaporans),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('laporan-harian.index', compact('laporans'));
        } elseif ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            // Ambil data laporan harian siswa
            $laporans = LaporanHarian::where('siswa_id', $siswa->id)
                ->with(['penempatan.industri', 'penempatan.pembimbing'])
                ->latest()
                ->paginate($perPage);
            return view('laporan-harian.index', compact('laporans'));
        } else {
            $laporans = LaporanHarian::query()->paginate($perPage); // Empty paginated collection
        }
    }

    public function showBySiswa($siswa_id)
    {
        $user = Auth::user();
        $perPage = 10;

        // Optional: add authorization check here if needed

        $laporans = LaporanHarian::where('siswa_id', $siswa_id)
            ->with(['penempatan.industri', 'penempatan.pembimbing'])
            ->latest()
            ->paginate($perPage);

        $siswa = Siswa::findOrFail($siswa_id);

        return view('laporan-harian.showlist', compact('laporans', 'siswa'));
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

    public function show($id)
    {

        $laporan = LaporanHarian::with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
            ->findOrFail($id);
        return view('laporan-harian.show', compact('laporan'));
    }

    public function edit($id)
    {
        // Pastikan hanya siswa pemilik laporan yang bisa edi
        $laporan = LaporanHarian::with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
            ->findOrFail($id);
        // Pastikan hanya laporan dengan status 'menunggu' yang bisa diedit
        if ($laporan->status_validasi !== 'menunggu') {
            return redirect()->route('laporan-harian.index')
                ->with('error', 'Laporan yang sudah divalidasi tidak dapat diubah.');
        }

        $penempatan = $laporan->penempatan;
        return view('laporan-harian.edit', compact('laporan', 'penempatan'));
    }
    public function update(Request $request, $id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        // Pastikan hanya siswa pemilik laporan yang bisa update
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if ($laporan->siswa_id !== $siswa->id) {
            abort(403);
        }

        // Pastikan hanya laporan dengan status 'menunggu' yang bisa diupdate
        if ($laporan->status_validasi !== 'menunggu') {
            return back()->with('error', 'Laporan yang sudah divalidasi tidak dapat diubah.');
        }


        // Validasi input
        $request->validate([
            'kegiatan' => 'required|string|min:20|max:2000',
            'catatan' => 'nullable|string|max:1000'
        ]);

        // Update data
        $laporan->update([
            'kegiatan' => $request->kegiatan,
            'catatan' => $request->catatan,
            'status_validasi' => 'menunggu' // Reset status setelah edit
        ]);

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan berhasil diperbarui!');
    }
    public function destroy(LaporanHarian $laporan)
    {
        // Pastikan hanya siswa pemilik laporan yang bisa hapus
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if ($laporan->siswa_id !== $siswa->id) {
            abort(403);
        }

        // Pastikan hanya laporan 'menunggu' yang bisa dihapus
        if ($laporan->status_validasi !== 'menunggu') {
            return back()->with('error', 'Laporan yang sudah divalidasi tidak dapat dihapus.');
        }

        $laporan->delete();
        return back()->with('success', 'Laporan berhasil dihapus!');
    }



    public function validasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'keterangan_validasi' => 'nullable|string',
        ]);

        $laporan = LaporanHarian::findOrFail($id);
        // Update status_validasi dan keterangan_validasi jika ada
        $laporan->status_validasi = $request->status;
        if ($request->has('keterangan_validasi')) {
            $laporan->keterangan_validasi = 'Sudah divalidasi oleh ' . Auth::user()->name . ' pada ' . now()->format('d-m-Y H:i:s');
        }
        $laporan->save();

        return redirect()->back()->with('success', 'Status validasi laporan berhasil diperbarui.');
    }
}
