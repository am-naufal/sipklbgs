@extends('layouts.adminlte')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Siswa</h1>
        <div class="mb-4">
            <strong>Nama Akun:</strong> {{ $siswa->user->name }}<br>
            <strong>Email Akun:</strong> {{ $siswa->user->email }}
        </div>
        <div class="mb-4">
            <strong>Nama Lengkap:</strong> {{ $siswa->nama }}<br>
            <strong>Tempat, Tanggal Lahir:</strong> {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}<br>
            <strong>NIS:</strong> {{ $siswa->nis }}<br>
            <strong>NISN:</strong> {{ $siswa->nisn }}<br>
            <strong>Kelas:</strong> {{ $siswa->kelas }}<br>
            <strong>Jurusan:</strong> {{ strtoupper($siswa->jurusan) }}<br>
            <strong>Alamat:</strong> {{ $siswa->alamat }}<br>
            <strong>Status PKL:</strong> {{ ucfirst(str_replace('_', ' ', $siswa->status_pkl)) }}<br>
            <strong>Tanggal Mulai PKL:</strong> {{ $siswa->tanggal_mulai ?? '-' }}<br>
            <strong>Tanggal Selesai PKL:</strong> {{ $siswa->tanggal_selesai ?? '-' }}<br>
            <strong>Tahun Angkatan:</strong> {{ $siswa->tahun_angkatan }}
        </div>
        <a href="{{ route('admin.siswas.edit', $siswa) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('admin.siswas.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </div>
@endsection
