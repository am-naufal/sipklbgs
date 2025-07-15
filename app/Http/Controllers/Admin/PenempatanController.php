<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        $penempatans = Penempatan::with(['siswa', 'industri', 'pembimbing'])->get();
        return view('admin.penempatans.index', compact('penempatans'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $industris = Industri::all();
        $pembimbings = Pembimbing::all();
        return view('admin.penempatans.create', compact('siswas', 'industris', 'pembimbings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'industri_id' => 'required|exists:industris,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
            'status' => 'required|string|max:255',
            'tanggal_penempatan' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_penempatan',
            'keterangan' => 'nullable|string|max:1000',
        ]);
        Penempatan::create($request->all());
        return redirect()->route('admin.penempatans.index')->with('success', 'Penempatan berhasil ditambahkan.');
    }

    public function show(Penempatan $penempatan)
    {
        $penempatan->load(['siswa', 'industri', 'pembimbing']);
        return view('admin.penempatans.show', compact('penempatan'));
    }

    public function edit(Penempatan $penempatan)
    {
        $siswas = Siswa::all();
        $industris = Industri::all();
        $pembimbings = Pembimbing::all();
        return view('admin.penempatans.edit', compact('penempatan', 'siswas', 'industris', 'pembimbings'));
    }

    public function update(Request $request, Penempatan $penempatan)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'industri_id' => 'required|exists:industris,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
            'status' => 'required|string|max:255',
            'tanggal_penempatan' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_penempatan',
            'keterangan' => 'nullable|string|max:1000',
        ]);
        $penempatan->update($request->all());
        return redirect()->route('admin.penempatans.index')->with('success', 'Penempatan berhasil diupdate.');
    }

    public function destroy(Penempatan $penempatan)
    {
        $penempatan->delete();
        return redirect()->route('admin.penempatans.index')->with('success', 'Penempatan berhasil dihapus.');
    }
}
