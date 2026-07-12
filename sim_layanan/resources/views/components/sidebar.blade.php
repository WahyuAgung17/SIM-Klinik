<div class="d-flex flex-column h-100">

    <!-- Logo -->
    <div class="text-center py-4 border-bottom border-secondary border-opacity-25">

        <div class="mb-2">
            <i class="bi bi-activity" style="font-size:38px;color:#E2843D;"></i>
        </div>

        <h4 class="text-white mb-0" style="font-family:'Fraunces',serif;font-weight:600;">
            SIM Klinik
        </h4>

        <small class="text-white-50" style="letter-spacing:.04em;">
            Sistem Layanan Terpadu
        </small>

    </div>

    <!-- Menu -->
    <div class="flex-grow-1 p-3">

        <small class="text-white-50 text-uppercase fw-bold" style="letter-spacing:.06em;">
            Ringkasan
        </small>

        <ul class="nav flex-column mt-2 mb-4">

            <li class="nav-item">

                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <i class="bi bi-grid-fill me-2"></i>

                    Dashboard

                </a>

            </li>

        </ul>

        <small class="text-white-50 text-uppercase fw-bold" style="letter-spacing:.06em;">
            Master Data
        </small>

        <ul class="nav flex-column mt-2 mb-4">

            <li>

                <a href="{{ route('poli.index') }}"
                   class="sidebar-link {{ request()->is('poli*') ? 'active' : '' }}">

                    <i class="bi bi-hospital me-2"></i>

                    Data Poli

                </a>

            </li>

            <li>

                <a href="{{ route('layanan.index') }}"
                   class="sidebar-link {{ request()->is('layanan*') ? 'active' : '' }}">

                    <i class="bi bi-clipboard2-pulse me-2"></i>

                    Data Layanan

                </a>

            </li>

        </ul>

        <small class="text-white-50 text-uppercase fw-bold" style="letter-spacing:.06em;">
            Pelayanan
        </small>

        <ul class="nav flex-column mt-2 mb-4">

            <li>

                <a href="{{ route('kunjungan.index') }}"
                   class="sidebar-link {{ request()->is('kunjungan*') ? 'active' : '' }}">

                    <i class="bi bi-person-lines-fill me-2"></i>

                    Kunjungan

                </a>

            </li>

            <li>

                <a href="{{ route('pemeriksaan.index') }}"
                   class="sidebar-link {{ request()->is('pemeriksaan*') ? 'active' : '' }}">

                    <i class="bi bi-heart-pulse me-2"></i>

                    Pemeriksaan

                </a>

            </li>

        </ul>

        <small class="text-white-50 text-uppercase fw-bold" style="letter-spacing:.06em;">
            Website
        </small>

        <ul class="nav flex-column mt-2">

            <li>

                <a href="{{ route('profil.index') }}"
                   class="sidebar-link {{ request()->is('profil*') ? 'active' : '' }}">

                    <i class="bi bi-globe me-2"></i>

                    Company Profile

                </a>

            </li>

            <li>

                <a href="{{ route('pesan-masuk.index') }}"
                   class="sidebar-link {{ request()->is('pesan-masuk*') ? 'active' : '' }}">

                    <i class="bi bi-envelope-fill me-2"></i>

                    Pesan Masuk

                    @php
                        $totalBelumDibaca = \App\Models\PesanMasuk::belumDibaca()->count();
                    @endphp

                    @if($totalBelumDibaca > 0)
                        <span class="badge bg-danger rounded-pill ms-1">{{ $totalBelumDibaca }}</span>
                    @endif

                </a>

            </li>

        </ul>

    </div>

    <!-- Footer Sidebar -->
    <div class="p-3 border-top border-secondary border-opacity-25 text-center">

        <small class="text-white-50">
            SIM Klinik v1.0
        </small>

    </div>

</div>
