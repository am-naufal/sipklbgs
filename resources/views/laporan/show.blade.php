@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Detail Laporan</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Judul:</h5>
                        <p>{{ $laporan->judul }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status:</h5>
                        <span class="badge bg-{{ $laporan->status_label[1] }}">
                            {{ $laporan->status_label[0] }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Siswa:</h5>
                        <p>{{ $laporan->siswa->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Penempatan:</h5>
                        <p>{{ $laporan->penempatan->nama }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <h5>Catatan:</h5>
                    <p>{{ $laporan->catatan ?? '-' }}</p>
                </div>

                @if ($laporan->status == 'revisi' && $laporan->catatan_revisi)
                    <div class="mb-3">
                        <h5>Catatan Revisi:</h5>
                        <p class="text-danger">{{ $laporan->catatan_revisi }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <h5>File Laporan:</h5>
                    <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download File
                    </a>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
                    <div>
                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
