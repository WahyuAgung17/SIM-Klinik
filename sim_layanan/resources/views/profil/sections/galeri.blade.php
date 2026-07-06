<section class="py-5" id="gallery">

    <div class="container">

        <div class="text-center mb-5">
            <span class="hero-badge mb-3">
                <i class="bi bi-images"></i>
                Gallery
            </span>

            <h2 class="section-title mt-3">
                Suasana Klinik Kami
            </h2>

            <span class="pulse-rule mx-auto"></span>

            <p class="text-muted mt-2">
                Berikut beberapa fasilitas dan suasana Klinik Cakra Husada.
            </p>
        </div>

        @php

        $items = [

            [
                'image' => asset('assets/images/ruang-tunggu.png'),
                'label' => 'Ruang Tunggu'
            ],

            [
                'image' => asset('assets/images/ruang-periksa.png'),
                'label' => 'Ruang Pemeriksaan'
            ],

            [
                'image' => asset('assets/images/apotek.png'),
                'label' => 'Apotek'
            ],

            [
                'image' => asset('assets/images/tim-medis.png'),
                'label' => 'Tim Medis'
            ],

            [
                'image' => asset('assets/images/gedung-klinik.png'),
                'label' => 'Tampak Depan Klinik'
            ],

            [
                'image' => asset('assets/images/ruang-tindakan.png'),
                'label' => 'Ruang Tindakan'
            ],

        ];

        @endphp

        <div class="row g-4">

            @foreach($items as $item)

            <div class="col-lg-4 col-md-6">

                <div class="gallery-card">

                    <img
                        src="{{ $item['image'] }}"
                        alt="{{ $item['label'] }}"
                        class="gallery-image">

                    <div class="gallery-overlay">

                        <h5>{{ $item['label'] }}</h5>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>