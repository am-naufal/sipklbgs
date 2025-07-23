@extends('layouts.app')
@section('title', 'Detail Laporan Siswa')
@section('styes')
    <style>
        .file-section {
            border-left: 4px solid var(--bs-primary);
            transition: all 0.3s ease;
        }

        .file-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .card-header {
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-file-alt me-2"></i>Detail Laporan
                    </h2>
                    <div>
                        <span
                            class="badge rounded-pill bg-{{ $laporan->status == 'valid' ? 'success' : ($laporan->status == 'revisi' ? 'danger' : 'warning') }} fs-6">
                            <i
                                class="fas fa-{{ $laporan->status == 'valid' ? 'check-circle' : ($laporan->status == 'revisi' ? 'exclamation-circle' : 'clock') }} me-1"></i>
                            {{ $laporan->status_validasi }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Information Section -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="fas fa-user-graduate text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Siswa</h6>
                                <p class="mb-0 fs-5">{{ $laporan->siswa->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="fas fa-building text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Penempatan</h6>
                                <p class="mb-0 fs-5">{{ $laporan->penempatan->industri->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Dibuat Pada</h6>
                                <p class="mb-0 fs-5">{{ $laporan->created_at->translatedFormat('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="fas fa-sync-alt text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Diserahkan pada</h6>
                                <p class="mb-0 fs-5">{{ $laporan->updated_at->translatedFormat('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revision Notes (Conditional) -->
                @if ($laporan->status == 'revisi' && $laporan->catatan_revisi)
                    <div class="alert alert-warning border-0 bg-light-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-warning me-3 fa-2x"></i>
                            <div>
                                <h5 class="alert-heading mb-2">Catatan Revisi</h5>
                                <p class="mb-0">{{ $laporan->catatan_revisi }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- File Download Section -->
                <div class="file-section bg-light p-4 rounded mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf text-danger fa-3x me-3"></i>
                            <div>
                                <h5 class="mb-1">File Laporan</h5>
                                <p class="text-muted mb-0">Format: PDF</p>
                                <p class="mb-1">File saat ini: <strong>{{ basename($laporan->file_path) }}</strong>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-primary px-4">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>

                    <div class="d-flex gap-2">
                        @if ($laporan->status != 'valid')
                            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        @endif

                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                <i class="fas fa-trash-alt me-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
