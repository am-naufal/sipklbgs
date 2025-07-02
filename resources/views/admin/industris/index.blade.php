@extends('layouts.adminlte')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Industri</h1>
        <a href="{{ route('admin.industris.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah
            Industri</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Nama Industri</th>
                    <th class="border px-4 py-2">Alamat</th>
                    <th class="border px-4 py-2">Telepon</th>
                    <th class="border px-4 py-2">Nama Penanggung Jawab</th>
                    <th class="border px-4 py-2">Jabatan PJ</th>
                    <th class="border px-4 py-2">Telepon PJ</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($industris as $industri)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $industri->nama }}</td>
                        <td class="border px-4 py-2">{{ $industri->alamat }}</td>
                        <td class="border px-4 py-2">{{ $industri->telepon }}</td>
                        <td class="border px-4 py-2">{{ $industri->nama_pj }}</td>
                        <td class="border px-4 py-2">{{ $industri->jabatan_pj }}</td>
                        <td class="border px-4 py-2">{{ $industri->telepon_pj }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.industris.show', $industri) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route('admin.industris.edit', $industri) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route('admin.industris.destroy', $industri) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus industri?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
