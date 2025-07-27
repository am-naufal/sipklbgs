@extends('layouts.app')
@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 mb-0 fw-bold">
                            <i class="fas fa-user-graduate me-2"></i>Detail Siswa
                        </h2>
                        <p class="mb-0 small opacity-75">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }}</p>
                    </div>
                    <span class="badge bg-white text-primary fs-6 rounded-pill px-3 py-2">
                        <i class="fas fa-circle me-1 small text-success"></i>
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                @php
                    $jurusanMap = [
                        'tb' => 'Tata Boga',
                        'mm' => 'Multimedia',
                        'aphp' => 'Agribisnis Pengolahan Hasil Pertanian',
                    ];
                @endphp

                <div class="row g-4">
                    <!-- Informasi Akun -->
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-user-circle me-2"></i>Informasi Akun
                            </h5>
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-user fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $siswa->user->name }}</h6>
                                    <small class="text-muted">Akun Siswa</small>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    {{ $siswa->user->email }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                    Terdaftar sejak: {{ $siswa->user->created_at->format('d M Y') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card me-2"></i>Data Pribadi
                            </h5>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 bg-white rounded-2 mb-2">
                                        <small class="text-muted d-block">Nama Lengkap</small>
                                        <strong>{{ $siswa->nama }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-white rounded-2 mb-2">
                                        <small class="text-muted d-block">Tempat/Tgl Lahir</small>
                                        <strong>{{ $siswa->tempat_lahir }},
                                            {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-white rounded-2 mb-2">
                                        <small class="text-muted d-block">Kelas</small>
                                        <strong>{{ $siswa->kelas }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-white rounded-2 mb-2">
                                        <small class="text-muted d-block">Jurusan</small>
                                        <strong>{{ $jurusanMap[strtolower($siswa->jurusan)] ?? strtoupper($siswa->jurusan) }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-2 bg-white rounded-2">
                                        <small class="text-muted d-block">Alamat</small>
                                        <strong>{{ $siswa->alamat }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi PKL -->
                    <div class="col-12">
                        <div class="bg-light p-3 rounded-3">
                            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-briefcase me-2"></i>Prakerin (PKL)
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded-3 border-start border-4 border-primary">
                                        <small class="text-muted d-block">Status PKL</small>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            {{ ucfirst(str_replace('_', ' ', $penempatan->status)) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded-3 border-start border-4 border-info">
                                        <small class="text-muted d-block">Industri</small>
                                        <h5 class="mb-0 fw-bold">
                                            {{ $penempatan->industri->nama ?? 'Belum Ditempatkan' }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded-3 border-start border-4 border-warning">
                                        <small class="text-muted d-block">Durasi PKL</small>
                                        <h5 class="mb-0 fw-bold">
                                            @if ($penempatan->tanggal_penempatan && $penempatan->tanggal_selesai)
                                                {{ \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->diffInMonths($penempatan->tanggal_selesai) }}
                                                Bulan
                                            @else
                                                -
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-white rounded-3">
                                        <small class="text-muted d-block">Tanggal Mulai</small>
                                        <strong>
                                            {{ $penempatan->tanggal_penempatan ? \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->translatedFormat('d F Y') : '-' }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-white rounded-3">
                                        <small class="text-muted d-block">Tanggal Selesai</small>
                                        <strong>
                                            {{ $penempatan->tanggal_selesai ? \Carbon\Carbon::parse($penempatan->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer bg-light py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .avatar-lg {
            width: 60px;
            height: 60px;
        }

        .card {
            border: none;
        }

        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .border-4 {
            border-width: 4px !important;
        }

        .rounded-3 {
            border-radius: 1rem !important;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .hover-effect {
            transition: all 0.3s ease;
        }

        .hover-effect:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush

@push('scripts')
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
