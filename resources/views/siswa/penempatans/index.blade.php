@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h4 mb-0 fw-bold">
                                <i class="bi bi-person-badge me-2"></i>Detail Penempatan Siswa
                            </h1>
                        </div>
                    </div>
                </div>
                <!-- Main Content -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <!-- Student Data Section -->
                        <div class="mb-5">
                            <h2 class="h5 fw-bold mb-4 text-primary">
                                <i class="bi bi-person-circle me-2"></i>Data Siswa
                            </h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">NISN</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">{{ $penempatans->siswa->nisn }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Industry Data Section -->
                        <div class="mb-5">
                            <h2 class="h5 fw-bold mb-4 text-primary">
                                <i class="bi bi-building me-2"></i>Data Industri
                            </h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Nama Industri</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">{{ $penempatans->industri->nama }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Alamat</label>
                                    <div class="p-3 bg-light rounded-3">{{ $penempatans->industri->alamat }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Mentor Data Section -->
                        <div class="mb-5">
                            <h2 class="h5 fw-bold mb-4 text-primary">
                                <i class="bi bi-person-workspace me-2"></i>Data Pembimbing
                            </h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Nama Pembimbing</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">
                                        {{ $penempatans->pembimbing->nama_lengkap }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Nomor HP</label>
                                    <div class="p-3 bg-light rounded-3">
                                        <i class="bi bi-telephone me-2"></i>
                                        {{ $penempatans->pembimbing->no_hp }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @dd($penempatans) --}}

                        <!-- Placement Details -->
                        <div class="mb-5">
                            <h2 class="h5 fw-bold mb-4 text-primary">
                                <i class="bi bi-calendar-event me-2"></i>Detail Penempatan
                            </h2>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted small mb-1">Tanggal Mulai</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        {{ $penempatans->tanggal_penempatan }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted small mb-1">Tanggal Selesai</label>
                                    <div class="p-3 bg-light rounded-3 fw-semibold">
                                        <i class="bi bi-calendar-x me-2"></i>
                                        {{ $penempatans->tanggal_selesai }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div>
                            <h2 class="h5 fw-bold mb-4 text-primary">
                                <i class="bi bi-info-circle me-2"></i>Status
                            </h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Status Penempatan</label>
                                    @if ($penempatans->status == 'menunggu')
                                        <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 fw-semibold">
                                            <i class="bi bi-check-circle me-2"></i>Menunggu
                                        </div>
                                    @elseif ($penempatans->status == 'disetujui')
                                        <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 fw-semibold">
                                            <i class="bi bi-hourglass-split me-2"></i>Berjalan
                                        </div>
                                    @else
                                        <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3 fw-semibold">
                                            <i class="bi bi-x-circle me-2"></i>Ditolak
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Keterangan</label>
                                    <div class="p-3 bg-light rounded-3">Magang</div>
                                </div>
                            </div>
                        </div>
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

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
