@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #2c5282, #2b6cb0);
            color: white;
            padding: 30px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .stat-card {
            border: none;
            transition: all 0.2s ease-in-out;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 35px;
            color: #2c5282;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
            color: #2c5282;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .distribution-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-custom {
            background: linear-gradient(135deg, #2c5282, #2b6cb0);
        }

        .table-custom th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header shadow-sm text-center">
            <h2 class="fw-bold mb-2">Statistik Laporan PKL</h2>
            <p class="mb-0">Analisis dan monitoring laporan harian dan akhir siswa PKL</p>
        </div>

        <!-- Statistik Utama -->
        <div class="row mt-4 g-4">
            <!-- Total Laporan Harian -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-file-alt stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ $totalLaporanHarian }}</h3>
                    <p class="stat-label">Total Laporan Harian</p>
                </div>
            </div>

            <!-- Total Laporan Akhir -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-file-pdf stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ $totalLaporanAkhir }}</h3>
                    <p class="stat-label">Total Laporan Akhir</p>
                </div>
            </div>

            <!-- Rata-rata Laporan per Siswa -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-chart-bar stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ number_format($rasioLaporanPerSiswa, 1) }}</h3>
                    <p class="stat-label">Rata-rata Laporan/Siswa</p>
                </div>
            </div>

            <!-- Persentase Kelengkapan -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-check-circle stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ number_format($persentaseKelengkapan, 1) }}%</h3>
                    <p class="stat-label">Kelengkapan Laporan</p>
                </div>
            </div>
        </div>

        <!-- Distribusi Laporan -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Status Laporan Harian</h5>
                    @foreach ($statusLaporanHarian as $status => $count)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">
                                    @if ($status === 'diterima')
                                        <i class="fas fa-check-circle text-success me-2"></i>Diterima
                                    @elseif($status === 'ditolak')
                                        <i class="fas fa-times-circle text-danger me-2"></i>Ditolak
                                    @else
                                        <i class="fas fa-clock text-warning me-2"></i>Menunggu
                                    @endif
                                </span>
                                <span class="text-muted">{{ $count }} laporan</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $percentage = $totalLaporanHarian > 0 ? ($count / $totalLaporanHarian) * 100 : 0;
                                @endphp
                                <div class="progress-bar progress-bar-custom" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Status Laporan Akhir</h5>
                    @foreach ($statusLaporanAkhir as $status => $count)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">
                                    @if ($status === 'diterima')
                                        <i class="fas fa-check-circle text-success me-2"></i>Diterima
                                    @elseif($status === 'ditolak')
                                        <i class="fas fa-times-circle text-danger me-2"></i>Ditolak
                                    @else
                                        <i class="fas fa-clock text-warning me-2"></i>Menunggu
                                    @endif
                                </span>
                                <span class="text-muted">{{ $count }} laporan</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $percentage = $totalLaporanAkhir > 0 ? ($count / $totalLaporanAkhir) * 100 : 0;
                                @endphp
                                <div class="progress-bar progress-bar-custom" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tren Bulanan -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Tren Laporan Bulanan</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Laporan Harian</th>
                                    <th>Laporan Akhir</th>
                                    <th>Total</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trenBulanan as $tren)
                                    <tr>
                                        <td class="fw-medium">{{ $tren['bulan'] }}</td>
                                        <td>{{ $tren['laporan_harian'] }}</td>
                                        <td>{{ $tren['laporan_akhir'] }}</td>
                                        <td class="fw-bold">{{ $tren['total'] }}</td>
                                        <td>
                                            @if ($tren['trend'] === 'naik')
                                                <i class="fas fa-arrow-up text-success"></i>
                                            @elseif($tren['trend'] === 'turun')
                                                <i class="fas fa-arrow-down text-danger"></i>
                                            @else
                                                <i class="fas fa-minus text-secondary"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data tren</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Contributors -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Siswa Paling Aktif (Laporan)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Industri</th>
                                    <th>Laporan Harian</th>
                                    <th>Laporan Akhir</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topContributors as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ $siswa->penempatan->industri->nama ?? 'Belum ditempatkan' }}</td>
                                        <td>{{ $siswa->laporan_harian_count }}</td>
                                        <td>{{ $siswa->laporan_akhir_count }}</td>
                                        <td class="fw-bold text-primary">
                                            {{ $siswa->laporan_harian_count + $siswa->laporan_akhir_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data laporan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('kepala_sekolah.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
