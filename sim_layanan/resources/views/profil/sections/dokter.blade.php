<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <span class="hero-badge mb-3">
                <i class="bi bi-person-badge"></i>
                Tim Medis Kami
            </span>
            <h2 class="section-title mt-3">Dokter Profesional & Berpengalaman</h2>
            <span class="pulse-rule mx-auto"></span>
        </div>

        <div class="row g-4">

            @forelse($dokter as $item)

                <div class="col-md-4 col-sm-6">
                    <div class="card soft-card h-100 text-center">
                        <div class="card-body">

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}&background=1F6F5C&color=fff&size=128"
                                class="rounded-circle m`b-3"
                                width="90"
                                height="90">

                            <h6 class="fw-bold mb-1">{{ $item->nama }}</h6>

                            <span class="badge bg-primary mb-2">{{ $item->spesialisasi }}</span>

                            <p class="text-muted small mb-0">
                                <i class="bi bi-patch-check"></i>
                                {{ $item->no_str ?? 'STR Terverifikasi' }}
                            </p>

                        </div>
                    </div>
                </div>

            @empty

                <div class="col-12">
                    <x-ui.empty-state
                        title="Belum ada data dokter"
                        subtitle="Data dokter akan tampil di sini setelah ditambahkan."
                    />
                </div>

            @endforelse

        </div>

    </div>
</section>

