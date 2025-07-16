@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="fas fa-edit me-2"></i>Edit Laporan Harian
                                </h2>
                                <p class="mb-0 small opacity-75">
                                    {{ optional($laporan->created_at)->format('d F Y') ?? 'Tanggal tidak tersedia' }}
                                </p>
                            </div>
                            <div class="badge bg-white text-primary rounded-pill px-3">
                                <i class="fas fa-clock me-1"></i> Menunggu Validasi
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('laporan-harian.update', $laporan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Info Penempatan -->
                            <div class="alert alert-light border mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building text-primary me-3 fa-lg"></i>
                                            <div>
                                                <strong>Industri</strong>
                                                <p class="mb-0">{{ optional($penempatan)->industri->nama ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie text-primary me-3 fa-lg"></i>
                                            <div>
                                                <strong>Pembimbing</strong>
                                                <p class="mb-0">{{ optional($penempatan)->pembimbing->nama ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kegiatan -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3 text-primary">
                                    <i class="fas fa-tasks me-1"></i> Kegiatan Hari Ini
                                </label>
                                <textarea name="kegiatan" class="form-control" rows="8" required>{{ old('kegiatan', $laporan->kegiatan) }}</textarea>
                                @error('kegiatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3 text-primary">
                                    <i class="fas fa-edit me-1"></i> Catatan/Refleksi (Opsional)
                                </label>
                                <textarea name="catatan" class="form-control" rows="5">{{ old('catatan', $laporan->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('laporan-harian.index') }}"
                                    class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-times me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
    </style>
@endpush
