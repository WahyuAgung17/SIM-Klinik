<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','Klinik Cakra Husada')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/public.css') }}">

</head>

<body style="background:var(--paper);">

<nav class="navbar navbar-expand-lg bg-white sticky-top public-nav">
    <div class="container-fluid px-4">

        <a href="{{ route('profil.index') }}" class="navbar-brand d-flex align-items-center">
            <i class="bi bi-hospital-fill me-2" style="font-size:26px;color:var(--pine);"></i>
            <span style="font-family:'Fraunces',serif;font-weight:700;color:var(--ink);line-height:1.1;">
                KLINIK<br>
                <span style="color:var(--pine);">CAKRA HUSADA</span>
            </span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list" style="font-size:26px;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="#beranda">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tentang">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#layanan">
                        Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#dokter">
                        Dokter
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#gallery">
                        Gallery
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#faq">
                        FAQ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#kontak">
                        Kontak
                    </a>
                </li>

            </ul>
        </div>

        <!-- <a href="#" class="btn btn-primary d-none d-lg-inline-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-in-right"></i>
            Login
        </a> -->

    </div>
</nav>

@yield('content')

<footer class="pt-5 pb-4" style="background:var(--sidebar);color:rgba(255,255,255,.75);">
    <div class="container">

        <div class="row g-4 mb-4">

            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-hospital-fill me-2" style="font-size:24px;color:var(--amber);"></i>
                    <span class="text-white fw-bold" style="font-family:'Fraunces',serif;">Klinik Cakra Husada</span>
                </div>
                <p class="small mb-0">
                    Memberikan pelayanan kesehatan yang cepat, ramah, dan profesional untuk Anda dan keluarga tercinta.
                </p>
            </div>

            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#tentang" class="text-decoration-none" style="color:rgba(255,255,255,.75);">
                            Tentang Kami
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="#layanan" class="text-decoration-none" style="color:rgba(255,255,255,.75);">
                            Layanan
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="#dokter" class="text-decoration-none" style="color:rgba(255,255,255,.75);">
                            Dokter
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="#faq" class="text-decoration-none" style="color:rgba(255,255,255,.75);">
                            FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-6">
                <h6 class="text-white fw-bold mb-3">Jam Operasional</h6>
                <p class="small mb-1">Setiap Hari</p>
                <p class="small text-mono">08.00 - 21.00 WIB</p>
            </div>

            <div class="col-lg-3">
                <h6 class="text-white fw-bold mb-3">Kontak</h6>
                <p class="small mb-1"><i class="bi bi-geo-alt me-2"></i>Surakarta, Jawa Tengah</p>
                <p class="small mb-1"><i class="bi bi-telephone me-2"></i>(0271) 123-456</p>
                <p class="small"><i class="bi bi-envelope me-2"></i>info@cakrahusada.id</p>
            </div>

        </div>

        <hr style="border-color:rgba(255,255,255,.1);">

        <p class="text-center small mb-0">
            Copyright © {{ date('Y') }} Klinik Cakra Husada — Kesehatan Anda, Prioritas Kami.
        </p>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
