@extends('layouts.adminlte')


@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Pembimbing</h1>
        <div class="mb-4">
            <strong>Nama Akun:</strong> {{ $pembimbing->user->name }}<br>
            <strong>Email Akun:</strong> {{ $pembimbing->user->email }}
        </div>
        <div class="mb-4">
            <strong>Nama Lengkap:</strong> {{ $pembimbing->nama_lengkap }}<br>
            <strong>NIY:</strong> {{ $pembimbing->niy }}<br>
            <strong>Email Pembimbing:</strong> {{ $pembimbing->email }}<br>
            <strong>No HP:</strong> {{ $pembimbing->no_hp }}<br>
            <strong>Jabatan:</strong> {{ $pembimbing->jabatan }}<br>
            <strong>Alamat:</strong> {{ $pembimbing->alamat }}
        </div>
        <a href="{{ route('admin.pembimbings.edit', $pembimbing) }}"
            class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('admin.pembimbings.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </div>
@endsection
