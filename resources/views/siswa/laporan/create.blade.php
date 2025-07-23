@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Laporan Baru</h1>
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" value="{{ $siswa->nama }}" readonly>
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Instansi</label>
                <input type="text" class="form-control" value="{{ $penempatan->industri->nama }}" readonly>
                <input type="hidden" name="penempatan_id" value="{{ $penempatan->id }}">
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File Laporan</label>
                <input type="file" class="form-control" id="file" name="file" required>
                @error('file')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="status" value="menunggu">

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
