<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Penilaian;
use App\Models\Industri;
use App\Models\Penempatan;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    // Menampilkan daftar nilai siswa
    public function index()
    {
        // $siswas = Penempatan::with(['siswa', 'industri'])
        //     ->whereHas('penempatan.industri')
        //     ->get();
        $penilaian = Penilaian::with(['siswa', 'industri', 'pembimbing'])
            ->get();
        return view('admin.penilaian.index', compact('penilaian'));
    }

    // Form input nilai teknis untuk semua siswa
    public function createTeknis()
    {
        $siswas = Siswa::with(['industri', 'penilaian'])
            ->whereHas('industri')
            ->get();

        return view('admin.penilaian.create-teknis', compact('siswas'));
    }

    // Simpan semua nilai teknis
    public function storeTeknis(Request $request)
    {
        $validated = $request->validate([
            'nilai.*.siswa_id' => 'required|exists:siswas,id',
            'nilai.*.nilai_teknis' => 'required|numeric|min:0|max:100'
        ]);

        foreach ($validated['nilai'] as $data) {
            Penilaian::updateOrCreate(
                [
                    'siswa_id' => $data['siswa_id'],
                    'industri_id' => Siswa::find($data['siswa_id'])->industri_id,
                    'pembimbing_id' => auth()->user()->pembimbing->id
                ],
                ['nilai_teknis' => $data['nilai_teknis']]
            );
        }

        return redirect()->route('admin.penilaian.index')
            ->with('success', 'Nilai teknis berhasil disimpan');
    }

    // Form input nilai non-teknis untuk semua siswa
    public function createNonTeknis()
    {
        $siswas = Siswa::with(['industri', 'penilaian'])
            ->whereHas('industri')
            ->get();

        return view('admin.penilaian.create-non-teknis', compact('siswas'));
    }

    // Simpan semua nilai non-teknis
    public function storeNonTeknis(Request $request)
    {
        $validated = $request->validate([
            'nilai.*.siswa_id' => 'required|exists:siswas,id',
            'nilai.*.disiplin' => 'required|numeric|min:0|max:100',
            'nilai.*.kerjasama' => 'required|numeric|min:0|max:100',
            'nilai.*.inisiatif' => 'required|numeric|min:0|max:100',
            'nilai.*.tanggung_jawab' => 'required|numeric|min:0|max:100',
            'nilai.*.kebersihan' => 'required|numeric|min:0|max:100',
            'nilai.*.catatan' => 'nullable|string'
        ]);

        foreach ($validated['nilai'] as $data) {
            Penilaian::updateOrCreate(
                [
                    'siswa_id' => $data['siswa_id'],
                    'industri_id' => Siswa::find($data['siswa_id'])->industri_id,
                    'pembimbing_id' => auth()->user()->pembimbing->id
                ],
                [
                    'disiplin' => $data['disiplin'],
                    'kerjasama' => $data['kerjasama'],
                    'inisiatif' => $data['inisiatif'],
                    'tanggung_jawab' => $data['tanggung_jawab'],
                    'kebersihan' => $data['kebersihan'],
                    'catatan' => $data['catatan'] ?? null
                ]
            );
        }

        return redirect()->route('admin.penilaian.index')
            ->with('success', 'Nilai non-teknis berhasil disimpan');
    }

    // Detail nilai per siswa
    public function show(Siswa $siswa)
    {
        $penilaian = Penilaian::where('siswa_id', $siswa->id)
            ->with(['siswa', 'industri', 'pembimbing'])
            ->first();

        return view('admin.penilaian.show', compact('siswa', 'penilaian'));
    }
}
