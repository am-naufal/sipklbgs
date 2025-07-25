@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('laporan-harian.create') }}" class="btn btn-primary text-light rounded-pill px-4 ">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Laporan
                    </a>
                </div>
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0 fw-bold">
                            <i class="fas fa-clipboard-list me-2"></i>Daftar Laporan Harian Saya
                        </h2>

                    </div>
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
                                <p class="text-muted mb-4">Anda belum membuat laporan harian</p>
                                <a href="{{ route('laporan-harian.create') }}" class="btn btn-primary px-4 rounded-pill">
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
                                                        <a href="{{ route('laporan-harian.show', $laporan->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($laporan->status_validasi == 'menunggu')
                                                            <a href="{{ route('laporan-harian.edit', $laporan->id) }}"
                                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                                data-bs-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('laporan-harian.destroy', $laporan->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                    title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
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
