    @php
$map = [
    'terdaftar' => ['label' => 'Terdaftar', 'class' => 'bg-primary'],
    'menunggu_pemeriksaan' => ['label' => 'Menunggu Periksa', 'class' => 'bg-warning'],
    'sedang_diperiksa' => ['label' => 'Sedang Diperiksa', 'class' => 'bg-warning'],
    'selesai_diperiksa' => ['label' => 'Selesai Diperiksa', 'class' => 'bg-primary'],
    'menunggu_pembayaran' => ['label' => 'Menunggu Bayar', 'class' => 'bg-danger'],
    'selesai' => ['label' => 'Selesai', 'class' => 'bg-success'],
];
$item = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-secondary'];
@endphp

<span class="badge {{ $item['class'] }}">
    {{ $item['label'] }}
</span>
