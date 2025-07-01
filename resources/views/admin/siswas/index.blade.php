@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Siswa</h1>
        <a href="{{ route('admin.siswas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah
            Siswa</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIS</th>
                    <th class="border px-4 py-2">NISN</th>
                    <th class="border px-4 py-2">Kelas</th>
                    <th class="border px-4 py-2">Jurusan</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $siswa)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $siswa->nama }}</td>
                        <td class="border px-4 py-2">{{ $siswa->nis }}</td>
                        <td class="border px-4 py-2">{{ $siswa->nisn }}</td>
                        <td class="border px-4 py-2">{{ $siswa->kelas }}</td>
                        <td class="border px-4 py-2">{{ strtoupper($siswa->jurusan) }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.siswas.show', $siswa) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route('admin.siswas.edit', $siswa) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route('admin.siswas.destroy', $siswa) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus siswa?')">
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
