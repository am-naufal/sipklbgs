@extends('layouts.app')
@section('title', 'Detail Penempatan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-2xl font-bold">Detail Penempatan</h1>
            <a href="{{ route('admin.penempatans.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>Penempatan Siswa
                </h5>
            </div>
            <div class="card-body">
                <div class=" row col-md-6">
                    <h5 class="card-title mb-3"><i class="fas fa-user-graduate me-2 text-primary"></i>Data Siswa</h5>
                </div>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Nama</strong></span>
                        <span>{{ $penempatan->siswa->nama ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>NISN</strong></span>
                        <span>{{ $penempatan->siswa->nisn ?? '-' }}</span>
                    </li>
                </ul>

                {{-- DATA INDUSTRI --}}
                <div class=" row col-md-6">
                    <h5 class="card-title mb-3"><i class="fas fa-industry me-2 text-success"></i>Data Industri</h5>
                </div>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Nama Industri</strong></span>
                        <span>{{ $penempatan->industri->nama ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Alamat</strong></span>
                        <span>{{ $penempatan->industri->alamat ?? '-' }}</span>
                    </li>
                </ul>

                {{-- DATA PEMBIMBING --}}
                <div class=" row col-md-6">
                    <h5 class="card-title mb-3"><i class="fas fa-chalkboard-teacher me-2 text-warning"></i>Data Pembimbing
                    </h5>
                </div>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Nama</strong></span>
                        <span>{{ $penempatan->pembimbing->nama_lengkap ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>No HP</strong></span>
                        <span>{{ $penempatan->pembimbing->no_hp ?? '-' }}</span>
                    </li>
                </ul>

                {{-- DETAIL PENEMPATAN --}}
                <div class=" row col-md-6">
                    <h5 class="card-title mb-3"><i class="fas fa-calendar-check me-2 text-info"></i>Detail Penempatan</h5>
                </div>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Tanggal Penempatan</strong></span>
                        <span>{{ \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->translatedFormat('d F Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Tanggal Selesai</strong></span>
                        <span>
                            {{ $penempatan->tanggal_selesai ? \Carbon\Carbon::parse($penempatan->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Status</strong></span>
                        <span>
                            <span
                                class="badge
                                @if ($penempatan->status == 'menunggu') bg-warning
                                @elseif($penempatan->status == 'disetujui') bg-success
                                @elseif($penempatan->status == 'ditolak') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($penempatan->status) }}
                            </span>
                        </span>
                    </li>
                    @if ($penempatan->keterangan)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Keterangan</strong></span>
                            <span>{{ $penempatan->keterangan }}</span>
                        </li>
                    @endif
                </ul>

                {{-- METADATA --}}
                <div class="text-muted small mt-3">
                    <i class="fas fa-clock me-1"></i>
                    Dibuat: {{ $penempatan->created_at->diffForHumans() }} |
                    Diperbarui: {{ $penempatan->updated_at->diffForHumans() }}
                </div>

            </div>
        </div>
    </div>
@endsection
