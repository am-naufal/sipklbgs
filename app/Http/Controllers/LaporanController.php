<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
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
        if (Auth::user()->role === 'admin') {
            $laporans = Laporan::with(['siswa', 'penempatan'])->latest()->paginate(10);
        } elseif (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            if (!$siswa) {
                abort(404, 'Siswa not found.');
            }
            $laporans = Laporan::where('siswa_id', $siswa->id)->with(['penempatan.industri', 'penempatan.pembimbing'])->first();
            return view('siswa.laporan.index', compact('laporans'));
        } elseif (Auth::user()->role === 'pembimbing') {
            $laporans = Laporan::whereHas('penempatan', function ($query) {
                $query->where('pembimbing_id', Auth::user()->pembimbing->id);
            })->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])->latest()->paginate(10);
        } elseif (Auth::user()->role === 'industri') {
            $laporans = Laporan::whereHas('penempatan', function ($query) {
                $query->where('industri_id', Auth::user()->industri->id);
            })->with(['siswa', 'penempatan.industri', 'penempatan.pembimbing'])->latest()->paginate(10);
        } else {
            $laporans = Laporan::query()->paginate(10); // Empty paginated collection
        }

        return view('laporan.index', compact('laporans'));
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

        return view('siswa.laporan.index', compact('laporans', 'totalLaporan', 'lastSubmission'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            if (!$siswa) {
                abort(404, 'Siswa not found.');
            }
            $penempatan = Penempatan::where('siswa_id', $siswa->id)->first();
            if (!$penempatan) {
                return redirect()->back()->with('error', 'Anda belum memiliki penempatan');
            }
            return view('siswa.laporan.create', compact('siswa', 'penempatan'));
        } elseif (Auth::user()->role === 'admin') {
            // Admin can create laporan for any siswa
            $siswas = Siswa::all();
        } elseif (Auth::user()->role === 'pembimbing' || Auth::user()->role === 'industri') {
            // Pembimbing and Industri can create laporan for their respective penempatan
            $penempatan = Penempatan::where('pembimbing_id', Auth::user()->pembimbing->id)
                ->orWhere('industri_id', Auth::user()->industri->id)
                ->first();
            if (!$penempatan) {
                return redirect()->back()->with('error', 'Anda belum memiliki penempatan');
            }
        }
        $siswas = Siswa::all();
        $penempatans = Penempatan::all();

        return view('laporan.create', compact('siswas', 'penempatans'));
    }

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

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
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

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
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
            return view('siswa.laporan.show', compact('laporan'));
        } elseif (Auth::user()->role === 'admin' || Auth::user()->role === 'pembimbing' || Auth::user()->role === 'industri') {
            $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
            return view('laporan.show', compact('laporan'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {

        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        } elseif (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            if (!$siswa || $laporan->siswa_id !== $siswa->id) {
                abort(404, 'Laporan not found for this siswa.');
            }
            $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
            return view('siswa.laporan.edit', compact('laporan'));
        } elseif (Auth::user()->role === 'admin') {
            // Admin can edit any laporan
            $laporan->load(['siswa', 'penempatan.industri', 'penempatan.pembimbing']);
            return view('laporan.edit', compact('laporan'));
        } elseif (Auth::user()->role === 'pembimbing' || Auth::user()->role === 'industri') {
            // Pembimbing and Industri can edit laporan for their respective penempatan
            $penempatan = Penempatan::where('pembimbing_id', Auth::user()->pembimbing->id)
                ->orWhere('industri_id', Auth::user()->industri->id)
                ->first();
            if (!$penempatan || $laporan->penempatan_id !== $penempatan->id) {
                abort(404, 'Laporan not found for this penempatan.');
            }
        }
        $siswas = Siswa::all();
        $penempatans = Penempatan::all();

        return view('laporan.edit', compact('laporan', 'siswas', 'penempatans'));
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
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui!');
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

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui!');
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

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Download file laporan
     */
    public function download(Laporan $laporan)
    {
        if (!Storage::disk('public')->exists($laporan->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($laporan->file_path);
    }
}
