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

        $siswas = Penempatan::with(['industri', 'siswa', 'pembimbing'])
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
                    'industri_id' => Penempatan::find($data['siswa_id'])->industri_id,
                    'pembimbing_id' => Penempatan::find($data['siswa_id'])->pembimbing_id
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

        $siswas = Penempatan::with(['industri', 'siswa', 'pembimbing'])
            ->whereHas('industri')
            ->get();


        return view('admin.penilaian.create-nonteknis', compact('siswas'));
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
                    'industri_id' => Penempatan::find($data['siswa_id'])->industri_id,
                    'pembimbing_id' => Penempatan::find($data['siswa_id'])->pembimbing_id,
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

    // Form edit nilai siswa
    public function edit(Penilaian $penilaian)
    {
        $penilaian->load('siswa', 'industri', 'pembimbing');
        if (!$penilaian) {
            return redirect()->route('admin.penilaian.index')
                ->with('error', 'Penilaian untuk siswa ini belum ada');
        }
        return view('admin.penilaian.edit', compact('penilaian'));
    }

    // Update nilai siswa
    public function update(Request $request, Penilaian $penilaian)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
            'industri_id' => 'required|exists:industris,id',
            'nilai_teknis' => 'required|numeric|min:0|max:100',
            'disiplin' => 'required|numeric|min:0|max:100',
            'kerjasama' => 'required|numeric|min:0|max:100',
            'inisiatif' => 'required|numeric|min:0|max:100',
            'tanggung_jawab' => 'required|numeric|min:0|max:100',
            'kebersihan' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);


        $penilaian->update($validated);
        return redirect()->route('admin.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }
    // Detail nilai per siswa
    public function show(Penilaian $penilaian)
    {



        $penilaian->load('siswa', 'industri', 'pembimbing');
        if (!$penilaian) {
            return redirect()->route('admin.penilaian.index')
                ->with('error', 'Penilaian untuk siswa ini belum ada');
        }
        return view('admin.penilaian.show', compact('penilaian'));
    }
}
