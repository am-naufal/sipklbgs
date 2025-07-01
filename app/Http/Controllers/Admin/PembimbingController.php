<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PembimbingController extends Controller
{
    public function index()
    {
        $pembimbings = Pembimbing::with('user')->get();
        return view('admin.pembimbings.index', compact('pembimbings'));
    }

    public function create()
    {
        return view('admin.pembimbings.create');
    }

    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validatedUser['role'] = 'pembimbing';
        $validatedUser['password'] = Hash::make($validatedUser['password']);
        $user = User::create($validatedUser);

        $validatedPembimbing = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'niy' => 'required|string|unique:pembimbings',
            'email' => 'required|string|email|max:255|unique:pembimbings',
            'no_hp' => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string',
        ]);
        $validatedPembimbing['user_id'] = $user->id;
        Pembimbing::create($validatedPembimbing);
        return Redirect::route('admin.pembimbings.index')->with('success', 'Pembimbing berhasil ditambahkan.');
    }

    public function show(Pembimbing $pembimbing)
    {
        $pembimbing->load('user');
        return view('admin.pembimbings.show', compact('pembimbing'));
    }

    public function edit(Pembimbing $pembimbing)
    {
        $pembimbing->load('user');
        return view('admin.pembimbings.edit', compact('pembimbing'));
    }

    public function update(Request $request, Pembimbing $pembimbing)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $pembimbing->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($validatedUser['password']) {
            $validatedUser['password'] = Hash::make($validatedUser['password']);
        } else {
            unset($validatedUser['password']);
        }
        $pembimbing->user->update($validatedUser);

        $validatedPembimbing = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'niy' => 'required|string|unique:pembimbings,niy,' . $pembimbing->id,
            'email' => 'required|string|email|max:255|unique:pembimbings,email,' . $pembimbing->id,
            'no_hp' => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string',
        ]);
        $pembimbing->update($validatedPembimbing);
        return Redirect::route('admin.pembimbings.index')->with('success', 'Pembimbing berhasil diupdate.');
    }

    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->user->delete(); // otomatis hapus pembimbing karena relasi cascade
        return Redirect::route('admin.pembimbings.index')->with('success', 'Pembimbing berhasil dihapus.');
    }
}
