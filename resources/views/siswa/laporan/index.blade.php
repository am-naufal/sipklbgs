@extends('layouts.app')
@section('title', 'Laporan Saya')
@section('styles')
    <style>
        .empty-state {
            padding: 3rem 1rem;
            background-color: #f8f9fa;
            border-radius: 1rem;
            margin-top: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            background-color: #f1f3f5;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-state img {
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .empty-state:hover img {
            opacity: 0.9;
        }

        .list-unstyled li {
            padding-left: 1.5rem;
            position: relative;
        }

        .list-unstyled i.fa-check-circle {
            position: absolute;
            left: 0;
            top: 0.25rem;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        @if ($totalLaporan > 0)
            {{-- Tampilan normal ketika ada laporan --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>Laporan Saya</h1>
                    <p class="text-muted mb-0">Terakhir dikirim: {{ $lastSubmission }}</p>
                </div>
                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Input Revisi laporan
                </a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $index => $laporan)
                                    <tr>
                                        <td>{{ $laporans->firstItem() + $index }}</td>
                                        <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if ($laporan->status == 'valid')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($laporan->status == 'revisi')
                                                <span class="badge bg-danger">Perlu Revisi</span>
                                            @else
                                                <span class="badge bg-warning">Menunggu Validasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($laporan->status == 'revisi' && $laporan->catatan_revisi)
                                                <span class="text-danger">{{ $laporan->catatan_revisi }}</span>
                                            @else
                                                <span class="text-muted">Tidak ada catatan revisi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('laporan.show', $laporan->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($laporan->status != 'valid')
                                                    <a href="{{ route('laporan.edit', $laporan->id) }}"
                                                        class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('laporan.download', $laporan->id) }}"
                                                    class="btn btn-sm btn-outline-success" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada laporan</p>
                                                <a href="{{ route('laporan.create') }}" class="btn btn-primary btn-sm">
                                                    Buat Laporan Pertama Anda
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($laporans->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $laporans->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <div class="alert alert-info">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Status Laporan</h5>
                    <ul class="mb-0">
                        <li><span class="badge bg-warning">Menunggu Validasi</span> - Laporan sedang ditinjau</li>
                        <li><span class="badge bg-success">Diterima</span> - Laporan telah divalidasi</li>
                        <li><span class="badge bg-danger">Perlu Revisi</span> - Laporan memerlukan perbaikan</li>
                    </ul>
                </div>
            </div>
        @else
            {{-- Tampilan khusus ketika belum ada laporan --}}
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="empty-state">
                        <img src="{{ asset('images/no-data.svg') }}" alt="No data" class="img-fluid"
                            style="max-height: 250px;">
                        <h2 class="mt-4">Anda Belum Memiliki Laporan</h2>
                        <p class="text-muted">Mulai buat laporan pertama Anda untuk mencatat perkembangan kegiatan</p>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                            <a href="{{ route('laporan.create') }}" class="btn btn-primary btn-lg px-4 gap-3">
                                <i class="fas fa-plus me-2"></i> Buat Laporan Pertama
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-toggle="modal"
                                data-bs-target="#guideModal">
                                <i class="fas fa-question-circle me-2"></i> Panduan
                            </button>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-body text-start">
                            <h5><i class="fas fa-lightbulb text-warning me-2"></i> Tips Membuat Laporan yang Baik</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Sertakan data
                                    lengkap sesuai format</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Upload dokumen
                                    dalam format PDF</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Beri judul yang
                                    jelas dan deskriptif</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Cantumkan tanggal kegiatan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Panduan -->
    <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guideModalLabel"><i class="fas fa-book me-2"></i> Panduan Membuat
                        Laporan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h6>Langkah-langkah:</h6>
                        <ol>
                            <li class="mb-2">Klik tombol "Buat Laporan Pertama"</li>
                            <li class="mb-2">Isi form laporan dengan data yang valid</li>
                            <li class="mb-2">Upload file laporan (format PDF/DOC/DOCX)</li>
                            <li class="mb-2">Klik "Simpan" untuk mengirimkan</li>
                        </ol>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Ketentuan Laporan:</h6>
                        <ul class="mb-0">
                            <li>Ukuran file maksimal 2MB</li>
                            <li>Status "Menunggu" berarti laporan sedang ditinjau</li>
                            <li>Anda bisa mengedit laporan sebelum divalidasi</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
                </div>
            </div>
        </div>
    </div>
@endsection
