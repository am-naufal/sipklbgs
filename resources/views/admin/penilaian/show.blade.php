@extends('layouts.app')

@section('title', 'Detail Penilaian - ' . $penilaian->nama)

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Detail Penilaian PKL
                    </h2>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <p class="text-muted">Detail penilaian untuk siswa: <strong>{{ $penilaian->nama }}</strong></p>
            </div>
        </div>

        <!-- Informasi Siswa Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-graduate me-2"></i>
                            Informasi Siswa
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon"><i class="fas fa-id-card text-primary"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">NISN</span>
                                        <span class="info-box-number">{{ $penilaian->siswa->nisn }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-light">
                                    <span class="info-box-icon"><i class="fas fa-users text-info"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kelas</span>
                                        <span class="info-box-number">{{ $penilaian->siswa->kelas }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-light">
                                    <span class="info-box-icon"><i class="fas fa-graduation-cap text-warning"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jurusan</span>
                                        @if ($penilaian->siswa->jurusan == 'tb')
                                            <span class="info-box-number">Tata Boga</span>
                                        @elseif ($penilaian->siswa->jurusan == 'aphp')
                                            <span class="info-box-number">APHP</span>
                                        @elseif ($penilaian->siswa->jurusan == 'mm')
                                            <span class="info-box-number">Multimedia</span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon"><i class="fas fa-building text-success"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Instansi</span>
                                        <span class="info-box-number">{{ $penilaian->industri->nama ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-light">
                                    <span class="info-box-icon"><i class="fas fa-user-tie text-danger"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pembimbing</span>
                                        <span
                                            class="info-box-number">{{ $penilaian->pembimbing->nama_lengkap ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        @if ($penilaian && ($penilaian->nilai_teknis || $penilaian->disiplin))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie me-2"></i>
                                Ringkasan Performa
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if ($penilaian->nilai_teknis)
                                    <div class="col-md-4">
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3>{{ number_format($penilaian->nilai_teknis, 1) }}</h3>
                                                <p>Nilai Teknis</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <span class="small-box-footer">
                                                {{ $penilaian->kualifikasiTeknis() }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if ($penilaian->rataRataNonTeknis())
                                    <div class="col-md-4">
                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h3>{{ number_format($penilaian->rataRataNonTeknis(), 1) }}</h3>
                                                <p>Rata-rata Non-Teknis</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <span class="small-box-footer">
                                                {{ $penilaian->kualifikasiRataRata() }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if ($penilaian->nilaiAkhir())
                                    <div class="col-md-4">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>{{ number_format($penilaian->nilaiAkhir(), 1) }}</h3>
                                                <p>Nilai Akhir</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="small-box-footer">
                                                {{ $penilaian->kualifikasiNilaiAkhir() }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Nilai Teknis Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cogs me-2"></i>
                            Nilai Teknis
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($penilaian && $penilaian->nilai_teknis)
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <span
                                                class="display-4 fw-bold text-primary">{{ $penilaian->nilai_teknis }}</span>
                                            <span class="text-muted">/100</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $penilaian->kualifikasiTeknis() }}</div>
                                            <div class="text-muted">Kualifikasi</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="progress-group">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar {{ $penilaian->getProgressBarColor($penilaian->nilai_teknis) }}"
                                                role="progressbar" style="width: {{ $penilaian->nilai_teknis }}%"
                                                aria-valuenow="{{ $penilaian->nilai_teknis }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="progress-text">
                                            <span class="progress-number"><b>{{ $penilaian->nilai_teknis }}</b>/100</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum ada nilai teknis
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Non-Teknis Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users me-2"></i>
                            Nilai Non-Teknis
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($penilaian && $penilaian->disiplin)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Aspek Penilaian</th>
                                            <th width="100">Nilai</th>
                                            <th width="150">Kualifikasi</th>
                                            <th width="200">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $aspects = [
                                                'disiplin' => ['icon' => 'fas fa-clock', 'label' => 'Disiplin'],
                                                'kerjasama' => ['icon' => 'fas fa-handshake', 'label' => 'Kerjasama'],
                                                'inisiatif' => ['icon' => 'fas fa-lightbulb', 'label' => 'Inisiatif'],
                                                'tanggung_jawab' => [
                                                    'icon' => 'fas fa-shield-alt',
                                                    'label' => 'Tanggung Jawab',
                                                ],
                                                'kebersihan' => ['icon' => 'fas fa-broom', 'label' => 'Kebersihan'],
                                            ];
                                        @endphp

                                        @foreach ($aspects as $field => $data)
                                            <tr>
                                                <td>
                                                    <i class="{{ $data['icon'] }} me-2 text-primary"></i>
                                                    {{ $data['label'] }}
                                                </td>
                                                <td class="fw-bold">{{ $penilaian->$field }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $penilaian->$field >= 70 ? 'success' : ($penilaian->$field >= 60 ? 'warning' : 'danger') }}">
                                                        {{ $penilaian->kualifikasiNonTeknis($penilaian->$field) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="progress-group">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar {{ $penilaian->getProgressBarColor($penilaian->$field) }}"
                                                                style="width: {{ $penilaian->$field }}%">
                                                            </div>
                                                        </div>
                                                        <div class="progress-text">
                                                            <span class="progress-number">{{ $penilaian->$field }}%</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($penilaian->catatan)
                                <div class="mt-4">
                                    <h5 class="text-primary">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        Catatan Pembimbing
                                    </h5>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $penilaian->catatan }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum ada nilai non-teknis
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        @if ($penilaian)
                            <a href="{{ route('admin.penilaian.edit', $penilaian->id) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit Penilaian
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
