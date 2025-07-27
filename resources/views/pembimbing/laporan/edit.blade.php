@extends('layouts.app')

@section('title', 'Edit Laporan Siswa')
@section('styles')
    <style>
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .card-header {
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .alert {
            border-left: 4px solid var(--bs-info);
        }
    </style>
@endsection
@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Laporan
                    </h2>
                    <div>
                        <span
                            class="badge rounded-pill bg-{{ $laporan->status == 'valid' ? 'success' : ($laporan->status == 'revisi' ? 'danger' : 'warning') }} fs-6">
                            <i
                                class="fas fa-{{ $laporan->status == 'valid' ? 'check-circle' : ($laporan->status == 'revisi' ? 'exclamation-circle' : 'clock') }} me-1"></i>
                            {{ $laporan->status_label[0] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Student and Placement Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-graduate me-2 text-primary"></i>Nama Siswa
                                </label>
                                <input type="text" class="form-control bg-light" value="{{ $laporan->siswa->nama }}"
                                    readonly>
                                <input type="hidden" name="siswa_id" value="{{ $laporan->siswa_id }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-building me-2 text-primary"></i>Instansi
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $laporan->penempatan->industri->nama }}" readonly>
                                <input type="hidden" name="penempatan_id" value="{{ $laporan->penempatan_id }}">
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->role == 'pembimbing')
                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">
                                <i class="fas fa-tasks me-2 text-primary"></i>Status
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="menunggu"
                                    {{ old('status', $laporan->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Validasi
                                </option>
                                <option value="valid"
                                    {{ old('status', $laporan->status_validasi) == 'valid' ? 'selected' : '' }}>
                                    Diterima</option>
                                <option value="revisi"
                                    {{ old('status', $laporan->status_validasi) == 'revisi' ? 'selected' : '' }}>
                                    Perlu Revisi</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan Revisi (conditional) -->
                        <div class="mb-4" id="keterangan-validasi-container"
                            style="{{ $laporan->status != 'revisi' ? 'display: none;' : '' }}">
                            <label for="keterangan-validasi" class="form-label fw-bold">
                                <i class="fas fa-comment-dots me-2 text-primary"></i>Catatan Revisi
                            </label>
                            <textarea class="form-control @error('keterangan-validasi') is-invalid @enderror" id="keterangan-validasi"
                                name="keterangan-validasi" rows="3">{{ old('keterangan_validasi', $laporan->keterangan_validasi) }}</textarea>
                            @error('keterangan-validasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="status" value="{{ $laporan->status }}">
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between pt-4 border-top">
                        <a href="{{ route('pembimbing.laporans.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'pembimbing')
        <script>
            document.getElementById('status').addEventListener('change', function() {
                const catatanRevisiContainer = document.getElementById('keterangan-validasi-container');
                if (this.value === 'revisi') {
                    catatanRevisiContainer.style.display = 'block';
                    document.getElementById('keterangan_validasi').setAttribute('required', 'required');
                } else {
                    catatanRevisiContainer.style.display = 'none';
                    document.getElementById('keterangan_validasi').removeAttribute('required');
                }
            });
        </script>
    @endif


@endsection
