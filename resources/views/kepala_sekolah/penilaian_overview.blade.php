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
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header shadow-sm text-center">
            <h2 class="fw-bold mb-2">Overview Penilaian PKL</h2>
            <p class="mb-0">Statistik dan analisis penilaian siswa selama program PKL</p>
        </div>

        <!-- Statistik Utama -->
        <div class="row mt-4 g-4">
            <!-- Rata-rata Nilai -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-chart-line stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ number_format($nilaiRataRata, 2) }}</h3>
                    <p class="stat-label">Rata-rata Nilai Akhir</p>
                </div>
            </div>

            <!-- Nilai Tertinggi -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-trophy stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ number_format($nilaiTertinggi, 2) }}</h3>
                    <p class="stat-label">Nilai Tertinggi</p>
                </div>
            </div>

            <!-- Nilai Terendah -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-chart-area stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ number_format($nilaiTerendah, 2) }}</h3>
                    <p class="stat-label">Nilai Terendah</p>
                </div>
            </div>

            <!-- Total Penilaian -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card p-4 text-center">
                    <i class="fas fa-clipboard-list stat-icon mb-3"></i>
                    <h3 class="stat-number">{{ $totalPenilaian }}</h3>
                    <p class="stat-label">Total Penilaian</p>
                </div>
            </div>
        </div>

        <!-- Distribusi Nilai -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Distribusi Nilai</h5>
                    @foreach ($distribusiNilai as $range => $count)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">{{ $range }}</span>
                                <span class="text-muted">{{ $count }} siswa</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $percentage = $totalPenilaian > 0 ? ($count / $totalPenilaian) * 100 : 0;
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
                    <h5 class="card-title mb-4">Statistik per Kategori</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Rata-rata</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Teknis</td>
                                    <td class="fw-bold">{{ number_format($rataRataTeknis, 2) }}</td>
                                    <td>{{ $totalTeknis }}</td>
                                </tr>
                                <tr>
                                    <td>Non-Teknis</td>
                                    <td class="fw-bold">{{ number_format($rataRataNonTeknis, 2) }}</td>
                                    <td>{{ $totalNonTeknis }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="fw-bold text-primary">{{ number_format($nilaiRataRata, 2) }}</td>
                                    <td class="fw-bold">{{ $totalPenilaian }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card distribution-card p-4">
                    <h5 class="card-title mb-4">Siswa dengan Nilai Terbaik</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Industri</th>
                                    <th>Nilai Teknis</th>
                                    <th>Nilai Non-Teknis</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topPerformers as $penilaian)
                                    <tr>
                                        <td>{{ $penilaian->siswa->nama ?? 'N/A' }}</td>
                                        <td>{{ $penilaian->penempatan->industri->nama ?? 'N/A' }}</td>
                                        <td>{{ number_format($penilaian->nilai_teknis, 2) }}</td>
                                        <td>{{ number_format($penilaian->nilai_non_teknis, 2) }}</td>
                                        <td class="fw-bold text-primary">{{ number_format($penilaian->nilaiAkhir(), 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data penilaian</td>
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
