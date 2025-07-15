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
            <p class="mb-0">Ini adalah halaman utama PKL kamu. Pantau aktivitas, laporan, dan dokumen dengan mudah.</p>
        </div>

        <div class="row mt-4 g-4">
            <!-- Status PKL -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-briefcase-fill dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Status PKL</h6>
                            <p class="mb-1 text-muted small">Aktif di {{ $penempatan->industri->nama }}</p>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Harian -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan Harian</h6>
                            <p class="mb-1 text-muted small">Isi log kegiatan harian kamu</p>
                            <a href="/" class="btn btn-sm btn-outline-primary">Isi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembimbing -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-lines-fill dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Pembimbing</h6>
                            <p class="mb-1 text-muted small"> {{ $penempatan->pembimbing->nama_lengkap }} (Sekolah)
                                <br>{{ $penempatan->industri->nama_pj }} (Industri)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-folder2-open dashboard-icon me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Dokumen</h6>
                            <p class="mb-1 text-muted small">Surat tugas & log book</p>
                            <a href="/" class="btn btn-sm btn-outline-secondary">Lihat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
