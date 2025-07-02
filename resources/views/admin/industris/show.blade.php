@extends('layouts.app')
@section('title', 'Detail Industri')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>Detail Industri
                </h5>
            </div>

            <div class="card-body">
                {{-- Informasi Umum --}}
                <h6 class="text-muted mb-3"><i class="fas fa-building me-1"></i> Informasi Perusahaan</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama Industri:</strong><br>{{ $industri->nama }}
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat:</strong><br>{{ $industri->alamat }}
                    </div>
                    <div class="col-md-6">
                        <strong>Telepon:</strong><br>{{ $industri->telepon }}
                    </div>
                </div>

                {{-- Penanggung Jawab --}}
                <h6 class="text-muted mt-4 mb-3"><i class="fas fa-user-tie me-1"></i> Penanggung Jawab</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama PJ:</strong><br>{{ $industri->nama_pj }}
                    </div>
                    <div class="col-md-6">
                        <strong>Jabatan PJ:</strong><br>{{ $industri->jabatan_pj }}
                    </div>
                    <div class="col-md-6">
                        <strong>Telepon PJ:</strong><br>{{ $industri->telepon_pj }}
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.industris.edit', $industri) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.industris.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
