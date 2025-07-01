<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('user')->get();
        return view('admin.siswas.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswas.create');
    }

    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validatedUser['role'] = 'siswa';
        $validatedUser['password'] = Hash::make($validatedUser['password']);
        $user = User::create($validatedUser);

        $validatedSiswa = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|string|unique:siswas',
            'nisn' => 'required|string|unique:siswas',
            'kelas' => 'required|string|max:100',
            'jurusan' => 'required|in:tb,mm,aphp',
            'alamat' => 'required|string',
            'status_pkl' => 'required|in:belum_mulai,sedang_berjalan,selesai',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'tahun_angkatan' => 'required|integer',
        ]);
        $validatedSiswa['user_id'] = $user->id;
        Siswa::create($validatedSiswa);
        return Redirect::route('admin.siswas.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('user');
        return view('admin.siswas.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        return view('admin.siswas.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $siswa->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($validatedUser['password']) {
            $validatedUser['password'] = Hash::make($validatedUser['password']);
        } else {
            unset($validatedUser['password']);
        }
        $siswa->user->update($validatedUser);

        $validatedSiswa = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|string|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'kelas' => 'required|string|max:100',
            'jurusan' => 'required|in:tb,mm,aphp',
            'alamat' => 'required|string',
            'status_pkl' => 'required|in:belum_mulai,sedang_berjalan,selesai',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'tahun_angkatan' => 'required|integer',
        ]);
        $siswa->update($validatedSiswa);
        return Redirect::route('admin.siswas.index')->with('success', 'Siswa berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete(); // otomatis hapus siswa karena relasi cascade
        return Redirect::route('admin.siswas.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
