<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPKL - Sistem Informasi Praktek Kerja Lapangan</title>
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
    <!-- Login Section -->
    <section class="vh-100" style="background-color: var(--primary-color);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <img src="{{ asset('assets/img/logopklstr.png') }}" alt="Logo SMKS" height="60"
                                class="mb-4">
                            <h3 class="mb-4">Login SIPKL</h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email"
                                        class="form-control form-control-lg" placeholder="Email" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" placeholder="Password" />
                                </div>

                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input" type="checkbox" id="remember" />
                                    <label class="form-check-label ms-2" for="remember"> Remember me</label>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block w-100" type="submit">Login</button>
                            </form>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="mb-1">Belum punya akun? Hubungi Admin Sekolah</a></p>
                                <p><a href="/forgot-password" class="text-primary">Lupa password?</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer id="kontak" class="py-3">
        <div class="row">
            <p class=" text-center mb-0">© 2023 SMKS Nurul Ulum Situbondo. All rights reserved.</p>

        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
