@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <!-- Header -->
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-book me-2"></i>Laporan Harian
                        </h5>
                        <small class="opacity-75">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</small>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <form action="{{ route('laporan-harian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="penempatan_id" value="{{ $penempatan->id }}">
                            <input type="hidden" name="siswa_id" value="{{ $penempatan->siswa_id }}">

                            <!-- Info Industri -->
                            <div class="alert alert-light border mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-building text-primary me-3"></i>
                                    <div>
                                        <strong>{{ $penempatan->industri->nama }}</strong>
                                        <div class="text-muted small">Lokasi Penempatan</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kegiatan -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tasks me-1 text-primary"></i> Kegiatan Hari Ini
                                </label>
                                <textarea name="kegiatan" class="form-control" rows="5"
                                    placeholder="Deskripsi lengkap kegiatan yang Anda lakukan hari ini" required></textarea>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-edit me-1 text-primary"></i> Catatan/Refleksi
                                </label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Apa yang Anda pelajari hari ini? (opsional)"></textarea>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
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
            border-radius: 8px;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endpush
