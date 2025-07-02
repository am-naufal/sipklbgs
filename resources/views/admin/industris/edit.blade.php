@extends('layouts.app')


@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Industri</h1>
        <form action="{{ route('admin.industris.update', $industri) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">Nama Industri</label>
                <input type="text" name="nama" class="border rounded w-full p-2"
                    value="{{ old('nama', $industri->nama) }}">
                @error('nama')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block">Alamat</label>
                <input type="text" name="alamat" class="border rounded w-full p-2"
                    value="{{ old('alamat', $industri->alamat) }}">
                @error('alamat')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block">Telepon</label>
                <input type="text" name="telepon" class="border rounded w-full p-2"
                    value="{{ old('telepon', $industri->telepon) }}">
                @error('telepon')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block">Nama Penanggung Jawab</label>
                <input type="text" name="nama_pj" class="border rounded w-full p-2"
                    value="{{ old('nama_pj', $industri->nama_pj) }}">
                @error('nama_pj')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block">Jabatan PJ</label>
                <input type="text" name="jabatan_pj" class="border rounded w-full p-2"
                    value="{{ old('jabatan_pj', $industri->jabatan_pj) }}">
                @error('jabatan_pj')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block">Telepon PJ</label>
                <input type="text" name="telepon_pj" class="border rounded w-full p-2"
                    value="{{ old('telepon_pj', $industri->telepon_pj) }}">
                @error('telepon_pj')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('admin.industris.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
@endsection
