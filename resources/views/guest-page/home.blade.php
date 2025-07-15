@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mb-3">Selamat Datang di <span class="text-success">SIPKL</span></h1>
            <p class="lead">
                Sistem Informasi Praktik Kerja Lapangan untuk mempermudah proses administrasi, pelaporan, dan pemantauan
                kegiatan PKL siswa SMKS NURUL ULUM Semiring Situbondo.
            </p>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg mt-3">Masuk Sistem</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('img/pkl-illustration.svg') }}" alt="Ilustrasi PKL" class="img-fluid"
                style="max-height: 300px;">
        </div>
    </div>

    <hr class="my-5">

    <div class="row text-center">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Siswa</h5>
                    <p class="card-text">Isi jurnal harian, unggah laporan, dan pantau progres PKL-mu dengan mudah.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Pembimbing Sekolah</h5>
                    <p class="card-text">Pantau aktivitas siswa secara real-time dan beri penilaian langsung dari sistem.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Pembimbing Industri</h5>
                    <p class="card-text">Beri umpan balik langsung ke siswa PKL dan validasi kehadiran serta performa.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
