@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 mb-0 fw-bold">
                            <i class="fas fa-file-alt me-2"></i>Detail Laporan
                        </h2>
                        <p class="mb-0 small opacity-75">ID: LAP-{{ $laporan->id }}</p>
                    </div>
                    <span class="badge bg-white text-primary fs-6 rounded-pill px-3 py-2">
                        <i
                            class="fas fa-circle me-1 small {{ $laporan->status_validasi == 'valid' ? 'text-success' : ($laporan->status_validasi == 'revisi' ? 'text-warning' : 'text-secondary') }}"></i>
                        {{ ucfirst($laporan->status_validasi) }}
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <!-- Informasi Siswa -->
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h5 class="fw-semibold text-primary mb-3">
                                <i class="fas fa-user-graduate me-2"></i>Informasi Siswa
                            </h5>
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-user fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $laporan->siswa->nama }}</h6>
                                    <small class="text-muted">NIS: {{ $laporan->siswa->nis }}</small>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-school me-2 text-muted"></i>
                                    Kelas: {{ $laporan->siswa->kelas }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-book me-2 text-muted"></i>
                                    Jurusan: {{ $laporan->siswa->jurusan }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Informasi Penempatan -->
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h5 class="fw-semibold text-primary mb-3">
                                <i class="fas fa-building me-2"></i>Informasi Penempatan
                            </h5>
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="avatar-lg bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-industry fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $laporan->penempatan->industri->nama }}</h6>
                                    <small class="text-muted">Industri</small>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                    Lokasi: {{ $laporan->penempatan->industri->alamat }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-user-tie me-2 text-muted"></i>
                                    Pembimbing Industri: {{ $laporan->penempatan->industri->nama_pj ?? '-' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-user-tie me-2 text-muted"></i>
                                    Pembimbing Sekolah: {{ $laporan->penempatan->pembimbing->nama_lengkap ?? '-' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Catatan Laporan -->
                <div class="mb-4">
                    <div class="bg-light p-3 rounded-3">
                        <h5 class="fw-semibold text-primary mb-3">
                            <i class="fas fa-clipboard me-2"></i>Catatan Laporan
                        </h5>
                        <div class="p-3 bg-white rounded-2 border">
                            {!! $laporan->keterangan_validasi
                                ? nl2br(e($laporan->keterangan_validasi))
                                : '<span class="text-muted">Tidak ada catatan</span>' !!}
                        </div>
                    </div>
                </div>

                <!-- Catatan Revisi -->
                @if ($laporan->status == 'revisi' && $laporan->keterangan_validasi)
                    <div class="mb-4">
                        <div class="bg-light p-3 rounded-3">
                            <h5 class="fw-semibold text-danger mb-3">
                                <i class="fas fa-exclamation-circle me-2"></i>Catatan Revisi
                            </h5>
                            <div class="p-3 bg-white rounded-2 border border-danger border-opacity-25">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-comment-dots text-danger mt-1 me-2"></i>
                                    <div>
                                        {!! nl2br(e($laporan->keterangan_validasi)) !!}
                                        <div class="text-muted small mt-2">
                                            <i class="fas fa-clock me-1"></i>
                                            Direvisi pada: {{ $laporan->updated_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- File Laporan -->
                <div class="mb-4">
                    <div class="bg-light p-3 rounded-3">
                        <h5 class="fw-semibold text-primary mb-3">
                            <i class="fas fa-file-pdf me-2"></i>File Laporan
                        </h5>
                        <div class="d-flex align-items-center">
                            <div
                                class="avatar-lg bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-file-pdf fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Laporan_{{ $laporan->siswa->nama }}.pdf</h6>
                                <small class="text-muted">Ukuran: {{ round($laporan->file_size / 1024, 1) }} KB</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.laporans.download', $laporan->id) }}"
                                class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-download me-2"></i>Download File
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4"
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

@push('styles')
    <style>
        .avatar-lg {
            width: 48px;
            height: 48px;
        }

        .avatar-lg i {
            font-size: 1.25rem;
        }

        .card {
            border: none;
        }

        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .border-primary {
            border-color: rgba(13, 110, 253, 0.25) !important;
        }

        .rounded-3 {
            border-radius: 1rem !important;
        }

        .fw-semibold {
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inisialisasi tooltip
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

        });
    </script>
@endpush
