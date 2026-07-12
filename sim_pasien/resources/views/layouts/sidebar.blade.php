<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">

        <img src="{{ asset('images/logo.png') }}"
             class="brand-image img-circle elevation-3"
             style="opacity:.8">

        <span class="brand-text font-weight-light">

            SIM KLINIK

        </span>

    </a>

    <div class="sidebar">

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu">

                <li class="nav-item">

                    <a href="{{ url('/patient/dashboard') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-home"></i>

                        <p>Dashboard</p>

                    </a>

                </li>

                <li class="nav-header">

                    MASTER DATA

                </li>

                <li class="nav-item">

                    <a href="{{ route('patient.patients.index') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-users"></i>

                        <p>Data Pasien</p>

                    </a>

                </li>

                <li class="nav-header">

                    REGISTRASI

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon fas fa-notes-medical"></i>

                        <p>Registrasi Pasien</p>

                    </a>

                </li>

                <li class="nav-header">

                    RIWAYAT

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon fas fa-history"></i>

                        <p>Riwayat Kunjungan</p>

                    </a>

                </li>

                <li class="nav-header">

                    DOKUMEN

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon fas fa-folder-open"></i>

                        <p>Dokumen Pasien</p>

                    </a>

                </li>

                <li class="nav-header">

                    KONTROL

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon fas fa-calendar-check"></i>

                        <p>Jadwal Kontrol</p>

                    </a>

                </li>

                <li class="nav-header">

                    PENGATURAN

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon fas fa-cogs"></i>

                        <p>Pengaturan</p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>