@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h4 mb-0 fw-bold">
                                    <i class="bi bi-plus-circle me-2"></i>Buat Laporan Harian Baru
                                </h2>
                                <p class="mb-0 small opacity-75">Unggah laporan kegiatan harian Anda</p>
                            </div>
                            <a href="{{ route('laporan-harian.index') }}"
                                class="btn btn-light text-primary rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <form action="{{ route('laporan-harian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Placement Selection -->
                            <div class="mb-4">
                                <label for="penempatan_id" class="form-label fw-semibold">
                                    <i class="bi bi-briefcase me-1"></i>Penempatan
                                </label>

                                @if ($penempatan)
                                    <div class="card bg-light mb-4 border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small mb-1">Nama
                                                            Industri</label>
                                                        <div class="p-3 bg-white rounded-3 border fw-semibold">
                                                            {{ $penempatan->industri->nama }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small mb-1">Tanggal
                                                            Mulai</label>
                                                        <div class="p-3 bg-white rounded-3 border">
                                                            {{ $penempatan->tanggal_penempatan->format('d F Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tambahkan input hidden untuk menyimpan penempatan_id -->
                                            <input type="hidden" name="penempatan_id" value="{{ $penempatan->id }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Anda belum memiliki penempatan yang
                                        aktif
                                    </div>
                                @endif

                                @error('penempatan_id')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-earmark-arrow-up me-1"></i>File Laporan
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="file_laporan" id="file_laporan"
                                        class="form-control @error('file_laporan') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx" required>
                                    @error('file_laporan')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted">Format: PDF, DOC, DOCX (Maks. 2MB)</small>
                                <div class="mt-2" id="file-preview"></div>
                            </div>

                            <!-- Additional Fields (if needed) -->
                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text me-1"></i>Keterangan Tambahan (Opsional)
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3" class="form-control"
                                    placeholder="Tambahkan catatan jika diperlukan"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                    <i class="bi bi-cloud-arrow-up me-2"></i>Unggah Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }

        .file-upload-wrapper {
            position: relative;
        }

        .form-control {
            padding: 0.75rem 1rem;
        }

        .form-select-lg {
            padding: 0.75rem 1rem;
        }

        #file-preview {
            border: 1px dashed #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            display: none;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload preview
            const fileInput = document.getElementById('file_laporan');
            const filePreview = document.getElementById('file-preview');

            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    filePreview.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text fs-3 me-3 text-primary"></i>
                        <div>
                            <h6 class="mb-0">${file.name}</h6>
                            <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
                        </div>
                    </div>
                `;
                    filePreview.style.display = 'block';
                } else {
                    filePreview.style.display = 'none';
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Silakan pilih file laporan terlebih dahulu');
                }
            });
        });
    </script>
@endpush
