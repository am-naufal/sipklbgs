@extends('layouts.app')

@section('title', 'Laporan Akhir')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class=" mb-3">
                    <a href="{{ route('admin.laporans.index') }}" class="btn btn-primary rounded-pill p-3 shadow-lg"
                        title="Kembali">
                        <i class="fas fa-arrow-left fs-5"></i>Kembali
                    </a>
                </div>
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="fas fa-file-alt me-2"></i>Laporan Akhir
                                </h2>
                                <p class="mb-0 small opacity-75">
                                    Daftar laporan akhir siswa
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
                                    <i class="fas fa-file-alt fa-4x text-muted"></i>
                                </div>
                                <h3 class="h4 text-muted mb-3">Belum Ada Laporan</h3>
                                <p class="text-muted mb-4">
                                    Tidak ada laporan akhir yang ditemukan
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
                                            <th class="py-3">Tanggal</th>
                                            <th class="ps-4 py-3">Siswa</th>
                                            <th class="py-3">Penempatan</th>
                                            <th class="py-3">Status</th>
                                            <th class="pe-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporans as $laporan)
                                            <tr>
                                                <td class="py-3">{{ $loop->iteration }}</td>
                                                <td class="py-3">
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-medium">{{ $laporan->updated_at->format('d M Y') }}</span>
                                                        <small
                                                            class="text-muted">{{ $laporan->updated_at->diffForHumans() }}</small>
                                                    </div>
                                                </td>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3">
                                                            <div class="avatar-title bg-light rounded-circle text-primary">
                                                                {{ substr($laporan->siswa->nama, 0, 1) }}
                                                            </div>
                                                        </div>
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
                                                    @if ($laporan->status_validasi == 'valid')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                                            <i class="fas fa-check-circle me-1"></i> Divalidasi
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

                                                        @if (auth()->user()->role === 'siswa' && $laporan->status_validasi == 'menunggu')
                                                            <a href="{{ route('laporans.edit', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.laporans.destroy', $laporan->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                    data-bs-toggle="tooltip" title="Hapus"
                                                                    onclick="return confirm('Yakin hapus laporan ini?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if (auth()->user()->role === 'admin')
                                                            <a href="{{ route('admin.laporans.show', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            @if ($laporan->status_validasi == 'menunggu')
                                                                <form
                                                                    action="{{ route('admin.laporans.validasi', $laporan->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="valid">
                                                                    <input type="hidden" name="keterangan_validasi"
                                                                        value="Tidak Ada Catatan">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                                        title="Validasi">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>
                                                                <!-- Button Revisi - Dioptimalkan -->
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-warning rounded-pill px-3 position-relative"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalRevisi{{ $laporan->id }}"
                                                                    title="Ajukan Revisi"
                                                                    onclick="initRevisiModal('{{ $laporan->id }}')">
                                                                    <i class="fas fa-undo me-1"></i> Revisi
                                                                    <span
                                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                        !
                                                                    </span>
                                                                </button>
                                                                <form
                                                                    action="{{ route('admin.laporans.destroy', $laporan->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                        data-bs-toggle="tooltip" title="Hapus"
                                                                        onclick="return confirm('Yakin hapus laporan ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
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
                </div>
            </div>
        </div>


        <!-- Modal Revisi - Versi Optimasi -->
        <div class="modal fade" id="modalRevisi{{ $laporan->id }}" tabindex="-1"
            aria-labelledby="modalRevisiLabel{{ $laporan->id }}" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-warning border-3">
                    <form id="formRevisi{{ $laporan->id }}"
                        action="{{ route('admin.laporans.validasi', $laporan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="revisi">

                        <div class="modal-header bg-warning text-dark">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h5 class="modal-title mb-0 fw-bold" id="modalRevisiLabel{{ $laporan->id }}">
                                        Permintaan Revisi Laporan
                                    </h5>
                                    <p class="small mb-0">ID: LAP-{{ $laporan->id }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body py-4">
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-info-circle me-3 fs-4"></i>
                                <div>
                                    <strong>Petunjuk:</strong> Berikan instruksi revisi yang jelas dan spesifik agar siswa
                                    dapat memperbaiki laporannya.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keteranganRevisi{{ $laporan->id }}" class="form-label fw-semibold">
                                    <i class="fas fa-edit me-1"></i> Detail Revisi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control border-warning" id="keteranganRevisi{{ $laporan->id }}" name="keterangan_validasi"
                                    rows="5" placeholder="Contoh: Mohon diperbaiki bagian analisis pada halaman 3, tambahkan data pendukung..."
                                    required></textarea>
                                <div class="form-text text-end">
                                    <span id="charCount{{ $laporan->id }}">0</span>/200 karakter
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="notifEmail{{ $laporan->id }}"
                                    name="send_email" checked>
                                <label class="form-check-label" for="notifEmail{{ $laporan->id }}">
                                    Kirim notifikasi email ke siswa
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-warning text-white rounded-pill px-4">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Revisi
                            </button>
                        </div>
                    </form>
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
    </style>
@endpush

@push('scripts')
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
