@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="bi bi-journal-text me-2"></i>Daftar Laporan Harian
                                </h2>
                                <p class="mb-0 small opacity-75">Rekap seluruh laporan kegiatan harian</p>
                            </div>
                            @if (in_array(auth()->user()->role, ['admin', 'siswa']))
                                <a href="{{ route('laporan-harian.create') }}"
                                    class="btn btn-light text-primary rounded-pill px-4">
                                    <i class="bi bi-plus-lg me-2"></i>Tambah Laporan
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-0">
                        @if ($laporans->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-journal-x display-4 text-muted"></i>
                                </div>
                                <h3 class="h4 text-muted mb-3">Belum Ada Laporan</h3>
                                <p class="text-muted mb-4">Tidak ada laporan harian yang ditemukan.</p>
                                @if (in_array(auth()->user()->role, ['admin', 'siswa']))
                                    <a href="{{ route('laporan-harian.create') }}"
                                        class="btn btn-primary px-4 rounded-pill">
                                        <i class="bi bi-plus-lg me-2"></i>Buat Laporan Pertama
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4 py-3 text-uppercase fw-semibold">Siswa</th>
                                            <th class="py-3 text-uppercase fw-semibold">Industri</th>
                                            <th class="py-3 text-uppercase fw-semibold">Pembimbing</th>
                                            <th class="py-3 text-uppercase fw-semibold">Status</th>
                                            <th class="py-3 text-uppercase fw-semibold">Keterangan</th>
                                            <th class="py-3 text-uppercase fw-semibold">Tanggal</th>
                                            <th class="pe-4 py-3 text-uppercase fw-semibold text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporans as $laporan)
                                            <tr>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3">
                                                            <div class="avatar-title bg-light rounded-circle text-primary">
                                                                {{ substr($laporan->siswa->name ?? '?', 0, 1) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $laporan->siswa->name ?? '-' }}
                                                            </h6>
                                                            <small class="text-muted">NIS:
                                                                {{ $laporan->siswa->nisn ?? '-' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-building me-2 text-primary"></i>
                                                        <span>{{ $laporan->penempatan->industri->nama ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    @if ($laporan->penempatan->pembimbing ?? false)
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-3">
                                                                <div
                                                                    class="avatar-title bg-light rounded-circle text-primary">
                                                                    {{ substr($laporan->penempatan->pembimbing->nama, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">
                                                                    {{ $laporan->penempatan->pembimbing->nama }}</h6>
                                                                <small class="text-muted">Pembimbing</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-3">
                                                    @if ($laporan->status_validasi == 'valid')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                                            <i class="bi bi-check-circle me-1"></i> Valid
                                                        </span>
                                                    @elseif($laporan->status_validasi == 'tidak valid')
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded-pill">
                                                            <i class="bi bi-x-circle me-1"></i> Tidak Valid
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning py-2 px-3 rounded-pill">
                                                            <i class="bi bi-hourglass me-1"></i>
                                                            {{ ucfirst($laporan->status_validasi) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3">
                                                    <div class="text-truncate" style="max-width: 200px;">
                                                        {{ $laporan->keterangan_validasi ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-medium">{{ $laporan->created_at->format('d M Y') }}</span>
                                                        <small
                                                            class="text-muted">{{ $laporan->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </td>
                                                <td class="pe-4 py-3 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('laporan-harian.show', $laporan->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        @if (in_array(auth()->user()->role, ['admin', 'siswa']))
                                                            <a href="{{ route('laporan-harian.edit', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if ($laporans->hasPages())
                        <div class="card-footer bg-transparent border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Menampilkan {{ $laporans->firstItem() }} - {{ $laporans->lastItem() }} dari
                                    {{ $laporans->total() }} laporan
                                </div>
                                <nav aria-label="Page navigation">
                                    {{ $laporans->onEachSide(1)->links() }}
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .avatar-sm {
            width: 36px;
            height: 36px;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-weight: 600;
        }

        .table> :not(:first-child) {
            border-top: 0;
        }

        .table th {
            font-size: 0.8rem;
        }

        .table td {
            vertical-align: middle;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }
    </style>
@endpush

@push('js')
    <script>
        // Enable tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
