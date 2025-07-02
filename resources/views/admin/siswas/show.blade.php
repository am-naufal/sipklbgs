@extends('layouts.app')
@section('title', 'Detail Siswa')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate me-2"></i>Detail Siswa
                </h5>
            </div>
            @php
                $jurusanMap = [
                    'tb' => 'Tata Boga',
                    'mm' => 'Multimedia',
                    'aphp' => 'Agribisnis Pengolahan Hasil Pertanian',
                ];
            @endphp
            <div class="card-body">
                {{-- Informasi Akun --}}
                <h6 class="text-muted mb-3"><i class="fas fa-user-circle me-1"></i> Informasi Akun</h6>
                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <strong>Nama Akun:</strong><br>{{ $siswa->user->name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email Akun:</strong><br>{{ $siswa->user->email }}
                    </div>
                </div>

                {{-- Informasi Pribadi --}}
                <h6 class="text-muted mb-3"><i class="fas fa-address-card me-1"></i> Data Pribadi</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong><br>{{ $siswa->nama }}
                    </div>
                    <div class="col-md-6">
                        <strong>Tempat, Tanggal Lahir:</strong><br>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}
                    </div>
                    <div class="col-md-6">
                        <strong>NIS:</strong><br>{{ $siswa->nis }}
                    </div>
                    <div class="col-md-6">
                        <strong>NISN:</strong><br>{{ $siswa->nisn }}
                    </div>
                    <div class="col-md-6">
                        <strong>Kelas:</strong><br>{{ $siswa->kelas }}
                    </div>
                    <div class="col-md-6">
                        <strong>Jurusan:</strong><br>
                        {{ $jurusanMap[strtolower($siswa->jurusan)] ?? strtoupper($siswa->jurusan) }}
                    </div>
                    <div class="col-md-12">
                        <strong>Alamat:</strong><br>{{ $siswa->alamat }}
                    </div>
                </div>

                {{-- Informasi PKL --}}
                <h6 class="text-muted mt-4 mb-3"><i class="fas fa-briefcase me-1"></i> Praktik Kerja Lapangan (PKL)</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Status PKL:</strong><br>{{ ucfirst(str_replace('_', ' ', $siswa->status_pkl)) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Tahun Angkatan:</strong><br>{{ $siswa->tahun_angkatan }}
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Mulai PKL:</strong><br>{{ $siswa->tanggal_mulai ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Selesai PKL:</strong><br>{{ $siswa->tanggal_selesai ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.siswas.edit', $siswa) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.siswas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
