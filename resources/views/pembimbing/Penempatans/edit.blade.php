@extends('layouts.app')
@section('title', 'Edit Penempatan')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Penempatan</h1>
        <form action="{{ route('pembimbing.penempatans.update', $penempatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Siswa --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Siswa</label>
                <input type="text" name="siswa_id" id="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ $penempatan->siswa->nama ?? '' }}" disabled>
                @error('siswa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Industri --}}
            <div class="mb-3">
                <label for="industri_id" class="form-label">Industri</label>
                <select name="industri_id" id="industri_id" class="form-control @error('industri_id') is-invalid @enderror"
                    required>
                    <option value="">-- Pilih Industri --</option>
                    @foreach (\App\Models\Industri::all() as $industri)
                        <option value="{{ $industri->id }}"
                            {{ old('industri_id', $penempatan->industri_id) == $industri->id ? 'selected' : '' }}>
                            {{ $industri->nama }}
                        </option>
                    @endforeach
                </select>
                @error('industri_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pembimbing --}}
            <div class="mb-3">
                <label for="pembimbing_id" class="form-label">Pembimbing</label>
                <select name="pembimbing_id" id="pembimbing_id"
                    class="form-control @error('pembimbing_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach (\App\Models\Pembimbing::all() as $pembimbing)
                        <option value="{{ $pembimbing->id }}"
                            {{ old('pembimbing_id', $penempatan->pembimbing_id) == $pembimbing->id ? 'selected' : '' }}>
                            {{ $pembimbing->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('pembimbing_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="menunggu" {{ old('status', $penempatan->status) == 'menunggu' ? 'selected' : '' }}>
                        Menunggu</option>
                    <option value="disetujui" {{ old('status', $penempatan->status) == 'disetujui' ? 'selected' : '' }}>
                        Disetujui</option>
                    <option value="ditolak" {{ old('status', $penempatan->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Penempatan --}}
            <div class="mb-3">
                <label for="tanggal_penempatan" class="form-label">Tanggal Penempatan</label>
                <input type="date" name="tanggal_penempatan" id="tanggal_penempatan"
                    class="form-control @error('tanggal_penempatan') is-invalid @enderror"
                    value="{{ old('tanggal_penempatan', $penempatan->tanggal_penempatan ? \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->format('Y-m-d') : '') }}"
                    required>
                @error('tanggal_penempatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                    value="{{ old('tanggal_selesai', $penempatan->tanggal_selesai ? \Carbon\Carbon::parse($penempatan->tanggal_selesai)->format('Y-m-d') : '') }}">
                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $penempatan->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol --}}
            <button class="btn btn-primary" type="submit">Simpan</button>
            <a href="{{ route('pembimbing.penempatans.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
