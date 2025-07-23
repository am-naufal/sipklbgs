@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 40px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .dashboard-card {
            border: none;
            transition: all 0.2s ease-in-out;
            border-radius: 1rem;
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }
        .dashboard-icon {
            font-size: 40px;
            color: #2563eb;
        }
        .dashboard-section {
            padding-bottom: 80px;
        }
    </style>
@endpush

@section('content')
    <div class="container dashboard-section">
        <div class="dashboard-header shadow-sm text-center">
            <h2 class="fw-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h2>
            <p class="mb-0">Ini adalah halaman utama pembimbing. Pantau aktivitas siswa bimbingan, verifikasi laporan, dan catat bimbingan.</p>
        </div>
        <div class="row mt-4 g-4">
            <!-- Total Siswa Bimbingan -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people-fill dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Siswa Bimbingan</h6>
                            <p class="mb-1 text-muted small">Total siswa: {{ $totalSiswa ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Laporan Harian Belum Diverifikasi -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-journal-check dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan Harian</h6>
                            <p class="mb-1 text-muted small">Belum diverifikasi: {{ $laporanHarianPending ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Laporan Akhir Siswa -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan Akhir</h6>
                            <p class="mb-1 text-muted small">Menunggu pengecekan: {{ $laporanAkhirPending ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Catatan Bimbingan -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clipboard-data dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Catatan Bimbingan</h6>
                            <p class="mb-1 text-muted small">Total catatan: {{ $totalCatatan ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tambahkan statistik atau tabel lain sesuai kebutuhan -->
    </div>
@endsection
