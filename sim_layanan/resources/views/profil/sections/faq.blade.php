
<section class="py-5">
    <div class="container" style="max-width:800px;">

        <div class="text-center mb-5">
            <span class="hero-badge mb-3">
                <i class="bi bi-question-circle"></i>
                FAQ
            </span>
            <h2 class="section-title mt-3">Pertanyaan yang Sering Diajukan</h2>
            <span class="pulse-rule mx-auto"></span>
        </div>

        <div class="accordion" id="faqAccordion">

            @php
                $faqs = [
                    ['q' => 'Apakah saya perlu membuat janji temu sebelum berobat?', 'a' => 'Tidak wajib, namun disarankan untuk mendaftar terlebih dahulu melalui menu Daftar Berobat agar waktu tunggu Anda lebih singkat.'],
                    ['q' => 'Apa saja jam operasional klinik?', 'a' => 'Klinik Cakra Husada buka setiap hari, termasuk akhir pekan, mulai pukul 08.00 hingga 21.00 WIB.'],
                    ['q' => 'Apakah klinik menerima BPJS Kesehatan?', 'a' => 'Saat ini sistem pendaftaran kami melayani pembayaran mandiri. Untuk informasi kerja sama BPJS, silakan hubungi bagian informasi kami.'],
                    ['q' => 'Bagaimana cara melihat hasil pemeriksaan?', 'a' => 'Hasil pemeriksaan dan resep dapat dilihat langsung oleh dokter yang menangani, dan ringkasannya akan disampaikan saat konsultasi.'],
                    ['q' => 'Apakah tersedia layanan konsultasi untuk anak-anak?', 'a' => 'Ya, kami memiliki Poli Anak dengan dokter yang berpengalaman menangani pasien usia anak.'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)

                <div class="accordion-item mb-3" style="border-radius:14px;overflow:hidden;border:1px solid rgba(20,35,31,.08);">

                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq{{ $index }}">
                            {{ $faq['q'] }}
                        </button>
                    </h2>

                    <div id="faq{{ $index }}"
                         class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            {{ $faq['a'] }}
                        </div>
                    </div>

                </div>

            @endforeach

        </div>

    </div>
</section>


