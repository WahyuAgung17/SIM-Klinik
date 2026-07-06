<section class="hero-section">
    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <span class="hero-badge mb-3">
                    <i class="bi bi-shield-check"></i>
                    Klinik Terakreditasi & Terpercaya
                </span>

                <h1 class="hero-title mt-3 mb-3">
                    Kesehatan Anda<br>
                    <span class="accent">Prioritas Kami</span>
                </h1>

                <p class="text-muted mb-4" style="font-size:16px;max-width:480px;">
                    Klinik Cakra Husada memberikan pelayanan kesehatan yang cepat, ramah, dan
                    profesional untuk Anda dan keluarga tercinta.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">

                    <a href="{{ route('profil.pendaftaran.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-calendar-check"></i>
                        Daftar Berobat
                    </a>

                    <a href="#kontak"
                    class="btn btn-lg"
                    style="border:1.5px solid var(--pine);color:var(--pine);background:#fff;">
                        <i class="bi bi-telephone"></i>
                        Hubungi Kami
                    </a>

                </div>

                <div class="d-flex align-items-center gap-3">

                    <div class="avatar-stack d-flex">
                        <img src="https://marketplace.canva.com/z3nJ8/MAEWf5z3nJ8/1/tl/canva-happy-young-man-posing-for-headshot-portrait-profile-picture-indoors-MAEWf5z3nJ8.jpg">
                        <img src="https://i.pinimg.com/originals/25/f6/6e/25f66e08ee01e563086bb5723b40ae1b.jpg">
                        <img src="https://storyblok-cdn.photoroom.com/f/191576/1200x800/a3640fdc4c/profile_picture_maker_before.webp">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.A-HhNctiR069rI4cvhTB-QAAAA?pid=Api&h=220&P=0">
                    </div>

                    <div>
                        <div style="color:var(--gold);">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <small class="text-muted">Dipercaya lebih dari 15.000+ pasien</small>
                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="hero-visual">

                <img
                    src="{{ asset('assets/images/gedung-klinik.png') }}"
                    class="hero-building"
                    alt="Gedung Klinik">

                <div class="floating-card card-top-left">
                    <div class="icon-box" style="background:#E8F7ED;color:#2E8B57;">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <strong>Buka Setiap Hari</strong>
                        <small>08.00 - 21.00 WIB</small>
                    </div>
                </div>

                <div class="floating-card card-left">
                    <div class="icon-box" style="background:#E8F1FF;color:#0d6efd;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <strong>Dokter Profesional</strong>
                        <small>Berpengalaman & Ramah</small>
                    </div>
                </div>

                <div class="floating-card card-right">
                    <div class="icon-box" style="background:#F4EBFF;color:#8B3DFF;">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <div>
                        <strong>Apotek Lengkap</strong>
                        <small>Obat Berkualitas</small>
                    </div>
                </div>

                <div class="floating-card card-bottom-right">
                    <div class="icon-box" style="background:#FFF4DF;color:#F39C12;">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <div>
                        <strong>Pelayanan Cepat</strong>
                        <small>Tanpa Antri Lama</small>
                    </div>
                </div>

            </div>

        </div>

        <div class="stats-bar">
            <div class="row text-center g-4">

                <div class="col-md-3 col-6">
                    <div class="stat-icon" style="background:var(--pine-soft);color:var(--pine);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3>15.247+</h3>
                    <span class="text-muted small">Pasien Terdaftar</span>
                    <div class="stat-underline" style="background:var(--pine);"></div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-icon" style="background:var(--leaf-soft);color:var(--leaf);">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h3>15+</h3>
                    <span class="text-muted small">Dokter Profesional</span>
                    <div class="stat-underline" style="background:var(--leaf);"></div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-icon" style="background:#EEE7F7;color:#7B4FA6;">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                    </div>
                    <h3>6+</h3>
                    <span class="text-muted small">Poli Layanan</span>
                    <div class="stat-underline" style="background:#7B4FA6;"></div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-icon" style="background:var(--amber-soft);color:var(--amber);">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h3>20+</h3>
                    <span class="text-muted small">Layanan Kesehatan</span>
                    <div class="stat-underline" style="background:var(--amber);"></div>
                </div>

            </div>
        </div>

    </div>
</section>

<section class="py-5 mt-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Poli yang Tersedia</h2>
            <span class="pulse-rule mx-auto"></span>
        </div>

        <div class="row g-4">

            @forelse($poli as $item)

                <div class="col-md-4">
                    <div class="card soft-card h-100">
                        <div class="card-body">
                            <i class="bi bi-hospital-fill mb-3" style="font-size:32px;color:var(--pine);"></i>
                            <h5 class="fw-bold">{{ $item->nama_poli }}</h5>
                            <p class="text-muted mb-0">
                                {{ $item->deskripsi ?: 'Layanan pemeriksaan kesehatan.' }}
                            </p>
                        </div>
                    </div>
                </div>

            @empty

                <div class="col-12">
                    <p class="text-center text-muted">Belum ada data poli.</p>
                </div>

            @endforelse

        </div>

    </div>
</section>