@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Industri</h1>
        @if ($industris->isEmpty())
            <p>Tidak ada data industri.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Alamat</th>
                        <th class="py-2 px-4 border-b">Telepon</th>
                        <th class="py-2 px-4 border-b">Nama Penanggung Jawab</th>
                        <th class="py-2 px-4 border-b">Jabatan Penanggung Jawab</th>
                        <th class="py-2 px-4 border-b">Telepon Penanggung Jawab</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($industris as $industri)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $industri->nama }}</td>
                            <td class="py-2 px-4 border-b">{{ $industri->alamat }}</td>
                            <td class="py-2 px-4 border-b">{{ $industri->telepon }}</td>
                            <td class="py-2 px-4 border-b">{{ $industri->nama_pj }}</td>
                            <td class="py-2 px-4 border-b">{{ $industri->jabatan_pj }}</td>
                            <td class="py-2 px-4 border-b">{{ $industri->telepon_pj }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
