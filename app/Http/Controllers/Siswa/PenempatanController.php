<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenempatanController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penempatans = Penempatan::where('siswa_id', Auth::user()->siswa->id)
            ->with(['industri', 'pembimbing', 'siswa'])
            ->first();
        return view('siswa.penempatans.index', compact('penempatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403, 'Akses ditolak.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403, 'Akses ditolak.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penempatan $penempatan)
    {
        // Ensure the penempatan belongs to the authenticated siswa
        if ($penempatan->siswa_id !== Auth::user()->siswa->id) {
            abort(403, 'Unauthorized action.');
        }
        $penempatan->load(['industri', 'pembimbing']);
        // Return the view with the penempatan details    {
        return view('siswa.penempatans.show', compact('penempatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penempatan $penempatan)
    {
        abort(403, 'Akses ditolak.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penempatan $penempatan)
    {
        abort(403, 'Akses ditolak.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penempatan $penempatan)
    {
        abort(403, 'Akses ditolak.');
    }
}
