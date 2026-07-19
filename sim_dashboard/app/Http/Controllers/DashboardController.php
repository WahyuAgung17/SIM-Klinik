<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ================================================================
        // 1. STAT CARD ATAS: Jumlah Pasien, Dokter Aktif, Kunjungan HARI INI
        // ================================================================
        $totalPasien = DB::connection('pasien')->table('pasien')->count();

        $dokterAktif = DB::connection('pegawai')->table('dokter')
            ->where('status', 'aktif')
            ->count();

        $kunjunganHariIni = DB::connection('klinik')->table('kunjungan')
            ->whereDate('tanggal_kunjungan', $now->toDateString())
            ->count();

        // ================================================================
        // 2. ANALISIS PENDAPATAN & TREN KUNJUNGAN
        // ================================================================
        $revenue = $this->hitungSemuaPendapatan($now);
        $kunjunganTren = $this->hitungSemuaKunjungan($now);

        // ================================================================
        // 3. DONUT: distribusi kunjungan per shift waktu
        // ================================================================
        $shift = DB::connection('klinik')->table('kunjungan')
            ->select(DB::raw("
                SUM(CASE WHEN HOUR(tanggal_kunjungan) >= 7 AND HOUR(tanggal_kunjungan) < 14 THEN 1 ELSE 0 END) as pagi,
                SUM(CASE WHEN HOUR(tanggal_kunjungan) >= 14 AND HOUR(tanggal_kunjungan) < 22 THEN 1 ELSE 0 END) as siang,
                SUM(CASE WHEN HOUR(tanggal_kunjungan) >= 22 OR HOUR(tanggal_kunjungan) < 7 THEN 1 ELSE 0 END) as malam,
                COUNT(*) as total
            "))
            ->first();

        $totalShift = max((int) $shift->total, 1);
        $donutPersen = [
            'pagi'  => round(($shift->pagi  / $totalShift) * 100),
            'siang' => round(($shift->siang / $totalShift) * 100),
            'malam' => round(($shift->malam / $totalShift) * 100),
        ];

        // ================================================================
        // 4. TOP 5 CHART 
        // ================================================================
        $topLayanan = DB::connection('klinik')->table('detail_pemeriksaan_layanan as d')
            ->join('layanan as l', 'l.id', '=', 'd.layanan_id')
            ->select('l.nama_layanan', DB::raw('SUM(d.jumlah) as total'))
            ->groupBy('l.nama_layanan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $topLayananLabels = $topLayanan->pluck('nama_layanan');
        $topLayananValues = $topLayanan->pluck('total');

        $topPoli = DB::connection('klinik')->table('kunjungan as k')
            ->join('poli as p', 'p.id', '=', 'k.poli_id')
            ->select('p.nama_poli', DB::raw('COUNT(*) as total'))
            ->groupBy('p.nama_poli')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $topPoliLabels = $topPoli->pluck('nama_poli');
        $topPoliValues = $topPoli->pluck('total');

        $topKeluhan = DB::connection('klinik')->table('kunjungan')
            ->whereNotNull('keluhan')
            ->where('keluhan', '!=', '')
            ->select('keluhan', DB::raw('COUNT(*) as total'))
            ->groupBy('keluhan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $topKeluhanLabels = $topKeluhan->pluck('keluhan');
        $topKeluhanValues = $topKeluhan->pluck('total');

        $topDiagnosa = DB::connection('klinik')->table('pemeriksaan')
            ->whereNotNull('diagnosa')
            ->where('diagnosa', '!=', '')
            ->select('diagnosa', DB::raw('COUNT(*) as total'))
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $topDiagnosaLabels = $topDiagnosa->pluck('diagnosa');
        $topDiagnosaValues = $topDiagnosa->pluck('total');

        // ================================================================
        // 5. DATA UNTUK 2 TABEL DI HALAMAN "INFORMASI" (DIUBAH MENJADI HINGGA 100 DATA AGAR BISA DIPAGINATION JS)
        // ================================================================

        // A. Kunjungan Terbaru
        $kolomStatusKunjungan = $this->kolomStatusKunjungan();
        $selectKunjungan = ['k.pasien_id', 'k.dokter_id', 'k.tanggal_kunjungan', 'p.nama_poli', 'pm.id as pemeriksaan_id', 'pm.diagnosa'];
        if ($kolomStatusKunjungan) {
            $selectKunjungan[] = DB::raw("{$kolomStatusKunjungan} as status_kunjungan_terdeteksi");
        }

        $kunjunganTerbaruRaw = DB::connection('klinik')->table('kunjungan as k')
            ->leftJoin('poli as p', 'p.id', '=', 'k.poli_id')
            ->leftJoin('pemeriksaan as pm', 'pm.kunjungan_id', '=', 'k.id')
            ->select($selectKunjungan)
            ->orderByDesc('k.tanggal_kunjungan')
            ->limit(100) // Diperbanyak untuk demo kelancaran pagination tombol kanan-kiri
            ->get();

        // B. Pembayaran Terbaru - Join Lintas DB untuk mendapatkan Nama Layanan Asli dari Detail Pemeriksaan
        $pembayaranTerbaruRaw = DB::connection('tagihan')->table('tagihan as t')
            ->join('tim_klinik.kunjungan as k', 'k.id', '=', 't.kunjungan_id')
            ->leftJoin('tim_klinik.pemeriksaan as pm', 'pm.kunjungan_id', '=', 'k.id')
            ->leftJoin('tim_klinik.detail_pemeriksaan_layanan as dpl', 'dpl.pemeriksaan_id', '=', 'pm.id')
            ->leftJoin('tim_klinik.layanan as l', 'l.id', '=', 'dpl.layanan_id')
            ->select([
                'k.pasien_id',
                't.tanggal_tagihan',
                't.total_tagihan as total_bayar',
                't.status_pembayaran as status_bayar_terdeteksi',
                'l.nama_layanan' // Diambil langsung dinamis dari database klinik
            ])
            ->orderByDesc('t.tanggal_tagihan')
            ->limit(100)
            ->get();

        // C. Ambil Data Pasien & Dokter lintas DB
        $pasienIds = collect($kunjunganTerbaruRaw->pluck('pasien_id'))
            ->merge($pembayaranTerbaruRaw->pluck('pasien_id'))
            ->unique();

        $dokterIds = $kunjunganTerbaruRaw->pluck('dokter_id')->unique();

        $listPasien = DB::connection('pasien')->table('pasien')
            ->whereIn('id', $pasienIds)
            ->get()
            ->keyBy('id');

        $listDokter = DB::connection('pegawai')->table('dokter')
            ->whereIn('id', $dokterIds)
            ->get()
            ->keyBy('id');

        // D. Map data Kunjungan (MEMPERBAIKI PEMANGGILAN nama_dokter DAN status)
        $kunjunganTerbaru = $kunjunganTerbaruRaw->map(function ($item) use ($listPasien, $listDokter) {
            $pasien = $listPasien->get($item->pasien_id);
            $dokter = $listDokter->get($item->dokter_id);
            
            // Cek status kunjungan, jika kosong set default aman 'Selesai'
            $statusKunjungan = $item->status_kunjungan_terdeteksi ?? 'Selesai';

            return [
                'nama_pasien' => $pasien->nama ?? 'Pasien Umum',
                'no_telp'     => $pasien->no_telp ?? '-',
                'tanggal'     => Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y'),
                'poli'        => $item->nama_poli ?? '-',
                'diagnosa'    => $item->diagnosa ?? 'Pemeriksaan Umum',
                'nama_dokter' => $dokter->nama_dokter ?? 'Dokter Klinik', // DIPERBAIKI: sebelumnya ->nama
                'status'      => $statusKunjungan,
            ];
        });

        // E. Map data Pembayaran (MEMPERBAIKI JENIS LAYANAN DINAMIS)
        $pembayaranTerbaru = $pembayaranTerbaruRaw->map(function ($item) use ($listPasien) {
            $pasien = $listPasien->get($item->pasien_id);
            return [
                'nama_pasien'       => $pasien->nama ?? 'Pasien Umum',
                'no_telp'           => $pasien->no_telp ?? '-',
                'tanggal'           => Carbon::parse($item->tanggal_tagihan)->format('d-m-Y'),
                'jenis_layanan'     => $item->nama_layanan ?? 'Pemeriksaan Klinik', // DIPERBAIKI: Mengambil nama layanan asli
                'total_bayar'       => $item->total_bayar,
                'status_pembayaran' => $item->status_bayar_terdeteksi ?? 'Belum Dibayar',
            ];
        });

        return view('dashboard', compact(
            'totalPasien',
            'dokterAktif',
            'kunjunganHariIni',
            'revenue',
            'kunjunganTren',
            'donutPersen',
            'topLayananLabels',
            'topLayananValues',
            'topPoliLabels',
            'topPoliValues',
            'topKeluhanLabels',
            'topKeluhanValues',
            'topDiagnosaLabels',
            'topDiagnosaValues',
            'kunjunganTerbaru',
            'pembayaranTerbaru'
        ));
    }

    private function kolomStatusKunjungan(): ?string
    {
        if (Schema::connection('klinik')->hasColumn('kunjungan', 'status_kunjungan')) {
            return 'k.status_kunjungan';
        }
        if (Schema::connection('klinik')->hasColumn('kunjungan', 'status')) {
            return 'k.status';
        }
        if (Schema::connection('klinik')->hasColumn('pemeriksaan', 'status')) {
            return 'pm.status';
        }
        return null;
    }

    private function hitungSemuaPendapatan(Carbon $now): array
    {
        return [
            'week'  => $this->pendapatanMingguIni($now),
            'month' => $this->pendapatanBulanIni($now),
            'year'  => $this->pendapatanTahunIni($now),
        ];
    }

    private function baseRevenueQuery()
    {
        return DB::connection('tagihan')->table('tagihan')
            ->where('status_pembayaran', 'Berhasil Dibayar');
    }

    private function totalRevenueBetween(Carbon $start, Carbon $end): float
    {
        return (float) $this->baseRevenueQuery()
            ->whereBetween('tanggal_tagihan', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->sum('total_tagihan');
    }

    private function pendapatanMingguIni(Carbon $now): array
    {
        $awalMinggu = $now->copy()->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = $now->copy()->endOfWeek(Carbon::SUNDAY);

        $rows = $this->baseRevenueQuery()
            ->whereBetween('tanggal_tagihan', [$awalMinggu, $akhirMinggu])
            ->select(DB::raw('DAYOFWEEK(tanggal_tagihan) as hari_ke'), DB::raw('SUM(total_tagihan) as total'))
            ->groupBy('hari_ke')
            ->get()
            ->keyBy('hari_ke');

        $urutan = [2 => 'Sen', 3 => 'Sel', 4 => 'Rab', 5 => 'Kam', 6 => 'Jum', 7 => 'Sab', 1 => 'Min'];
        $labels = [];
        $values = [];
        foreach ($urutan as $kode => $label) {
            $labels[] = $label;
            $values[] = round((float) ($rows[$kode]->total ?? 0) / 1000000, 2);
        }

        $totalMingguIni = array_sum($values) * 1000000;
        $totalMingguLalu = $this->totalRevenueBetween($awalMinggu->copy()->subWeek(), $akhirMinggu->copy()->subWeek());

        return $this->bungkusHasil($labels, $values, $totalMingguIni, $totalMingguLalu, 'hari', 7);
    }

    private function pendapatanBulanIni(Carbon $now): array
    {
        $bulanIni = $now->month;
        $tahunIni = $now->year;

        $rows = $this->baseRevenueQuery()
            ->whereMonth('tanggal_tagihan', $bulanIni)
            ->whereYear('tanggal_tagihan', $tahunIni)
            ->select(
                DB::raw('FLOOR((DAYOFMONTH(tanggal_tagihan) - 1) / 7) + 1 as minggu_ke'),
                DB::raw('SUM(total_tagihan) as total')
            )
            ->groupBy('minggu_ke')
            ->orderBy('minggu_ke')
            ->get();

        $labels = $rows->map(fn ($row) => 'Minggu ' . $row->minggu_ke)->values()->all();
        $values = $rows->map(fn ($row) => round($row->total / 1000000, 2))->values()->all();

        $totalBulanIni = (float) $rows->sum('total');
        $bulanLalu = $now->copy()->subMonth();
        $totalBulanLalu = $this->totalRevenueBetween($bulanLalu->copy()->startOfMonth(), $bulanLalu->copy()->endOfMonth());

        return $this->bungkusHasil($labels, $values, $totalBulanIni, $totalBulanLalu, 'minggu', max(count($values), 1));
    }

    private function pendapatanTahunIni(Carbon $now): array
    {
        $tahunIni = $now->year;
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $rows = $this->baseRevenueQuery()
            ->whereYear('tanggal_tagihan', $tahunIni)
            ->select(DB::raw('MONTH(tanggal_tagihan) as bulan_ke'), DB::raw('SUM(total_tagihan) as total'))
            ->groupBy('bulan_ke')
            ->get()
            ->keyBy('bulan_ke');

        $labels = [];
        $values = [];
        foreach ($namaBulan as $i => $nama) {
            $bulanKe = $i + 1;
            $labels[] = $nama;
            $values[] = round((float) ($rows[$bulanKe]->total ?? 0) / 1000000, 2);
        }

        $totalTahunIni = array_sum($values) * 1000000;
        $totalTahunLalu = $this->totalRevenueBetween(
            Carbon::create($tahunIni - 1, 1, 1),
            Carbon::create($tahunIni - 1, 12, 31)
        );

        return $this->bungkusHasil($labels, $values, $totalTahunIni, $totalTahunLalu, 'bulan', 12);
    }

    private function bungkusHasil(array $labels, array $values, float $totalSekarang, float $totalSebelumnya, string $satuanRataRata, int $jumlahBucket): array
    {
        $rataRata = $totalSekarang / max($jumlahBucket, 1);
        $growth = $totalSebelumnya > 0 ? round((($totalSekarang - $totalSebelumnya) / $totalSebelumnya) * 100, 1) : ($totalSekarang > 0 ? 100.0 : 0.0);

        return [
            'labels' => $labels,
            'values' => $values,
            'total' => $totalSekarang,
            'growth' => $growth,
            'avg' => $rataRata,
            'total_formatted' => $this->formatRupiahJuta($totalSekarang),
            'growth_formatted' => $this->formatGrowth($growth),
            'avg_formatted' => $this->formatRupiahJuta($rataRata) . '/' . $satuanRataRata,
        ];
    }

    private function formatRupiahJuta(float $rupiah): string
    {
        $juta = $rupiah / 1000000;
        if (abs($juta) >= 1000) {
            return 'Rp ' . number_format($juta / 1000, 2, ',', '.') . ' M';
        }
        if ($juta != 0 && abs($juta) < 1) {
            return 'Rp ' . number_format($rupiah / 1000, 0, ',', '.') . ' rb';
        }
        return 'Rp ' . number_format($juta, 1, ',', '.') . ' Jt';
    }

    private function formatGrowth(float $persen): string
    {
        $tanda = $persen >= 0 ? '+' : '';
        return $tanda . number_format($persen, 1, ',', '.') . '%';
    }

    private function hitungSemuaKunjungan(Carbon $now): array
    {
        return [
            'week'  => $this->kunjunganMingguIni($now),
            'month' => $this->kunjunganBulanIniTren($now),
            'year'  => $this->kunjunganTahunIniTren($now),
        ];
    }

    private function baseKunjunganQuery()
    {
        return DB::connection('klinik')->table('kunjungan');
    }

    private function totalKunjunganBetween(Carbon $start, Carbon $end): int
    {
        return (int) $this->baseKunjunganQuery()
            ->whereBetween('tanggal_kunjungan', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->count();
    }

    private function kunjunganMingguIni(Carbon $now): array
    {
        $awalMinggu = $now->copy()->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = $now->copy()->endOfWeek(Carbon::SUNDAY);

        $rows = $this->baseKunjunganQuery()
            ->whereBetween('tanggal_kunjungan', [$awalMinggu, $akhirMinggu])
            ->select(DB::raw('DAYOFWEEK(tanggal_kunjungan) as hari_ke'), DB::raw('COUNT(*) as total'))
            ->groupBy('hari_ke')
            ->get()
            ->keyBy('hari_ke');

        $urutan = [2 => 'Sen', 3 => 'Sel', 4 => 'Rab', 5 => 'Kam', 6 => 'Jum', 7 => 'Sab', 1 => 'Min'];
        $labels = [];
        $values = [];
        foreach ($urutan as $kode => $label) {
            $labels[] = $label;
            $values[] = (int) ($rows[$kode]->total ?? 0);
        }

        $totalMingguIni = array_sum($values);
        $totalMingguLalu = $this->totalKunjunganBetween($awalMinggu->copy()->subWeek(), $akhirMinggu->copy()->subWeek());

        return $this->bungkusHasilKunjungan($labels, $values, $totalMingguIni, $totalMingguLalu, 'hari', 7);
    }

    private function kunjunganBulanIniTren(Carbon $now): array
    {
        $bulanIni = $now->month;
        $tahunIni = $now->year;

        $rows = $this->baseKunjunganQuery()
            ->whereMonth('tanggal_kunjungan', $bulanIni)
            ->whereYear('tanggal_kunjungan', $tahunIni)
            ->select(
                DB::raw('FLOOR((DAYOFMONTH(tanggal_kunjungan) - 1) / 7) + 1 as minggu_ke'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('minggu_ke')
            ->orderBy('minggu_ke')
            ->get();

        $labels = $rows->map(fn ($row) => 'Minggu ' . $row->minggu_ke)->values()->all();
        $values = $rows->map(fn ($row) => (int) $row->total)->values()->all();

        $totalBulanIni = (int) $rows->sum('total');
        $bulanLalu = $now->copy()->subMonth();
        $totalBulanLalu = $this->totalKunjunganBetween($bulanLalu->copy()->startOfMonth(), $bulanLalu->copy()->endOfMonth());

        return $this->bungkusHasilKunjungan($labels, $values, $totalBulanIni, $totalBulanLalu, 'minggu', max(count($values), 1));
    }

    private function kunjunganTahunIniTren(Carbon $now): array
    {
        $tahunIni = $now->year;
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $rows = $this->baseKunjunganQuery()
            ->whereYear('tanggal_kunjungan', $tahunIni)
            ->select(DB::raw('MONTH(tanggal_kunjungan) as bulan_ke'), DB::raw('COUNT(*) as total'))
            ->groupBy('bulan_ke')
            ->get()
            ->keyBy('bulan_ke');

        $labels = [];
        $values = [];
        foreach ($namaBulan as $i => $nama) {
            $bulanKe = $i + 1;
            $labels[] = $nama;
            $values[] = (int) ($rows[$bulanKe]->total ?? 0);
        }

        $totalTahunIni = array_sum($values);
        $totalTahunLalu = $this->totalKunjunganBetween(
            Carbon::create($tahunIni - 1, 1, 1),
            Carbon::create($tahunIni - 1, 12, 31)
        );

        return $this->bungkusHasilKunjungan($labels, $values, $totalTahunIni, $totalTahunLalu, 'bulan', 12);
    }

    private function bungkusHasilKunjungan(array $labels, array $values, int $totalSekarang, int $totalSebelumnya, string $satuanRataRata, int $jumlahBucket): array
    {
        $rataRata = $totalSekarang / max($jumlahBucket, 1);
        $growth = $totalSebelumnya > 0 ? round((($totalSekarang - $totalSebelumnya) / $totalSebelumnya) * 100, 1) : ($totalSekarang > 0 ? 100.0 : 0.0);

        return [
            'labels' => $labels,
            'values' => $values,
            'total' => $totalSekarang,
            'growth' => $growth,
            'avg' => round($rataRata, 1),
            'total_formatted' => number_format($totalSekarang, 0, ',', '.'),
            'growth_formatted' => $this->formatGrowth($growth),
            'avg_formatted' => number_format($rataRata, 1, ',', '.') . ' /' . $satuanRataRata,
        ];
    }
}