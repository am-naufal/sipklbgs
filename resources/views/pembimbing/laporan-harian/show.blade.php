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
                                    <i class="fas fa-file-alt me-2"></i>Detail Laporan Harian
                                </h2>
                                <p class="mb-0 small opacity-75">
                                    {{ optional($laporan->created_at)->format('d F Y') ?? 'Tanggal tidak tersedia' }}
                                </p>
                            </div>
                            <div class="badge bg-white text-primary rounded-pill px-3">
                                @if ($laporan->status_validasi == 'diterima')
                                    <i class="fas fa-check-circle me-1"></i> Valid
                                @elseif($laporan->status_validasi == 'ditolak')
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                @else
                                    <i class="fas fa-clock me-1"></i> Menunggu
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Info Penempatan -->
                        <div class="alert alert-light border mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-building text-primary me-3 fa-lg"></i>
                                        <div>
                                            <strong>Industri</strong>
                                            <p class="mb-0">{{ optional($laporan->penempatan)->industri->nama ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tie text-primary me-3 fa-lg"></i>
                                        <div>
                                            <strong>Pembimbing</strong>
                                            <p class="mb-0">
                                                {{ optional($laporan->penempatan)->pembimbing->nama_lengkap ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kegiatan -->
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3 text-primary">
                                <i class="fas fa-tasks me-1"></i> Kegiatan Hari Ini
                            </h5>
                            <div class="bg-light p-3 rounded-2">
                                {!! nl2br(e($laporan->kegiatan ?? 'Tidak ada kegiatan')) !!}
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if ($laporan->catatan)
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3 text-primary">
                                    <i class="fas fa-edit me-1"></i> Catatan/Refleksi
                                </h5>
                                <div class="bg-light p-3 rounded-2">
                                    {!! nl2br(e($laporan->catatan)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Keterangan Validasi -->
                        @if ($laporan->keterangan_validasi)
                            <div class="alert alert-{{ $laporan->status_validasi == 'valid' ? 'success' : 'danger' }}">
                                <h5 class="fw-semibold mb-2">
                                    <i class="fas fa-info-circle me-1"></i> Keterangan Validasi
                                </h5>
                                <p class="mb-0">{{ $laporan->keterangan_validasi }}</p>
                            </div>
                        @endif

                        <!-- Tombol Kembali -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('pembimbing.laporan-harian.index') }}"
                                class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
