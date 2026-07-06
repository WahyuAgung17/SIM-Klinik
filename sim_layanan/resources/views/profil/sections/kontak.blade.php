<section class="py-5" id="kontak">
    <div class="container">

        <div class="text-center mb-5">
            <span class="hero-badge mb-3">
                <i class="bi bi-telephone"></i>
                Kontak
            </span>
            <h2 class="section-title mt-3">Hubungi Kami</h2>
            <span class="pulse-rule mx-auto"></span>
        </div>

        <div class="row g-5">

            <div class="col-lg-5">

                <div class="contact-info-item">
                    <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat</h6>
                        <p class="text-muted mb-0">Jl. Slamet Riyadi No. 123, Surakarta, Jawa Tengah</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Telepon</h6>
                        <p class="text-muted mb-0 text-mono">(0271) 123-456</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0">info@cakrahusada.id</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="icon-box"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Jam Operasional</h6>
                        <p class="text-muted mb-0">Setiap Hari, 08.00 - 21.00 WIB</p>
                    </div>
                </div>

            </div>

            <div class="col-lg-7">

                <div class="card">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Kirim Pesan</h5>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('pesan-masuk.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama"
                                           class="form-control @error('nama') is-invalid @enderror"
                                           value="{{ old('nama') }}" placeholder="Nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" name="no_telp"
                                           class="form-control @error('no_telp') is-invalid @enderror"
                                           value="{{ old('no_telp') }}" placeholder="08xxxxxxxxxx">
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subjek</label>
                                <input type="text" name="subjek"
                                       class="form-control @error('subjek') is-invalid @enderror"
                                       value="{{ old('subjek') }}" placeholder="Perihal pesan Anda">
                                @error('subjek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pesan</label>
                                <textarea name="pesan" rows="4"
                                          class="form-control @error('pesan') is-invalid @enderror"
                                          placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i>
                                Kirim Pesan
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>


