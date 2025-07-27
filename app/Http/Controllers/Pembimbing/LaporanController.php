<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pembimbing;
use App\Models\Siswa;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembimbingid = Pembimbing::where('user_id', Auth::user()->id)->first()->id;
        $perPage = 10; // Number of items per page
        if (in_array(Auth::user()->role, ['admin', 'pembimbing', 'industri'])) {
            if (Auth::user()->role === 'pembimbing') {
                // Ambil siswa bimbingan pembimbing

                $laporansAll = Laporan::whereHas('penempatan', function ($query) use ($pembimbingid) {
                    $query->where('pembimbing_id', $pembimbingid);
                })
                    ->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])
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

                return view('pembimbing.laporan.index', compact('laporans'));
            } else {
                $laporans = Laporan::query()->paginate($perPage); // Empty paginated collection
            }
        }
    }
    public function indexSiswa()
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $laporans = Laporan::where('siswa_id', $siswa->id)
            ->with(['penempatan'])
            ->latest()
            ->paginate(10);

        // Hitung statistik laporan
        $totalLaporan = $laporans->count();
        $lastSubmission = $laporans->isNotEmpty() ? $laporans->first()->created_at->diffForHumans() : null;

        return view('siswa.pembimbing.laporan.index', compact('laporans', 'totalLaporan', 'lastSubmission'));
    }
    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (Auth::user()->role === 'admin') {
            // Admin can create laporan for any siswa
            $validated = $request->validate([
                'siswa_id' => 'required|exists:siswas,id',
                'penempatan_id' => 'required|exists:penempatans,id',
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'status' => 'required|in:menunggu,valid,revisi',
            ]);

            // Upload file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('laporan_files', $filename, 'public');
                $validated['file'] = $path;
            }

            Laporan::create($validated);

            return redirect()->route('pembimbing.laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
        } elseif (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            if (!$siswa) {
                abort(404, 'Siswa not found.');
            }
            $validated = $request->validate([
                'siswa_id' => 'required',
                'penempatan_id' => 'required',
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'status' => 'required|in:menunggu,valid,revisi',
            ]);
            // Upload file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('laporan_files', $filename, 'public');
                $validated['file_path'] = $path;
            }

            Laporan::create([
                'siswa_id' => $siswa->id,
                'penempatan_id' => $validated['penempatan_id'],
                'file_path' => $validated['file_path'],
                'status_validasi' => $validated['status'],
            ]);

            return redirect()->route('pembimbing.laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();

        if (Auth::user()->role === 'siswa' && $laporan->siswa_id === $siswa->id) {
            $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
            return view('siswa.pembimbing.laporan.show', compact('laporan'));
        } elseif (Auth::user()->role === 'admin' || Auth::user()->role === 'pembimbing' || Auth::user()->role === 'industri') {
            $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
            return view('pembimbing.laporan.show', compact('laporan'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
        return view('pembimbing.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {

        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        } elseif (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            if (!$siswa || $laporan->siswa_id !== $siswa->id) {
                abort(404, 'Laporan not found for this siswa.');
            }
            $validated = $request->validate([
                'siswa_id' => 'required|exists:siswas,id',
                'penempatan_id' => 'required|exists:penempatans,id',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);
            // Update file if exists

            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($laporan->file_path && Storage::disk('public')->exists($laporan->file_path)) {
                    Storage::disk('public')->delete($laporan->file_path);
                }
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('laporan_files', $filename, 'public');
                $validated['file_path'] = $path;
            } else {
                $validated['file_path'] = $laporan->file_path; // Keep old file
            } // Default to 'menunggu' if not provided
            $laporan->update($validated);
            return redirect()->route('pembimbing.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
        } elseif (Auth::user()->role === 'admin') {
            // Admin can update any laporan
        } elseif (Auth::user()->role === 'pembimbing' || Auth::user()->role === 'industri') {
            // Pembimbing and Industri can update laporan for their respective penempatan
            $penempatan = Penempatan::where('pembimbing_id', Auth::user()->pembimbing->id)
                ->orWhere('industri_id', Auth::user()->industri->id)
                ->first();
            if (!$penempatan || $laporan->penempatan_id !== $penempatan->id) {
                abort(404, 'Laporan not found for this penempatan.');
            }
        }
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'penempatan_id' => 'required|exists:penempatans,id',
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'catatan' => 'nullable|string',
            'status' => 'required|in:menunggu,valid,revisi',
            'catatan_revisi' => 'nullable|string|required_if:status,revisi',
        ]);

        // Update file jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($laporan->file_path && Storage::disk('public')->exists($laporan->file_path)) {
                Storage::disk('public')->delete($laporan->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('laporan_files', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $laporan->update($validated);

        return redirect()->route('pembimbing.laporans.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        // Hapus file jika ada
        if ($laporan->file_path && Storage::disk('public')->exists($laporan->file_path)) {
            Storage::disk('public')->delete($laporan->file_path);
        }

        $laporan->delete();

        return redirect()->route('pembimbing.laporans.index')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Download file laporan
     */
    public function download($id)
    {
        $laporan = Laporan::findOrFail($id);
        $filePath = storage_path('app/' . $laporan->file_path);
        dd($filePath);
        // Untuk pratinjau di iframe, tambahkan header khusus
        if (request()->has('preview')) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $laporan->file_name . '"'
            ]);
        }

        // Untuk download normal
        return response()->download($filePath, $laporan->file_name);
    }
    public function adminDownload(Laporan $laporans)
    {
        if (!Storage::disk('public')->exists($laporans->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($laporans->file_path);
    }
    public function showList($id)
    {
        $laporan = Laporan::find($id);
        $laporans = Laporan::where('siswa_id', $laporan->siswa_id)->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])->get();

        if ($laporans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada laporan untuk penempatan ini.');
        }

        return view('pembimbing.laporan.show-list', compact('laporans'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:valid,revisi',
            'keterangan_validasi' => 'nullable|string',
        ]);

        $laporan = Laporan::findOrFail($id);
        // Update status_validasi dan keterangan_validasi jika ada
        $laporan->status_validasi = $request->status;
        if ($request->has('keterangan_validasi')) {
            $laporan->keterangan_validasi = 'Sudah divalidasi oleh ' . Auth::user()->name . ' pada ' . now()->format('d-m-Y H:i:s') . ' dengan keterangan: ' . $request->keterangan_validasi;
        }
        $laporan->save();

        return redirect()->back()->with('success', 'Status validasi laporan berhasil diperbarui.');
    }
}
