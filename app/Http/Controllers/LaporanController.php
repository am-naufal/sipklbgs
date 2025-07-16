<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanPKLController extends Controller
{
    public function create()
    {
        return view('laporan-pkl.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:doc,docx,pdf|max:2048',
            'catatan' => 'nullable|string'
        ]);

        $filePath = $request->file('file')->store('laporan-pkl');

        Laporan::create([
            'siswa_id' => auth()->user()->siswa->id,
            'penempatan_id' => auth()->user()->siswa->penempatan->id,
            'judul' => $request->judul,
            'file_path' => $filePath,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
            'catatan_revisi' => ''
        ]);

        return redirect()->route('laporan-pkl.index')
            ->with('success', 'Laporan berhasil diupload!');
    }

    public function index()
    {
        $laporans = Laporan::where('siswa_id', auth()->user()->siswa->id)
            ->latest()
            ->paginate(10);

        return view('laporan-pkl.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        $this->authorize('view', $laporan);

        return view('laporan-pkl.show', compact('laporan'));
    }

    public function revisi(Request $request, Laporan $laporan)
    {
        $this->authorize('revisi', $laporan);

        $request->validate([
            'catatan_revisi' => 'required|string',
            'status' => 'required|in:valid,revisi'
        ]);

        $laporan->update([
            'catatan_revisi' => $request->catatan_revisi,
            'status' => $request->status
        ]);

        return back()->with('success', 'Catatan revisi berhasil disimpan');
    }
}
