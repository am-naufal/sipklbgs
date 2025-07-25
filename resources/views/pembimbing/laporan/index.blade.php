@extends('layouts.app')

@section('title', 'Daftar Laporan')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="fas fa-clipboard-list me-2"></i>Daftar Laporan
                                </h2>
                                <p class="mb-0 small opacity-75">
                                    @if (auth()->user()->role === 'admin')
                                        Semua laporan siswa
                                    @else
                                        Laporan yang perlu ditinjau
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('admin.laporans.create') }}"
                                class="btn btn-light text-primary rounded-pill px-4">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Laporan
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-0">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($laporans->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-clipboard fa-4x text-muted"></i>
                                </div>
                                <h3 class="h4 text-muted mb-3">Belum Ada Laporan</h3>
                                <p class="text-muted mb-4">
                                    Tidak ada laporan yang ditemukan
                                </p>
                                <a href="{{ route('admin.laporans.create') }}" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-plus-circle me-2"></i>Buat Laporan Pertama
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3">No</th>
                                            <th class="ps-4 py-3">Siswa</th>
                                            <th class="py-3">Penempatan</th>
                                            <th class="py-3">Tanggal</th>
                                            <th class="py-3">Status</th>
                                            <th class="pe-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporans as $laporan)
                                            <tr>
                                                <td class="py-3">{{ $loop->iteration }}</td>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $laporan->siswa->nama }}</h6>
                                                            <small class="text-muted">NIS:
                                                                {{ $laporan->siswa->nisn }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-building me-2 text-primary"></i>
                                                        <span>{{ $laporan->penempatan->industri->nama }}</span>
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
                                                <td class="py-3">
                                                    @if ($laporan->status_validasi == 'valid')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                                            <i class="fas fa-check-circle me-1"></i> Disetujui
                                                        </span>
                                                    @elseif($laporan->status_validasi == 'revisi')
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded-pill">
                                                            <i class="fas fa-times-circle me-1"></i> Revisi
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning py-2 px-3 rounded-pill">
                                                            <i class="fas fa-clock me-1"></i> Menunggu
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="pe-4 py-3 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('admin.laporans.show.list', $laporan->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.laporans.edit', $laporan->id) }}"
                                                            class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.laporans.download', $laporan->id) }}"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                            data-bs-toggle="tooltip" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <form action="{{ route('admin.laporans.destroy', $laporan->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Hapus"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

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

@push('styles')
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .badge {
            font-weight: 500;
        }

        .btn-outline-primary {
            border-color: #4e73df;
            color: #4e73df;
        }

        .btn-outline-primary:hover {
            background-color: #4e73df;
            color: white;
        }

        /* Animasi modal lebih halus */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out, opacity 0.3s ease;
            transform: translate(0, -50px);
            opacity: 0;
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
            opacity: 1;
        }

        /* Efek hover tombol */
        .btn-outline-danger:hover {
            background-color: var(--bs-danger);
            color: white;
        }

        /* Placeholder textarea lebih jelas */
        textarea::placeholder {
            color: #6c757d;
            opacity: 0.6;
        }

        /* Responsive modal */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
