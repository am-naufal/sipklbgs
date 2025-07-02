@extends('layouts.app')
@section('title', 'Detail User')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-cog me-2"></i>Detail User
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama Akun:</strong><br>{{ $user->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong><br>{{ $user->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>Role:</strong><br>{{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        @if ($user->email_verified_at)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-secondary">Belum Verifikasi</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Dibuat pada:</strong><br>{{ $user->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Terakhir diperbarui:</strong><br>{{ $user->updated_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
