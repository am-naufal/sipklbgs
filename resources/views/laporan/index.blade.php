@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Daftar Laporan</h1>
            <a href="{{ route('admin.laporans.create') }}" class="btn btn-primary">Tambah Laporan</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Penempatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporans as $index => $laporan)
                                <tr>
                                    <td>{{ $laporans->firstItem() + $index }}</td>
                                    <td>{{ $laporan->siswa->nama }}</td>
                                    <td>{{ $laporan->penempatan->industri->nama }}</td>
                                    <td>
                                        <span class="badge bg-{{ $laporan->status_label[1] }}">
                                            {{ $laporan->status_label[0] }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.laporans.show', $laporan->id) }}"
                                            class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('admin.laporans.edit', $laporan->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.laporans.destroy', $laporan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                        <a href="{{ route('admin.laporans.download', $laporan->id) }}"
                                            class="btn btn-sm btn-success">Download</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
@endsection
