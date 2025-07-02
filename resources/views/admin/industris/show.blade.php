@extends('layouts.adminlte')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Industri</h1>
        <div class="mb-4">
            <strong>Nama Industri:</strong> {{ $industri->nama }}<br>
            <strong>Alamat:</strong> {{ $industri->alamat }}<br>
            <strong>Telepon:</strong> {{ $industri->telepon }}<br>
            <strong>Nama Penanggung Jawab:</strong> {{ $industri->nama_pj }}<br>
            <strong>Jabatan PJ:</strong> {{ $industri->jabatan_pj }}<br>
            <strong>Telepon PJ:</strong> {{ $industri->telepon_pj }}<br>
        </div>
        <a href="{{ route('admin.industris.edit', $industri) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('admin.industris.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </div>
@endsection
