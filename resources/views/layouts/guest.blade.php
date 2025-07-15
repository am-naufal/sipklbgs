<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPKL - Sistem Informasi Praktek Kerja Lapangan</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logopkl.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #004910;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url("{{ asset('assets/img/hero.jpg') }}") no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .testimonial-card {
            border-left: 4px solid var(--primary-color);
        }

        footer {
            background-color: var(--secondary-color);
            color: white;
        }

        .social-icon {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .social-icon:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/logopklstr.png') }}" alt="Logo SMKS Nurul Ulum" height="35"
                    class="me-2">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>

                    @guest
                        <li class="">
                            <a class="btn btn-outline-light ms-2" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                    @auth
                        @php $role = auth()->user()->role; @endphp
                        @if ($role === 'admin')
                            <a class="btn btn-outline-light ms-2" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        @elseif($role === 'siswa')
                            <a class="btn btn-outline-light ms-2" href="{{ route('siswa.dashboard') }}">Dashboard Siswa</a>
                        @elseif($role === 'pembimbing')
                            <a class="btn btn-outline-light ms-2" href="{{ route('pembimbing.dashboard') }}">Dashboard
                                Pembimbing</a>
                        @elseif($role === 'kepala_sekolah')
                            <a class="btn btn-outline-light ms-2" href="{{ route('kepala-sekolah.dashboard') }}">Dashboard
                                Kepala Sekolah</a>
                        @elseif($role === 'industri')
                            <a class="btn btn-outline-light ms-2" href="{{ route('industri.dashboard') }}">Dashboard
                                Industri</a>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section mt-5">
        <div class="container text-center py-5">
            <span class="h2 text-white">Selamat Datang di </span>
            <h1 class="display-4 fw-bold mb-3">Sistem Informasi PKL</h1>
            <p class="lead mb-4">Aplikasi digital SMKS Nurul Ulum Situbondo untuk memudahkan proses Praktek Kerja
                Lapangan siswa</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-2">Mulai Sekarang</a>
            <a href="#fitur" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Unggulan SIPKL</h2>
                <p class="text-muted">Berbagai kemudahan dalam satu platform</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h5 class="card-title">Pendataan Online</h5>
                            <p class="card-text text-muted">Proses pendataan PKL yang mudah dan cepat secara online
                                tanpa ribet.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title">Monitoring Progress</h5>
                            <p class="card-text text-muted">Pantau perkembangan PKL mahasiswa secara real-time dari mana
                                saja.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="card-title">Laporan Digital</h5>
                            <p class="card-text text-muted">Upload dan kelola laporan PKL secara digital dengan sistem
                                terpusat.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="card-title">Sistem Penilaian</h5>
                            <p class="card-text text-muted">Penilaian terstruktur oleh pembimbing dan perusahaan mitra.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('assets/img/dashboard-sipkl.png') }}"
                        alt="Dashboard SIPKL menunjukkan antarmuka pengguna modern dengan grafik dan statistik PKL"
                        class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Bagaimana SIPKL Bekerja?</h2>
                    <div class="d-flex mb-3">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                1
                            </div>
                        </div>
                        <div>
                            <h5>Registrasi Akun</h5>
                            <p class="text-muted">Siswa mendaftar menggunakan NIS dan email sekolah.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                2
                            </div>
                        </div>
                        <div>
                            <h5>Pengajuan PKL</h5>
                            <p class="text-muted">Ajukan tempat PKL dan upload dokumen persyaratan.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                3
                            </div>
                        </div>
                        <div>
                            <h5>Persetujuan Pembimbing</h5>
                            <p class="text-muted">Pembimbing menyetujui tempat PKL yang diajukan.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                4
                            </div>
                        </div>
                        <div>
                            <h5>Monitoring & Penilaian</h5>
                            <p class="text-muted">Pantau progress dan berikan penilaian selama PKL berlangsung.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Siap Memulai PKL dengan Lebih Mudah?</h2>
            <p class="lead mb-4">Gunakan sistem ini untuk pkl terintegrasi yang lebih baik
            </p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-2">Selesaikan Laporanmu Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-briefcase me-2"></i>SIPKL
                    </h5>
                    <p class=" ">Sistem Informasi Praktek Kerja Lapangan terintegrasi untuk memudahkan proses
                        PKL Siswa, pembimbing, dan mitra industri.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white  text-decoration-none">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="#fitur" class="text-white  text-decoration-none">Fitur</a></li>
                        <li class="mb-2"><a href="#testimoni"
                                class="text-white  text-decoration-none">Testimoni</a>
                        </li>
                        <li class="mb-2"><a href="#" class=" text-white text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="#" class=" text-white text-decoration-none">Kebijakan
                                Privasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Kontak Kami</h5>
                    <ul class="list-unstyled  ">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Desa Semiring, Kec.
                            Mangaran, Kabupaten Situbondo, Jawa Timur 68363</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> (0338) 123456</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> pkl@smksnurululum.sch.id
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 text-white">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p class="">Dapatkan informasi terbaru tentang SIPKL</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email Anda">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="  mb-0">© 2023 SMKS Nurul Ulum Situbondo. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Change navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
        });
    </script>
</body>

</html>
