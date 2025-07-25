@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Laporan Baru</h1>

        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="siswa_id" class="form-label">Siswa</label>
                <select class="form-select" id="siswa_id" name="siswa_id" required>
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="penempatan_id" class="form-label">Penempatan</label>
                <select class="form-select" id="penempatan_id" name="penempatan_id" required>
                    <option value="">Pilih Penempatan</option>
                    @foreach ($penempatans as $penempatan)
                        <option value="{{ $penempatan->id }}"
                            {{ old('penempatan_id') == $penempatan->id ? 'selected' : '' }}>{{ $penempatan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File Laporan (PDF/DOC/DOCX, max 2MB)</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="valid" {{ old('status') == 'valid' ? 'selected' : '' }}>Diterima</option>
                    <option value="revisi" {{ old('status') == 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
