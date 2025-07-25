@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    {{-- @dd($laporans) --}}
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="fas fa-clipboard-list me-2"></i>Daftar Laporan Harian
                                </h2>
                                <p class="mb-0 small opacity-75">
                                    @if (auth()->user()->role === 'siswa')
                                        Laporan harian Anda
                                    @elseif(in_array(auth()->user()->role, ['pembimbing', 'industri']))
                                        Laporan siswa bimbingan Anda
                                    @else
                                        Semua laporan harian
                                    @endif
                                </p>
                            </div>
                            @if (auth()->user()->role === 'siswa')
                                <a href="{{ route('laporan-harian.create') }}"
                                    class="btn btn-light text-primary rounded-pill px-4">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Laporan
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-0">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
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
                                    @if (auth()->user()->role === 'siswa')
                                        Anda belum membuat laporan harian
                                    @else
                                        Tidak ada laporan yang ditemukan
                                    @endif
                                </p>
                                @if (auth()->user()->role === 'siswa')
                                    <a href="{{ route('laporan-harian.create') }}"
                                        class="btn btn-primary px-4 rounded-pill">
                                        <i class="fas fa-plus-circle me-2"></i>Buat Laporan Pertama
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3">No</th>
                                            @if (in_array(auth()->user()->role, ['admin', 'pembimbing', 'industri']))
                                                <th class="ps-4 py-3">Siswa</th>
                                            @endif
                                            <th class="py-3">Industri</th>
                                            @if (auth()->user()->role === 'admin')
                                                <th class="py-3">Pembimbing</th>
                                            @endif
                                            <th class="py-3">Tanggal</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3">Kegiatan</th>
                                            <th class="py-3">Keterangan</th>
                                            <th class="pe-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporans as $laporan)
                                            <tr>
                                                <td class="py-3">{{ $loop->iteration }}</td>
                                                @if (in_array(auth()->user()->role, ['admin', 'pembimbing', 'industri']))
                                                    <td class="ps-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-3">
                                                                <div
                                                                    class="avatar-title bg-light rounded-circle text-primary">
                                                                    {{ substr($laporan->siswa->nama, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-semibold">
                                                                    {{ $laporan->siswa->nama ?? '-' }}</h6>
                                                                <small class="text-muted">NIS:
                                                                    {{ $laporan->siswa->nisn ?? '-' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-building me-2 text-primary"></i>
                                                        <span>{{ $laporan->penempatan->industri->nama ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                @if (auth()->user()->role === 'admin')
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
                                                @endif
                                                <td class="py-3">
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-medium">{{ $laporan->created_at->format('d M Y') }}</span>
                                                        <small
                                                            class="text-muted">{{ $laporan->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    @if ($laporan->status_validasi == 'diterima')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                                            <i class="fas fa-check-circle me-1"></i> Valid
                                                        </span>
                                                    @elseif($laporan->status_validasi == 'ditolak')
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded-pill">
                                                            <i class="fas fa-times-circle me-1"></i> Tidak Valid
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning py-2 px-3 rounded-pill">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ ucfirst($laporan->status_validasi) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3">
                                                    <div class="text-truncate" style="max-width: 200px;">
                                                        {{ $laporan->kegiatan ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="text-truncate" style="max-width: 200px;">
                                                        {{ $laporan->keterangan_validasi ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="pe-4 py-3 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if (auth()->user()->role === 'siswa' && $laporan->status_validasi == 'menunggu')
                                                            <a href="{{ route('laporan-harian.show', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('laporan-harian.edit', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->role === 'admin')
                                                            <a href="{{ route('admin.laporan-harian.bysiswa', $laporan->siswa_id) }}"
                                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Validasi"
                                                                onclick="validasiLaporan({{ $laporan->id }}, 'valid')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Tolak"
                                                                onclick="validasiLaporan({{ $laporan->id }}, 'tidak valid')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
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

        // Validation function for admin
        function validasiLaporan(id, status) {
            if (confirm(`Apakah Anda yakin ingin ${status === 'valid' ? 'memvalidasi' : 'menolak'} laporan ini?`)) {
                fetch(`/laporan-harian/${id}/validasi`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Gagal memvalidasi laporan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan');
                    });
            }
        }
    </script>
@endpush
