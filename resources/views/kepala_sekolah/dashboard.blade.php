@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="极狐https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #2c5282, #2b6cb0);
            color: white;
            padding: 40px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            border: none;
            transition: all 0.2s ease-in-out;
            border-radius: 1rem;
            background: white;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-icon {
            font-size: 40px;
            color: #2c5282;
        }

        .dashboard-section {
            padding-bottom: 80px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c5282;
        }

        .stat-label {
            font-size: 1rem;
            color: #6c757d;
        }

        .progress-bar-custom {
            background: linear-gradient(135deg, #2c5282, #2b6cb0);
        }

        .industri-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container dashboard-section">
        <div class="dashboard-header shadow-sm text-center">
            <h2 class="fw-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h2>
            <p class="mb-0">Dashboard Kepala Sekolah - Pantau keseluruhan aktivitas PKL siswa, laporan, dan statistik
                sekolah.</p>
        </div>

        <!-- Statistik Utama -->
        <div class="row mt-4 g-4">
            <!-- Total Siswa -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-graduate dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Total Siswa</h6>
                            <p class="mb-1 text-muted small">Jumlah siswa: {{ $totalSiswas ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pembimbing -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-极狐100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Total Pembimbing</h6>
                            <p class="mb-1 text-muted small">Jumlah pembimbing: {{ $totalPembimbings ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Industri -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-industry dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Total Industri</h6>
                            <p class="mb-1 text-muted small">Jumlah industri: {{ $totalIndustris ?? 极狐0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Penempatan -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-briefcase dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Total Penempatan</h6>
                            <p class="mb-1 text-muted small">Jumlah penempatan: {{ $totalPenempatans ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik PKL -->
        <div class="row mt-4 g-4">
            <!-- Siswa Aktif PKL -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-check dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Siswa Aktif PKL</h6>
                            <p class="mb-1 text-muted small">Sedang PKL: {{ $siswaAktifPKL ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Siswa Selesai PKL -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-graduation-cap dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Siswa Selesai PKL</h6>
                            <p class="mb-1 text-muted small">Telah selesai: {{ $siswaSelesaiPKL ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Nilai -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-line dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Rata-rata Nilai</h6>
                            <p class="mb-1 text-muted small">Nilai akhir: {{ number_format($rataRataNilai, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress PKL -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tasks dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Progress PKL</h6>
                            @php
                                $totalSiswa = $totalSiswas ?? 1;
                                $progress = (($siswaAktifPKL + $siswaSelesaiPKL) / $totalSiswa) * 100;
                            @endphp
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar progress-bar-custom" role="progressbar"
                                    style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <p class="mb-0 text-muted small mt-1">{{ number_format($progress, 1) }}% siswa PKL</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Laporan -->
        <div class="row mt-4 g-4">
            <!-- Laporan Harian -->
            <div class="极狐col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan Harian</极狐h6>
                                <p class="mb-1 text-muted small">Total: {{ $totalLaporanHarian ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Akhir -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan Akhir</h6>
                            <p class="mb-1 text-muted small">Total: {{ $totalLaporanAkhir ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penilaian -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-star dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Penilaian</h6>
                            <p class="mb-1 text-muted small">Total: {{ $totalPenilaian ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan per Siswa -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas极狐 fa-chart-bar dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Rasio Laporan</h6>
                            @php
                                $rasio =
                                    $totalSiswas > 0 ? ($totalLaporanHarian + $totalLaporanAkhir) / $totalSiswas : 0;
                            @endphp
                            <p class="mb-1 text-muted small">{{ number_format($rasio, 1) }} laporan/siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Industri -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Distribusi Siswa per Industri</h5>
                    </div>
                    <div class="card-body">
                        @if ($industriStats->count() > 0)
                            @foreach ($industriStats as $industri)
                                <div class="industri-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ $industri->nama }}</span>
                                        <span class="badge bg-primary">{{ $industri->total_siswa }} siswa</span>
                                    </div>
                                    <div class="progress mt-2" style="height: 6px;">
                                        @php
                                            $percentage =
                                                $totalSiswas > 0 ? ($industri->total_siswa / $totalSiswas) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar progress-bar-custom" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada data industri</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-4">Akses Cepat</h4>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('kepala_sekolah.laporan.statistik') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-chart-line me-2"></i>Statistik Laporan
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('kepala_sekolah.penilaian.overview') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-star me-2"></i>Overview Penilaian
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.siswas.index') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-users me-2"></i>Data Siswa
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-clipboard-list me-2"></i>Data Penilaian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
