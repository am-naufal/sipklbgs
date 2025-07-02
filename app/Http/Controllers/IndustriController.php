<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IndustriController extends Controller
{
    public function index()
    {
        $industris = Industri::all();
        return view('admin.industris.index', compact('industris'));
    }

    public function create()
    {
        return view('admin.industris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'nama_pj' => 'required',
            'jabatan_pj' => 'required',
            'telepon_pj' => 'required',
        ]);
        $makeid = 'ind' . (Industri::latest()->first()->id ?? 0) + 1;
        $User = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'industri',
            'industri_id' => $makeid,
        ]);
        dd($User);
        $Industri = Industri::create($validated);
        $Industri->user_id = $User->id;
        $Industri->save();

        return redirect()->route('admin.industris.index')->with('success', 'Data industri berhasil ditambahkan');
    }

    public function edit(Industri $industri)
    {
        return view('admin.industris.edit', compact('industri'));
    }

    public function update(Request $request, Industri $industri)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'nama_pj' => 'required',
            'jabatan_pj' => 'required',
            'telepon_pj' => 'required',

        ]);

        $industri->update($validated);
        return redirect()->route('admin.industris.index')->with('success', 'Data industri berhasil diperbarui');
    }

    public function show(Industri $industri)
    {
        return view('admin.industris.show', compact('industri'));
    }

    public function destroy(Industri $industri)
    {
        $industri->delete();
        return redirect()->route('admin.industris.index')->with('success', 'Data industri berhasil dihapus');
    }
}
