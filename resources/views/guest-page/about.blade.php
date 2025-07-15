@extends('layouts.guest')

@section('title', 'Tentang SIPKL')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-success">Tentang Sistem SIPKL</h2>
            <p class="lead">
                <strong>SIPKL (Sistem Informasi Praktik Kerja Lapangan)</strong> adalah platform digital berbasis web yang
                dikembangkan untuk mendukung proses administrasi PKL di SMKS NURUL ULUM Semiring Situbondo.
            </p>

            <div class="mt-4">
                <h4 class="text-success">🎯 Tujuan</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✅ Mempermudah pencatatan kegiatan harian siswa selama PKL</li>
                    <li class="list-group-item">✅ Memberikan akses real-time kepada guru pembimbing untuk melakukan
                        monitoring</li>
                    <li class="list-group-item">✅ Meningkatkan efisiensi pengelolaan data PKL dan pembuatan sertifikat</li>
                </ul>
            </div>

            <div class="mt-4">
                <h4 class="text-success">⚙️ Fitur Utama</h4>
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            <li><strong>Dashboard Siswa</strong> – Laporan kegiatan harian, upload dokumentasi</li>
                            <li><strong>Penilaian Digital</strong> – Evaluasi langsung oleh pembimbing sekolah</li>
                            <li><strong>Cetak Sertifikat</strong> – Otomatisasi dokumen akhir kegiatan</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><strong>Pembimbing Industri</strong> – Konfirmasi kehadiran & performa siswa</li>
                            <li><strong>Notifikasi</strong> – Pengingat jadwal & validasi</li>
                            <li><strong>Manajemen Akun</strong> – Multi-role untuk siswa, guru, dan DU/DI</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="alert alert-success mt-5" role="alert">
                SIPKL dikembangkan sebagai bagian dari komitmen sekolah dalam menerapkan transformasi digital dan
                meningkatkan kualitas lulusan yang siap kerja. 🌱
            </div>
        </div>
    </div>
@endsection
