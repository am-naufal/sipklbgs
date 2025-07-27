<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenempatanController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {

            $penempatans = Penempatan::with(['siswa', 'industri', 'pembimbing'])->get();
            return view('admin.penempatans.index', compact('penempatans'));
        } elseif (Auth::user()->role === 'pembimbing') {
            $pembimbing = Pembimbing::where('user_id', Auth::user()->id)->first();
            $penempatans = Penempatan::where('pembimbing_id', $pembimbing->id)
                ->with(['siswa', 'industri'])
                ->get();
            return view('pembimbing.penempatans.index', compact('penempatans'));
        }
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
        if (Auth::user()->role === 'admin') {
            $penempatan->load(['siswa', 'industri', 'pembimbing']);
            return view('admin.penempatans.show', compact('penempatan'));
        } elseif (Auth::user()->role === 'pembimbing') {

            $pembimbing = Pembimbing::where('user_id', Auth::user()->id)->first();
            if ($penempatan->pembimbing_id !== $pembimbing->id) {
                abort(403, 'Unauthorized action.');
            }
            $penempatan->load(['siswa', 'industri']);

            return view('pembimbing.penempatans.show', compact('penempatan'));
        }
    }

    public function edit(Penempatan $penempatan)
    {
        if (Auth::user()->role === 'admin') {
            $penempatan->load(['siswa', 'industri', 'pembimbing']);
            return view('admin.penempatans.edit', compact('penempatan'));
        } elseif (Auth::user()->role === 'pembimbing') {
            $penempatan->load(['siswa', 'industri', 'pembimbing']);
            return view('pembimbing.penempatans.edit', compact('penempatan'));
        }
    }

    public function update(Request $request, Penempatan $penempatan)
    {

        $request->validate([
            'industri_id' => 'required|exists:industris,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
            'status' => 'required|string|max:255',
            'tanggal_penempatan' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_penempatan',
            'keterangan' => 'nullable|string|max:1000',
        ]);
        $penempatan->update($request->all());
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.penempatans.index')->with('success', 'Penempatan berhasil diupdate.');
        } elseif (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.penempatans.index')->with('success', 'Penempatan berhasil diupdate.');
        }
    }

    public function destroy(Penempatan $penempatan)
    {
        $penempatan->delete();
        if (Auth::user()->role === 'admin') {

            return redirect()->route('admin.penempatans.index')->with('success', 'Penempatan berhasil dihapus.');
        } elseif (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.penempatans.index')->with('success', 'Penempatan berhasil dihapus.');
        }
    }
}
