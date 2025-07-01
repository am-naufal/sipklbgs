@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Pembimbing</h1>
        <form action="{{ route('admin.pembimbings.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block">Nama Akun</label>
                    <input type="text" name="name" id="name" class="border rounded w-full p-2"
                        value="{{ old('name') }}">
                    @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block">Email Akun</label>
                    <input type="email" name="email" id="email" class="border rounded w-full p-2"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block">Password</label>
                    <input type="password" name="password" id="password" class="border rounded w-full p-2">
                    @error('password')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="border rounded w-full p-2">
                </div>
                <div>
                    <label for="nama_lengkap" class="block">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="border rounded w-full p-2"
                        value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="niy" class="block">NIY</label>
                    <input type="text" name="niy" id="niy" class="border rounded w-full p-2"
                        value="{{ old('niy') }}">
                    @error('niy')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email_pembimbing" class="block">Email Pembimbing</label>
                    <input type="email" name="email" id="email_pembimbing" class="border rounded w-full p-2"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="no_hp" class="block">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="border rounded w-full p-2"
                        value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jabatan" class="block">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="border rounded w-full p-2"
                        value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="alamat" class="block">Alamat</label>
                    <textarea name="alamat" id="alamat" class="border rounded w-full p-2">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.pembimbings.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
@endsection
