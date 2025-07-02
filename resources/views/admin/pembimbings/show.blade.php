@extends('layouts.app')
@section('title', 'Detail Pembimbing')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-tie me-2"></i>Detail Pembimbing
                </h5>
            </div>

            <div class="card-body">
                {{-- Informasi Akun --}}
                <h6 class="text-muted mb-3"><i class="fas fa-user-circle me-1"></i> Informasi Akun</h6>
                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <strong>Nama Akun:</strong><br>{{ $pembimbing->user->name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email Akun:</strong><br>{{ $pembimbing->user->email }}
                    </div>
                </div>

                {{-- Informasi Pribadi --}}
                <h6 class="text-muted mb-3"><i class="fas fa-id-card-alt me-1"></i> Profil Pembimbing</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong><br>{{ $pembimbing->nama_lengkap }}
                    </div>
                    <div class="col-md-6">
                        <strong>NIY:</strong><br>{{ $pembimbing->niy }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email Pembimbing:</strong><br>{{ $pembimbing->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>No HP:</strong><br>{{ $pembimbing->no_hp }}
                    </div>
                    <div class="col-md-6">
                        <strong>Jabatan:</strong><br>{{ $pembimbing->jabatan }}
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat:</strong><br>{{ $pembimbing->alamat }}
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.pembimbings.edit', $pembimbing) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.pembimbings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
