@extends('adminlte::page')
@section('title', 'Dashboard Admin Klinik')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');
        body, .content-wrapper { font-family: 'Nunito', sans-serif !important; background-color: #f4f7f6 !important; }
        
        /* HEADER WIDGETS */
        .widget-card { border: none; border-radius: 20px; color: white; overflow: hidden; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.08); transition: transform 0.3s; }
        .widget-card:hover { transform: translateY(-5px); }
        .widget-bg-1 { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); } /* Biru */
        .widget-bg-2 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); } /* Hijau */
        .widget-bg-3 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); } /* Oranye */
        .widget-bg-4 { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); } /* Ungu */
        
        .widget-icon { position: absolute; right: -15px; bottom: -20px; font-size: 7rem; opacity: 0.15; transform: rotate(-15deg); }
        .widget-content { padding: 25px; position: relative; z-index: 2; }
        .widget-title { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; margin-bottom: 5px; }
        .widget-value { font-size: 2.2rem; font-weight: 800; line-height: 1.2; }

        /* CARDS UNTUK GRAFIK & TABEL */
        .card-custom { border: none; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.04); }
        .card-header-custom { background-color: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; border-top-left-radius: 16px !important; border-top-right-radius: 16px !important; }
        .card-title-custom { color: #1e293b; font-weight: 800; font-size: 1.1rem; }
        
        /* TABLE DUMMY */
        .table thead th { background-color: #f8fafc; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: none; border-top: none; }
        .table tbody td { vertical-align: middle; border-top: 1px solid #f1f5f9; color: #334155; font-size: 0.9rem; }
        .badge-modern { padding: 0.4em 0.8em; border-radius: 6px; font-weight: 700; font-size: 0.7rem; }
        .bg-soft-warning { background-color: #fef3c7; color: #b45309; }
        .bg-soft-success { background-color: #dcfce7; color: #166534; }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid mt-3 mb-2">
        <h1 class="m-0 text-dark font-weight-bold" style="font-size: 1.8rem;">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-muted mt-1" style="font-size: 1rem;">Berikut adalah ringkasan operasional klinik hari ini.</p>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-lg-3 col-6 mb-4">
            <div class="widget-card widget-bg-1">
                <i class="fas fa-users widget-icon"></i>
                <div class="widget-content">
                    <div class="widget-title">Total Pasien Terdaftar</div>
                    <div class="widget-value">{{ $total_pasien }} <span style="font-size: 1rem; font-weight: 600; opacity: 0.8;">Orang</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="widget-card widget-bg-2">
                <i class="fas fa-user-md widget-icon"></i>
                <div class="widget-content">
                    <div class="widget-title">Total Dokter Aktif</div>
                    <div class="widget-value">{{ $total_dokter }} <span style="font-size: 1rem; font-weight: 600; opacity: 0.8;">Dokter</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="widget-card widget-bg-3">
                <i class="fas fa-calendar-check widget-icon"></i>
                <div class="widget-content">
                    <div class="widget-title">Kunjungan Hari Ini</div>
                    <div class="widget-value">{{ $kunjungan_hari_ini }} <span style="font-size: 1rem; font-weight: 600; opacity: 0.8;">Antrean</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="widget-card widget-bg-4">
                <i class="fas fa-wallet widget-icon"></i>
                <div class="widget-content">
                    <div class="widget-title">Pemasukan Hari Ini</div>
                    <div class="widget-value"><span style="font-size: 1.2rem;">Rp</span> {{ number_format($pemasukan_hari_ini, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header card-header-custom">
                    <h3 class="card-title-custom"><i class="fas fa-chart-line text-primary mr-2"></i> Statistik Kunjungan (7 Hari Terakhir)</h3>
                </div>
                <div class="card-body">
                    <canvas id="kunjunganChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header card-header-custom">
                    <h3 class="card-title-custom"><i class="fas fa-chart-bar text-success mr-2"></i> Pemasukan Klinik (7 Hari Terakhir)</h3>
                </div>
                <div class="card-body">
                    <canvas id="pemasukanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                    <h3 class="card-title-custom m-0"><i class="fas fa-clipboard-list text-warning mr-2"></i> Kunjungan Terbaru</h3>
                    <button class="btn btn-sm btn-light text-primary font-weight-bold">Lihat Semua</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No. Antrean</th>
                                    <th>Nama Pasien</th>
                                    <th>Tujuan Poli</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td class="font-weight-bold text-muted">#ANT-001</td>
                                    <td class="font-weight-bold text-dark">Budi Santoso</td> 
                                    <td>Poli Gigi</td>
                                    <td><span class="badge-modern bg-soft-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">#ANT-002</td>
                                    <td class="font-weight-bold text-dark">Siti Aminah</td>
                                    <td>Poli Anak</td>
                                    <td><span class="badge-modern bg-soft-success">Diperiksa</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">#ANT-003</td>
                                    <td class="font-weight-bold text-dark">Andi Wijaya</td>
                                    <td>Poli Umum</td>
                                    <td><span class="badge-modern bg-soft-warning">Menunggu</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                    <h3 class="card-title-custom m-0"><i class="fas fa-file-invoice-dollar text-success mr-2"></i> Pembayaran Terbaru</h3>
                    <button class="btn btn-sm btn-light text-primary font-weight-bold">Lihat Semua</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Pasien</th>
                                    <th>Metode</th>
                                    <th class="text-right">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td class="font-weight-bold text-muted">INV-2309-01</td>
                                    <td>Maya Sari</td>
                                    <td><i class="fas fa-money-bill-wave text-success mr-1"></i> Tunai</td>
                                    <td class="text-right font-weight-bold text-dark">Rp 150.000</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">INV-2309-02</td>
                                    <td>Hendra Gunawan</td>
                                    <td><i class="fas fa-credit-card text-primary mr-1"></i> Midtrans</td>
                                    <td class="text-right font-weight-bold text-dark">Rp 350.000</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted">INV-2309-03</td>
                                    <td>Rina Kumala</td>
                                    <td><i class="fas fa-credit-card text-primary mr-1"></i> Midtrans</td>
                                    <td class="text-right font-weight-bold text-dark">Rp 75.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            // GRAFIK KUNJUNGAN PASIEN (LINE CHART)
            var kunjunganCanvas = $('#kunjunganChart').get(0).getContext('2d');
            
            // DATA DUMMY
            var dataKunjungan = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [
                    {
                        label: 'Jumlah Pasien',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6',
                        pointRadius: 4,
                        pointBackgroundColor: '#3b82f6',
                        pointColor: '#3b82f6',
                        pointHighlightStroke: 'rgba(59, 130, 246, 1)',
                        data: [15, 22, 18, 30, 25, 35, 10], // angka palsu/dummy
                        fill: true,
                        tension: 0.4
                    }
                ]
            }

            var kunjunganOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true }
                }
            }
            new Chart(kunjunganCanvas, { type: 'line', data: dataKunjungan, options: kunjunganOptions });

            // GRAFIK PEMASUKAN (BAR CHART)
            var pemasukanCanvas = $('#pemasukanChart').get(0).getContext('2d');
            
            // DATA DUMMY
            var dataPemasukan = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [
                    {
                        label: 'Pemasukan (Rp)',
                        backgroundColor: '#10b981',
                        borderColor: '#10b981',
                        data: [1500000, 2200000, 1800000, 3000000, 2500000, 4000000, 800000] // angka palsu
                    }
                ]
            }

            var pemasukanOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true }
                }
            }
            new Chart(pemasukanCanvas, { type: 'bar', data: dataPemasukan, options: pemasukanOptions });
        })
    </script>
@endsection