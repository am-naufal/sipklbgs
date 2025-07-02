@extends('layouts.adminlte')


@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Pembimbing</h1>
        <a href="{{ route('admin.pembimbings.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pembimbing</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIY</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">No HP</th>
                    <th class="border px-4 py-2">Jabatan</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembimbings as $pembimbing)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $pembimbing->nama_lengkap }}</td>
                        <td class="border px-4 py-2">{{ $pembimbing->niy }}</td>
                        <td class="border px-4 py-2">{{ $pembimbing->email }}</td>
                        <td class="border px-4 py-2">{{ $pembimbing->no_hp }}</td>
                        <td class="border px-4 py-2">{{ $pembimbing->jabatan }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.pembimbings.show', $pembimbing) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route('admin.pembimbings.edit', $pembimbing) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route('admin.pembimbings.destroy', $pembimbing) }}" method="POST"
                                class="inline" onsubmit="return confirm('Yakin hapus pembimbing?')">
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
