@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Info Box: Total Users -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info shadow-sm">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $totalUsers ?? 0 }}</span>
                    <a href="{{ route('admin.users.index') }}" class="small d-block text-info">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Info Box: Total Siswa -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success shadow-sm">
                    <i class="fas fa-user-graduate"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Siswa</span>
                    <span class="info-box-number">{{ $totalSiswas ?? 0 }}</span>
                    <a href="{{ route('admin.siswas.index') }}" class="small d-block text-success">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Info Box: Total Industri -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning shadow-sm">
                    <i class="fas fa-industry"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Industri</span>
                    <span class="info-box-number">{{ $totalIndustris ?? 0 }}</span>
                    <a href="{{ route('admin.industris.index') }}" class="small d-block text-warning">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Info Box: Total Pembimbing -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger shadow-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pembimbing</span>
                    <span class="info-box-number">{{ $totalPembimbings ?? 0 }}</span>
                    <a href="{{ route('admin.pembimbings.index') }}" class="small d-block text-danger">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>


@endsection
