<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Informasi Klinik Terintegrasi</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- Penambahan pustaka eksternal untuk penanganan Excel multi-sheet & PDF berskala besar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<style>
  :root {
    --teal-dark: #349AA1;
    --teal-mid: #5BB2A9;
    --green-light: #A6DAA8;
    --yellow: #F8B248;
    --orange: #DE763B;
    --peach: #F8C6AD;
    --bg: #F4F9F8;
    --card-bg: #FFFFFF;
    --text-dark: #1F3A3D;
    --text-muted: #7C9391;
    --border: #E3EFEE;
    --radius: 14px;
    --shadow: 0 4px 16px rgba(52, 154, 161, 0.08);
  }

  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  
  body {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: var(--bg);
    color: var(--text-dark);
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* ===== SIDEBAR (DYNAMIC CONDENSED) ===== */
  .sidebar {
    width: 240px;
    background: var(--teal-dark);
    color: #fff;
    display: flex;
    flex-direction: column;
    padding: 22px 14px;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh; 
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
  }
  .sidebar.collapsed { 
    width: 78px; 
    padding: 22px 10px; 
  }
  
  .sidebar-header { 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    margin-bottom: 24px; 
    padding: 0 8px; 
  }
  .brand { 
    font-size: 18px; 
    font-weight: 700; 
    letter-spacing: .3px; 
    white-space: nowrap; 
  }
  .brand span { color: var(--yellow); }
  .sidebar.collapsed .brand { display: none; }
  
  .toggle-sidebar-btn {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: 0.2s;
  }
  .toggle-sidebar-btn:hover { background: rgba(255, 255, 255, 0.25); }
  .sidebar.collapsed .toggle-sidebar-btn { width: 100%; }

  .nav-group-label { 
    font-size: 10px; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    color: rgba(255, 255, 255, .5); 
    margin: 14px 8px 8px; 
    white-space: nowrap; 
  }
  .sidebar.collapsed .nav-group-label { display: none; }
  
  .nav-item { 
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 10px; 
    font-size: 14px;
    color: rgba(255, 255, 255, .85);
    cursor: pointer;
    margin-bottom: 6px; 
    transition: .2s;
    white-space: nowrap;
    text-decoration: none;
  }
  .nav-item .nav-icon { font-size: 18px; display: inline-block; width: 24px; text-align: center; }
  .nav-item .nav-text { transition: opacity 0.2s; }
  .sidebar.collapsed .nav-item { justify-content: center; padding: 12px 0; }
  .sidebar.collapsed .nav-item .nav-text { display: none; }
  
  .nav-item:hover { background: rgba(255, 255, 255, .08); }
  .nav-item.active { background: #fff; color: var(--teal-dark); font-weight: 600; }

  .sidebar-footer { 
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: rgba(255, 255, 255, .08);
    border-radius: 12px;
    font-size: 12px;
    overflow: hidden;
  }
  .avatar-mini { 
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--yellow);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #3d2b00;
    font-size: 13px;
    flex-shrink: 0;
  }
  .sidebar.collapsed .sidebar-footer { background: transparent; padding: 4px 0; justify-content: center; }
  .sidebar.collapsed .sidebar-footer-text { display: none; }

  /* ===== MAIN CONTAINER ===== */
  .main { flex: 1; padding: 24px 28px 40px; transition: all 0.3s; min-width: 0; }

  /* PANELS & TABS MANAGEMENT */
  .page-section { display: none; }
  .page-section.active-page { display: block; }

  /* BANNER HEADER */
  .welcome-banner {
    background: linear-gradient(120deg, var(--teal-dark), var(--teal-mid));
    color: #fff;
    border-radius: var(--radius);
    padding: 24px 28px;
    margin-bottom: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow);
  }
  .welcome-banner h2 { font-size: 22px; font-weight: 600; margin-bottom: 4px; }
  .welcome-banner p { font-size: 13px; opacity: .9; }
  .welcome-date { background: rgba(255, 255, 255, .18); padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 500; }

  /* ACTION BAR */
  .action-bar { display: flex; gap: 12px; align-items: center; margin-bottom: 24px; width: 100%; flex-wrap: nowrap; }
  .search-container { flex: 1; min-width: 200px; }
  .search-box {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 13px;
    color: var(--text-dark);
    box-shadow: var(--shadow);
    width: 100%;
    outline: none;
  }
  .filter-select {
    padding: 10px 14px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    box-shadow: var(--shadow);
    font-size: 13px;
    color: var(--text-dark);
    cursor: pointer;
    outline: none;
  }
  
  /* EXPORT BUTTONS */
  .btn-download-pdf {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: #fff;
    border: 1px solid #DE763B;
    color: #DE763B;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--shadow);
    transition: 0.2s;
    white-space: nowrap;
  }
  .btn-download-pdf:hover { background: #FDF4EE; }

  .btn-download-excel {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: #fff;
    border: 1px solid #10B981;
    color: #10B981;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--shadow);
    transition: 0.2s;
    white-space: nowrap;
  }
  .btn-download-excel:hover { background: #EEFAF6; }
  
  .date-label { font-size: 12px; color: var(--text-muted); font-weight: 600; white-space: nowrap; }

  /* ===== SLIDER NAVIGATION CONTROLS ===== */
  .pagination-slider-controls {
    display: flex;
    gap: 12px;
    align-items: center;
  }

  .btn-slider-clean {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid #E2E8F0;
    background-color: #FFFFFF;
    color: #349AA1;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    padding: 0;
  }
  .btn-slider-clean:hover:not(:disabled) {
    background-color: #F8FAFC;
    border-color: #CBD5E1;
    color: #2A7A80;
  }
  .btn-slider-clean:disabled {
    background-color: #FFFFFF !important;
    color: #E2E8F0 !important;
    border-color: #F1F5F9 !important;
    cursor: not-allowed !important;
    opacity: 0.7;
  }

  /* ===== KPI CARDS ===== */
  .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card { background: var(--card-bg); border-radius: var(--radius); padding: 20px; box-shadow: var(--shadow); border: 1px solid var(--border); display: flex; flex-direction: column; }
  .stat-label { font-size: 14px; font-weight: 600; color: #000000; order: 1; margin-bottom: 8px; }
  .stat-top { display: flex; justify-content: space-between; align-items: center; order: 2; margin-top: 4px; }
  .stat-value { font-size: 28px; font-weight: 700; color: var(--text-dark); }
  .stat-meta-right { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; }
  .stat-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; color: #fff; }
  .stat-trend { font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
  .trend-up { background: #E7F6E8; color: #2E8B47; }

  /* ===== GRAPHS CONTENT GRID ===== */
  .content-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; align-items: stretch; }
  .panel-wide { grid-column: span 2; }
  .panel-narrow { grid-column: span 1; }
  
  .panel { 
    background: var(--card-bg); 
    border-radius: var(--radius); 
    padding: 20px; 
    box-shadow: var(--shadow); 
    border: 1px solid var(--border); 
    display: flex; 
    flex-direction: column; 
    justify-content: space-between; 
  }
  .panel-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; }
  .panel-head h3 { font-size: 16px; font-weight: 600; }
  .panel-head p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

  .filter-tabs { display: flex; gap: 4px; background: var(--bg); padding: 4px; border-radius: 10px; }
  .filter-tab { border: none; background: transparent; padding: 6px 12px; font-size: 11.5px; border-radius: 8px; cursor: pointer; color: var(--text-muted); font-weight: 600; }
  .filter-tab.active { background: var(--teal-dark); color: #fff; }

  .chart-legend-inline { display: flex; gap: 16px; margin-bottom: 12px; margin-top: -2px; }
  .chart-legend-inline .legend-left { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); font-weight: 600; }
  .legend-dot-bar { width: 12px; height: 12px; border-radius: 3px; display: inline-block; }

  .chart-wrap { position: relative; height: 290px; width: 100%; }
  .donut-wrap { position: relative; height: 200px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: center; }

  .revenue-submetrics-new { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-top: 20px; }
  .submetric-box { border: 1px solid var(--border); border-radius: 12px; background: #fff; padding: 12px; display: flex; flex-direction: column; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
  .submetric-box .box-title { font-size: 11px; font-weight: 700; color: var(--text-dark); letter-spacing: 0.5px; text-transform: uppercase; border-bottom: 1px dashed var(--border); padding-bottom: 6px; text-align: center; }
  .submetric-box .box-split { display: flex; width: 100%; }
  .submetric-box .split-side { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2px 4px; }
  .submetric-box .split-side:first-child { border-right: 1px solid var(--border); }
  .submetric-box .side-label { font-size: 10px; color: var(--text-muted); font-weight: 500; margin-bottom: 2px; }
  .submetric-box .side-value { font-size: 14px; font-weight: 700; white-space: nowrap; }
  .submetric-box .side-value.income { color: var(--teal-dark); }
  .submetric-box .side-value.visit { color: #DE763B; }

  .donut-legend { margin-top: 14px; display: flex; flex-direction: column; gap: 8px; }
  .legend-row { display: flex; align-items: center; justify-content: space-between; font-size: 12px; }
  .legend-left { display: flex; align-items: center; gap: 8px; }
  .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
  .legend-time { font-size: 11px; color: var(--text-muted); font-weight: 500; }

  /* ===== HALAMAN INFORMASI (2 TABEL DITUMPUK ATAS-BAWAH) ===== */
  .table-stack { display: flex; flex-direction: column; gap: 20px; width: 100%; }
  .table-panel { 
    background: var(--card-bg);
    border-radius: var(--radius);
    padding: 20px 24px; 
    box-shadow: var(--shadow);
    border: 1px solid var(--border); 
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    width: 100%;
    overflow: hidden;
  }
  .table-panel-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 12px; flex-wrap: wrap; }
  .table-panel h3 { font-size: 16px; font-weight: 600; color: var(--text-dark); }
  
  .table-scroll-container { width: 100%; overflow-x: auto; border-radius: 8px; }
  
  .custom-table { width: 100%; border-collapse: collapse; font-size: 13.5px; table-layout: auto; }
  .custom-table th { padding: 12px 14px; font-weight: 600; color: var(--text-muted); border-bottom: 2px solid var(--border); background: #FAFDFD; text-align: left; white-space: nowrap; }
  .custom-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--text-dark); vertical-align: middle; text-align: left; white-space: normal; word-break: break-word; }
  .custom-table tr:last-child td { border-bottom: none; }
  
  .wa-icon-link { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; background: #25D366; color: white; border-radius: 50%; font-size: 12px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 4px rgba(37,211,102,0.25); transition: 0.2s; }
  .wa-icon-link:hover { background: #20BA56; transform: scale(1.08); }

  .status-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; white-space: nowrap; }
  .status-badge.status-green { background: #E7F6E8; color: #2E8B47; }
  .status-badge.status-yellow { background: #FFF7EC; color: #D97706; }
  .status-badge.status-red { background: #FEE2E2; color: #DC2626; }
  .status-badge.status-gray { background: #F3F4F6; color: #6B7280; }

  .text-empty { color: var(--text-muted); font-style: italic; opacity: 0.8; }

  /* Navigasi kiri/kanan per tabel */
  .table-pagination { display: flex; align-items: center; gap: 10px; }
  .page-nav-btn {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--teal-dark);
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.15s;
  }
  .page-nav-btn:hover:not(:disabled) { background: var(--teal-dark); color: #fff; border-color: var(--teal-dark); }
  .page-nav-btn:disabled { opacity: 0.35; cursor: not-allowed; }
  .page-indicator { font-size: 12px; color: var(--text-muted); font-weight: 600; min-width: 40px; text-align: center; }

  /* ===== BOTTOM GRID 4 CHARTS ===== */
  .bottom-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-top: 24px; }
  .bottom-grid .panel { min-height: 290px; }
  .mini-chart-wrap { position: relative; height: 220px; margin-top: 14px; width: 100%; }

  @media (max-width:1150px) {
    .stat-grid { grid-template-columns: 1fr 1fr; }
    .content-grid { grid-template-columns: 1fr; }
    .panel-wide, .panel-narrow { grid-column: span 1; }
    .table-grid-row { grid-template-columns: 1fr; }
    .bottom-grid { grid-template-columns: 1fr; }
    .action-bar { flex-wrap: wrap; }
  }
</style>
</head>
<body>

<!-- SIDEBAR DENGAN TOGGLE CONDENSED LAYOUT -->
<aside class="sidebar" id="mainSidebar">
  <div class="sidebar-header">
    <div class="brand">Klinik<span>Sehat</span></div>
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>
  </div>

  <div class="nav-group-label">Menu Utama</div>
  
  <div class="nav-item active" id="menu-dashboard" onclick="switchPage('dashboard')">
    <span class="nav-icon">📊</span>
    <span class="nav-text">Dashboard</span>
  </div>
  
  <div class="nav-item" id="menu-informasi" onclick="switchPage('informasi')">
    <span class="nav-icon">ℹ️</span>
    <span class="nav-text">Informasi</span>
  </div>

  <div class="sidebar-footer">
    <div class="avatar-mini">A</div>
    <div class="sidebar-footer-text">
      <div style="font-weight:600; font-size: 13px;">Admin</div>
      <div style="opacity:.7; font-size: 11px;">admin@kliniksehat.id</div>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT CONTAINER -->
<main class="main" id="dashboard-content">

  <!-- ==================== HALAMAN 1: DASHBOARD ==================== -->
  <div id="page-dashboard" class="page-section active-page">
    <div class="welcome-banner">
      <div>
        <h2>Selamat datang kembali, Admin 👋</h2>
      </div>
      <div class="welcome-date" id="todayDate"></div>
    </div>

    <!-- ACTION BAR: KIRI UNTUK FILTER, KANAN UNTUK DOWNLOAD -->
    <div class="action-bar" data-html2canvas-ignore="true" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; width: 100%;">
      
      <!-- Grup Sisi Kiri: Filter Tanggal, Poli, Apply dan Reset Dashboard -->
      <div style="display: flex; align-items: center; gap: 8px; flex-wrap: nowrap; flex: 1;">
        <span class="date-label">Dari:</span>
        <input type="date" id="dashboardStartDate" class="filter-select" style="flex: 1; min-width: 120px;">
        <span class="date-label">Sampai:</span>
        <input type="date" id="dashboardEndDate" class="filter-select" style="flex: 1; min-width: 120px;">
        
        <select id="dashboardPoliFilter" class="filter-select" style="flex: 1.5; min-width: 160px;">
          <option value="ALL">Semua Poli (Select All)</option>
          @if(!empty($topPoliLabels))
            @foreach($topPoliLabels as $poli)
              <option value="{{ $poli }}">{{ $poli }}</option>
            @endforeach
          @endif
        </select>
        
        <button type="button" onclick="applyDashboardFilter()" class="filter-select" style="background-color: var(--teal-dark); color: white; cursor: pointer; font-weight: 600; text-align: center; border: none; padding: 10px 16px; white-space: nowrap;">🎯 Apply Filter</button>
        <button type="button" onclick="resetDashboardFilter()" class="filter-select" style="background-color: #7C9391; color: white; cursor: pointer; font-weight: 600; text-align: center; border: none; padding: 10px 14px; white-space: nowrap;">🔄 Reset</button>
      </div>

      <!-- Grup Sisi Kanan: Aksi Download -->
      <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
        <button class="btn-download-pdf" id="downloadPdfBtn" onclick="exportDashboardToPDF()"><span>📄</span> Download PDF</button>
        <button class="btn-download-excel" id="downloadExcelBtn" onclick="exportDashboardToExcel()"><span>📊</span> Download Excel</button>
      </div>

    </div>

    <div class="stat-grid">
      <div class="stat-card">
        <div class="stat-label">Jumlah Pasien Terdaftar</div>
        <div class="stat-top">
          <div class="stat-value">{{ number_format($totalPasien, 0, ',', '.') }}</div>
          <div class="stat-meta-right">
            <div class="stat-icon" style="background:var(--teal-dark);">🧑‍🤝‍🧑</div>
            <div class="stat-trend trend-up">+12.5%</div>
          </div>
        </div>
      </div>
      
      <div class="stat-card">
        <div class="stat-label">Jumlah Dokter Aktif</div>
        <div class="stat-top">
          <div class="stat-value">{{ number_format($dokterAktif, 0, ',', '.') }}</div>
          <div class="stat-meta-right">
            <div class="stat-icon" style="background:var(--teal-mid);">🩺</div>
            <div class="stat-trend trend-up">+8.2%</div>
          </div>
        </div>
      </div>
      
      <div class="stat-card">
        <div class="stat-label">Jumlah Kunjungan (Hari Ini)</div>
        <div class="stat-top">
          <div class="stat-value">{{ number_format($kunjunganHariIni, 0, ',', '.') }}</div>
          <div class="stat-meta-right">
            <div class="stat-icon" style="background:var(--orange);">📋</div>
            <div class="stat-trend trend-up">+15.3%</div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-grid">
      <div class="panel panel-wide">
        <div class="panel-head">
          <div>
            <h3>Analisis Pendapatan & Kunjungan</h3>
            <p>Ringkasan performa pendapatan berkala klinik beserta tren jumlah kunjungan</p>
          </div>
          <div class="filter-tabs" id="revenueFilters">
            <button class="filter-tab active" data-range="week">Minggu</button>
            <button class="filter-tab" data-range="month">Bulan</button>
            <button class="filter-tab" data-range="year">Tahun</button>
          </div>
        </div>

        <div class="chart-legend-inline">
          <div class="legend-left"><span class="legend-dot-bar" style="background:var(--teal-dark);"></span> Pendapatan</div>
          <div class="legend-left"><span class="legend-dot-bar" style="background:var(--orange);"></span> Kunjungan</div>
        </div>

        <div class="chart-wrap"><canvas id="revenueChart"></canvas></div>

        <div class="revenue-submetrics-new">
          <div class="submetric-box">
            <div class="box-title">TOTAL</div>
            <div class="box-split">
              <div class="split-side">
                <span class="side-label">Pendapatan</span>
                <span class="side-value income" id="mTotal">{{ $revenue['month']['total_formatted'] }}</span>
              </div>
              <div class="split-side">
                <span class="side-label">Kunjungan</span>
                <span class="side-value visit" id="mTotalKunjungan">{{ $kunjunganTren['month']['total_formatted'] }}</span>
              </div>
            </div>
          </div>
          <div class="submetric-box">
            <div class="box-title">GROWTH RATE</div>
            <div class="box-split">
              <div class="split-side">
                <span class="side-label">Pendapatan</span>
                <span class="side-value income" id="mGrowth">{{ $revenue['month']['growth_formatted'] }}</span>
              </div>
              <div class="split-side">
                <span class="side-label">Kunjungan</span>
                <span class="side-value visit" id="mGrowthKunjungan">{{ $kunjunganTren['month']['growth_formatted'] }}</span>
              </div>
            </div>
          </div>
          <div class="submetric-box">
            <div class="box-title">AVG/HARI</div>
            <div class="box-split">
              <div class="split-side">
                <span class="side-label">Pendapatan</span>
                <span class="side-value income" id="mAvg">{{ $revenue['month']['avg_formatted'] }}</span>
              </div>
              <div class="split-side">
                <span class="side-label">Kunjungan</span>
                <span class="side-value visit" id="mAvgKunjungan">{{ $kunjunganTren['month']['avg_formatted'] }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-narrow">
        <div class="panel-head">
          <div>
            <h3>Jadwal Kunjungan Pasien</h3>
            <p>Distribusi kunjungan per shift waktu kerja</p>
          </div>
        </div>
        <div class="donut-wrap"><canvas id="jadwalChart"></canvas></div>
        <div class="donut-legend">
          <div class="legend-row">
            <div class="legend-left"><span class="legend-dot" style="background:var(--teal-dark);"></span> Pagi (07:00 – 14:00)</div>
            <div class="legend-time">{{ $donutPersen['pagi'] }}%</div>
          </div>
          <div class="legend-row">
            <div class="legend-left"><span class="legend-dot" style="background:var(--yellow);"></span> Siang (14:00 – 22:00)</div>
            <div class="legend-time">{{ $donutPersen['siang'] }}%</div>
          </div>
          <div class="legend-row">
            <div class="legend-left"><span class="legend-dot" style="background:var(--orange);"></span> Malam (22:00 – 07:00)</div>
            <div class="legend-time">{{ $donutPersen['malam'] }}%</div>
          </div>
        </div>
      </div>
    </div>

<div class="bottom-grid">
      <!-- 1. Top 5 Layanan Utama -->
      <div class="panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <h3>Top 5 Layanan Utama</h3>
          <div class="pagination-slider-controls">
            <button type="button" id="btnPrevLayanan" data-action="prev" class="btn-slider-clean" aria-label="Previous">‹</button>
            <button type="button" id="btnNextLayanan" data-action="next" class="btn-slider-clean" aria-label="Next">›</button>
          </div>
        </div>
        <div class="mini-chart-wrap"><canvas id="chartLayanan"></canvas></div>
      </div>

      <!-- 2. Top 5 Poli Tujuan -->
      <div class="panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <h3>Top 5 Poli Tujuan</h3>
          <div class="pagination-slider-controls">
            <button type="button" id="btnPrevPoli" data-action="prev" class="btn-slider-clean" aria-label="Previous">‹</button>
            <button type="button" id="btnNextPoli" data-action="next" class="btn-slider-clean" aria-label="Next">›</button>
          </div>
        </div>
        <div class="mini-chart-wrap"><canvas id="chartPoli"></canvas></div>
      </div>

      <!-- 3. Top 5 Keluhan Pasien -->
      <div class="panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <h3>Top 5 Keluhan Pasien</h3>
          <div class="pagination-slider-controls">
            <button type="button" id="btnPrevKeluhan" data-action="prev" class="btn-slider-clean" aria-label="Previous">‹</button>
            <button type="button" id="btnNextKeluhan" data-action="next" class="btn-slider-clean" aria-label="Next">›</button>
          </div>
        </div>
        <div class="mini-chart-wrap"><canvas id="chartKeluhan"></canvas></div>
      </div>

      <!-- 4. Top 5 Diagnosa Terbanyak -->
      <div class="panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <h3>Top 5 Diagnosa Terbanyak</h3>
          <div class="pagination-slider-controls">
            <button type="button" id="btnPrevDiagnosa" data-action="prev" class="btn-slider-clean" aria-label="Previous">‹</button>
            <button type="button" id="btnNextDiagnosa" data-action="next" class="btn-slider-clean" aria-label="Next">›</button>
          </div>
        </div>
        <div class="mini-chart-wrap"><canvas id="chartDiagnosa"></canvas></div>
      </div>
    </div>
  </div>
  <!-- ==================== HALAMAN 2: INFORMASI (2 TABEL DITUMPUK) ==================== -->
  <div id="page-informasi" class="page-section">
    
    <div class="action-bar" style="margin-bottom: 20px;">
      <div class="search-container">
        <input type="text" id="infoSearchBox" class="search-box" placeholder="🔍 Cari Nama Dokter, Poli, atau Pasien...">
      </div>
      <span class="date-label">Dari:</span>
      <input type="date" id="infoStartDate" class="filter-select">
      <span class="date-label">Sampai:</span>
      <input type="date" id="infoEndDate" class="filter-select">
      
      <button class="btn-download-pdf" onclick="exportDataToPDF()"><span>📄</span> Download PDF</button>
      <button class="btn-download-excel" onclick="exportDataToExcel()"><span>📊</span> Download Excel</button>
    </div>

    <div class="table-stack">

      <!-- TABEL 1: DAFTAR PEMBAYARAN TERBARU -->
      <div class="table-panel">
        <div class="table-panel-head" style="display: flex; align-items: center; justify-content: space-between;">
          <h3>Daftar Pembayaran Terbaru</h3>
          <div class="table-pagination">
            <button class="page-nav-btn" id="btnPrevPembayaran" aria-label="Data sebelumnya">‹</button>
            <span class="page-indicator" id="pembayaranPageIndicator">1 / 1</span>
            <button class="page-nav-btn" id="btnNextPembayaran" aria-label="Data berikutnya">›</button>
          </div>
        </div>
        <div class="table-scroll-container">
          <table class="custom-table" id="mainPembayaranTable">
            <thead>
              <tr>
                <th>Nama Pasien</th>
                <th>Kontak</th>
                <th>Tanggal</th>
                <th>Layanan</th>
                <th>Total Bayar</th>
                <th>Status Bayar</th>
              </tr>
            </thead>
            <tbody id="pembayaranTableBody">
              @forelse(collect($pembayaranTerbaru) as $pembayaran)
                @php
                  $dateRaw = strpos($pembayaran['tanggal'], '-') !== false ? implode('-', array_reverse(explode('-', $pembayaran['tanggal']))) : $pembayaran['tanggal'];
                @endphp
                <tr data-date="{{ $dateRaw }}" data-search="{{ strtolower($pembayaran['nama_pasien'].' '.($pembayaran['jenis_layanan'] ?? '')) }}">
                  <td><strong>{{ $pembayaran['nama_pasien'] }}</strong></td>
                  <td>
                    @if(!empty($pembayaran['no_telp']) && $pembayaran['no_telp'] !== '-')
                      <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pembayaran['no_telp']) }}" target="_blank" class="wa-icon-link" title="Hubungi Pasien">💬</a>
                    @else
                      <span class="text-empty">-</span>
                    @endif
                  </td>
                  <td>{{ $pembayaran['tanggal'] }}</td>
                  <td>{{ $pembayaran['jenis_layanan'] }}</td>
                  <td style="font-weight: 600; color: var(--teal-dark);">Rp {{ number_format($pembayaran['total_bayar'], 0, ',', '.') }}</td>
                  <td>
                    @php 
                      $statusBayar = strtolower($pembayaran['status_pembayaran'] ?? ''); 
                    @endphp
                    @if($statusBayar === 'sudah' || $statusBayar === 'lunas' || $statusBayar === 'berhasil_dibayar' || $statusBayar === 'berhasil dibayar')
                      <span class="status-badge status-green">Sudah Dibayar</span>
                    @elseif($statusBayar === 'melewati_batas' || $statusBayar === 'terlambat' || $statusBayar === 'overdue')
                      <span class="status-badge status-red">Overdue</span>
                    @elseif($statusBayar === 'belum' || $statusBayar === 'pending' || $statusBayar === 'menunggu' || $statusBayar === 'menunggu bayar')
                      <span class="status-badge status-yellow">Menunggu Bayar</span>
                    @else
                      <span class="status-badge status-yellow">Belum Bayar</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr class="empty-row"><td colspan="6" style="text-align: center; padding: 24px;">Tidak ada data pembayaran.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- TABEL 2: KUNJUNGAN TERBARU -->
      <div class="table-panel">
        <div class="table-panel-head" style="display: flex; align-items: center; justify-content: space-between;">
          <h3>Kunjungan Terbaru</h3>
          <div class="table-pagination">
            <button class="page-nav-btn" id="btnPrevKunjungan" aria-label="Data sebelumnya">‹</button>
            <span class="page-indicator" id="kunjunganPageIndicator">1 / 1</span>
            <button class="page-nav-btn" id="btnNextKunjungan" aria-label="Data berikutnya">›</button>
          </div>
        </div>
        <div class="table-scroll-container">
          <table class="custom-table" id="mainKunjunganTable">
            <thead>
              <tr>
                <th>Nama Pasien</th>
                <th>WA</th>
                <th>Tanggal</th>
                <th>Poli</th>
                <th>Diagnosa</th>
                <th>Nama Dokter</th>
                <th>Status Kunjungan</th>
              </tr>
            </thead>
            <tbody id="kunjunganTableBody">
              @forelse(collect($kunjunganTerbaru) as $kunjungan)
                @php
                  $dateRawKunj = strpos($kunjungan['tanggal'], '-') !== false ? implode('-', array_reverse(explode('-', $kunjungan['tanggal']))) : $kunjungan['tanggal'];
                @endphp
                <tr data-poli="{{ $kunjungan['poli'] ?? '-' }}" data-date="{{ $dateRawKunj }}" data-search="{{ strtolower($kunjungan['nama_pasien'].' '.($kunjungan['poli'] ?? '').' '.($kunjungan['nama_dokter'] ?? '').' '.($kunjungan['diagnosa'] ?? '')) }}">
                  <td><strong>{{ $kunjungan['nama_pasien'] }}</strong></td>
                  <td>
                    @if(!empty($kunjungan['no_telp']) && $kunjungan['no_telp'] !== '-')
                      <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kunjungan['no_telp']) }}" target="_blank" class="wa-icon-link" title="Kirim Pesan">💬</a>
                    @else
                      <span class="text-empty">-</span>
                    @endif
                  </td>
                  <td>{{ $kunjungan['tanggal'] }}</td>
                  <td>{{ $kunjungan['poli'] ?? '-' }}</td>
                  <td>
                    @if(!empty($kunjungan['diagnosa']) && $kunjungan['diagnosa'] !== 'Pemeriksaan Umum')
                      {{ $kunjungan['diagnosa'] }}
                    @else
                      <span class="text-empty">belum ada</span>
                    @endif
                  </td>
                  <td>{{ $kunjungan['nama_dokter'] ?? '-' }}</td>
                  <td>
                    @php 
                      $statusKunjungan = strtolower($kunjungan['status'] ?? ''); 
                    @endphp
                    @if($statusKunjungan === 'selesai')
                      <span class="status-badge status-green">Selesai</span>
                    @elseif($statusKunjungan === 'sedang_diperiksa' || $statusKunjungan === 'sedang diperiksa')
                      <span class="status-badge status-yellow">Sedang Diperiksa</span>
                    @elseif($statusKunjungan === 'menunggu_pemeriksaan' || $statusKunjungan === 'menunggu_pembayaran' || $statusKunjungan === 'menunggu')
                      <span class="status-badge status-yellow">Menunggu</span>
                    @elseif($statusKunjungan === 'batal' || $statusKunjungan === 'cancel')
                      <span class="status-badge status-red">Batal</span>
                    @else
                      <span class="status-badge status-gray">{{ str_replace('_', ' ', $statusKunjungan) }}</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr class="empty-row"><td colspan="7" style="text-align: center; padding: 24px;">Tidak ada data kunjungan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</main>

<script>
  // 1. KUMPULKAN DAN SIMPAN DATA ASLI DARI LARAVEL KE JAVASCRIPT MASTER VARIABLE
  const DEFAULT_DASHBOARD_DATA = {
    revenue: {
      week: {
        labels: {!! json_encode($revenue['week']['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
        income: {!! json_encode($revenue['week']['income'] ?? [0,0,0,0,0,0,0]) !!},
        visit: {!! json_encode($kunjunganTren['week']['values'] ?? [0,0,0,0,0,0,0]) !!}
      },
      month: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        income: {!! json_encode($revenue['month']['values'] ?? [0,0,0,0]) !!},
        visit: {!! json_encode($kunjunganTren['month']['values'] ?? [0,0,0,0]) !!}
      },
      year: {
        labels: {!! json_encode($revenue['year']['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
        income: {!! json_encode($revenue['year']['values'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!},
        visit: {!! json_encode($kunjunganTren['year']['values'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!}
      },
      submetrics: {
        totalIncome: "{{ $revenue['month']['total_formatted'] ?? 'Rp 0' }}",
        totalVisit: "{{ $kunjunganTren['month']['total_formatted'] ?? '0' }}",
        growthIncome: "{{ $revenue['month']['growth_formatted'] ?? '0%' }}",
        growthVisit: "{{ $kunjunganTren['month']['growth_formatted'] ?? '0%' }}",
        avgIncome: "{{ $revenue['month']['avg_formatted'] ?? 'Rp 0' }}",
        avgVisit: "{{ $kunjunganTren['month']['avg_formatted'] ?? '0' }}"
      }
    },
    jadwalShift: {!! json_encode([$donutPersen['pagi'] ?? 0, $donutPersen['siang'] ?? 0, $donutPersen['malam'] ?? 0]) !!},
    layanan: {
      labels: {!! json_encode($topLayananLabels ?? []) !!},
      data: {!! json_encode($topLayananData ?? $topLayananValues ?? []) !!}
    },
    poli: {
      labels: {!! json_encode($topPoliLabels ?? []) !!},
      data: {!! json_encode($topPoliData ?? $topPoliValues ?? []) !!}
    },
    keluhan: {
      labels: {!! json_encode($topKeluhanLabels ?? []) !!},
      data: {!! json_encode($topKeluhanData ?? $topKeluhanValues ?? []) !!}
    },
    diagnosa: {
      labels: {!! json_encode($topDiagnosaLabels ?? []) !!},
      data: {!! json_encode($topDiagnosaData ?? $topDiagnosaValues ?? []) !!}
    }
  };

  // Referensi instance chart disatukan agar konsisten
  let revenueChart, doughnutChart;
  const barChartsInstance = {};

  // Register Plugin & Setup Global Options Aman
  if (typeof Chart !== 'undefined' && typeof ChartDataLabels !== 'undefined') {
    Chart.register(ChartDataLabels);
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
  }

  // Set Tanggal Hari Ini di Welcome Banner
  const todayDateEl = document.getElementById('todayDate');
  if (todayDateEl) {
    todayDateEl.textContent = new Date().toLocaleDateString('id-ID', {
      weekday:'long', year:'numeric', month:'long', day:'numeric'
    });
  }

  const PALETTE = ['#349AA1','#5BB2A9','#A6DAA8','#F8B248','#DE763B'];

  // FUNGSI UTAMA MINIMALIS SIDEBAR
  function toggleSidebar() {
    const sidebar = document.getElementById('mainSidebar');
    if (sidebar) sidebar.classList.toggle('collapsed');
  }

  // SWITCH PAGE (MULTITAB NAVIGATION JAVASCRIPT)
  function switchPage(pageId) {
    document.querySelectorAll('.page-section').forEach(page => page.classList.remove('active-page'));
    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    
    const targetPage = document.getElementById('page-' + pageId);
    const targetMenu = document.getElementById('menu-' + pageId);
    if (targetPage) targetPage.classList.add('active-page');
    if (targetMenu) targetMenu.classList.add('active');
  }

  function formatLabelSatuan(val) {
    if (val >= 1000) { return (val / 1000).toFixed(1).replace('.', ',') + ' M'; } 
    else if (val >= 1 || val <= -1) { return val.toString().replace('.', ',') + ' Jt'; } 
    else if (val > 0 && val < 1) { return (val * 1000).toFixed(0) + ' rb'; }
    return val;
  }

  /* =========================================================
     1. INISIALISASI DATA CHART UTAMA (REVENUE & KUNJUNGAN)
     ========================================================= */
  const revenueData = DEFAULT_DASHBOARD_DATA.revenue; 
  const kunjunganTrenData = DEFAULT_DASHBOARD_DATA.revenue; // Mengacu ke master variable agar sinkron

  const revenueCtx = document.getElementById('revenueChart');
  if (revenueCtx && typeof Chart !== 'undefined') {
    revenueChart = new Chart(revenueCtx, {
      type:'bar',
      data:{
        labels: revenueData.week.labels,
        datasets:[
          {
            label:'Pendapatan',
            data: revenueData.week.income,
            backgroundColor:'#349AA1', 
            borderRadius:4,
            maxBarThickness:22,
            yAxisID:'y',
            datalabels:{
              anchor:'end', align:'top',
              color:'#1F3A3D', font:{ size:10, weight:'600' },
              backgroundColor: 'rgba(255, 255, 255, 0.85)',
              borderRadius: 3,
              padding: { top: 2, bottom: 2, left: 4, right: 4 },
              formatter: (v) => formatLabelSatuan(v)
            }
          },
          {
            label:'Kunjungan',
            data: revenueData.week.visit,
            backgroundColor:'#DE763B', 
            borderRadius:4,
            maxBarThickness:22,
            yAxisID:'y1',
            datalabels:{
              anchor:'end', align:'top',
              color:'#DE763B', font:{ size:10, weight:'700' },
              backgroundColor: 'rgba(255, 255, 255, 0.85)',
              borderRadius: 3,
              padding: { top: 2, bottom: 2, left: 4, right: 4 },
              formatter: (v) => v
            }
          }
        ]
      },
      options:{
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ display:false } },
        scales:{
          y:{ display:false, grid:{ display:false }, grace:'35%', position:'left' }, 
          y1:{ display:false, grid:{ display:false }, grace:'35%', position:'right' },
          x:{ grid:{ display:false }, ticks:{ color:'#7C9391', font:{ size:11 } } }
        }
      }
    });
  }

  let currentActiveRange = 'week'; 

  function updateRevenue(range){
    if (!revenueChart) return;
    currentActiveRange = range;
    let d = revenueData[range] || { labels:[], income:[], visit:[] };

    revenueChart.data.labels = d.labels;
    revenueChart.data.datasets[0].data = d.income;
    revenueChart.data.datasets[1].data = d.visit;
    revenueChart.update();

    // TOTAL / GROWTH RATE / AVG-HARI dihitung ulang mengikuti tab Minggu/Bulan/Tahun yang aktif,
    // sekaligus tetap menghormati filter tanggal & poli yang sedang diterapkan di dashboard.
    updateRevenueSubmetrics();
  }

  function formatRupiahAvg(num) {
    if (!isFinite(num)) num = 0;
    if (Math.abs(num) >= 1000000) {
      return 'Rp ' + (num / 1000000).toFixed(1).replace('.', ',') + ' Jt';
    } else if (Math.abs(num) >= 1000) {
      return 'Rp ' + (num / 1000).toFixed(0).replace('.', ',') + ' rb';
    }
    return 'Rp ' + Math.round(num).toLocaleString('id-ID');
  }

  function formatGrowth(pct) {
    if (!isFinite(pct)) pct = 0;
    const sign = pct >= 0 ? '+' : '';
    return sign + pct.toFixed(1).replace('.', ',') + '%';
  }

  function parseRowDate(row) {
    const raw = row.getAttribute('data-date');
    if (!raw) return null;
    const parts = raw.split('-');
    if (parts.length !== 3) return null;
    const d = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
    return isNaN(d.getTime()) ? null : d;
  }

  function getRangeDefaultDays(range) {
    if (range === 'week') return 7;
    if (range === 'year') return 365;
    return 30; // bulan
  }

  function sumRowsInRange(rows, rangeStart, rangeEnd, isPaymentTable, poliVal) {
    let sum = 0, count = 0;
    rows.forEach(row => {
      const date = parseRowDate(row);
      if (!date) return;
      if (rangeStart && date < rangeStart) return;
      if (rangeEnd && date > rangeEnd) return;
      if (!isPaymentTable && poliVal && poliVal !== 'ALL') {
        const rowPoli = row.getAttribute('data-poli') || '';
        if (rowPoli !== poliVal) return;
      }
      count++;
      if (isPaymentTable) {
        const tds = row.querySelectorAll('td');
        const amountText = tds[4]?.innerText || '0';
        sum += Number(amountText.replace(/[^0-9.-]+/g, '')) || 0;
      }
    });
    return { sum, count };
  }

  // Menghitung ulang TOTAL, GROWTH RATE, dan AVG/HARI supaya selalu sinkron dengan
  // filter tanggal & poli utama dashboard, serta tab Minggu/Bulan/Tahun yang sedang aktif.
  // AVG/HARI dihitung sendiri di sini (total dibagi jumlah hari), bukan dari label bawaan yang salah.
  function updateRevenueSubmetrics() {
    const mTotal = document.getElementById('mTotal');
    const mGrowth = document.getElementById('mGrowth');
    const mAvg = document.getElementById('mAvg');
    const mTotalKunjungan = document.getElementById('mTotalKunjungan');
    const mGrowthKunjungan = document.getElementById('mGrowthKunjungan');
    const mAvgKunjungan = document.getElementById('mAvgKunjungan');

    const paymentRows = Array.from(document.querySelectorAll('#mainPembayaranTable tbody tr:not(.empty-row)'));
    const visitRows = Array.from(document.querySelectorAll('#mainKunjunganTable tbody tr:not(.empty-row)'));

    const filterStart = dashStart && dashStart.value ? new Date(dashStart.value) : null;
    const filterEnd = dashEnd && dashEnd.value ? new Date(dashEnd.value) : null;
    if (filterStart) filterStart.setHours(0, 0, 0, 0);
    if (filterEnd) filterEnd.setHours(23, 59, 59, 999);
    const poliVal = dashPoli ? dashPoli.value : 'ALL';

    let curStart, curEnd, days;
    if (filterStart && filterEnd) {
      curStart = filterStart; curEnd = filterEnd;
      days = Math.max(1, Math.round((curEnd - curStart) / 86400000) + 1);
    } else {
      days = getRangeDefaultDays(currentActiveRange);
      curEnd = new Date(); curEnd.setHours(23, 59, 59, 999);
      curStart = new Date(curEnd.getTime() - (days - 1) * 86400000);
      curStart.setHours(0, 0, 0, 0);
    }

    const curPayment = sumRowsInRange(paymentRows, curStart, curEnd, true, poliVal);
    const curVisit = sumRowsInRange(visitRows, curStart, curEnd, false, poliVal);

    const prevEnd = new Date(curStart.getTime() - 86400000);
    const prevStart = new Date(prevEnd.getTime() - (days - 1) * 86400000);
    const prevPayment = sumRowsInRange(paymentRows, prevStart, prevEnd, true, poliVal);
    const prevVisit = sumRowsInRange(visitRows, prevStart, prevEnd, false, poliVal);

    const growthIncome = prevPayment.sum > 0
      ? ((curPayment.sum - prevPayment.sum) / prevPayment.sum) * 100
      : (curPayment.sum > 0 ? 100 : 0);
    const growthVisit = prevVisit.count > 0
      ? ((curVisit.count - prevVisit.count) / prevVisit.count) * 100
      : (curVisit.count > 0 ? 100 : 0);

    const avgIncome = curPayment.sum / days;
    const avgVisit = curVisit.count / days;

    if (mTotal) mTotal.textContent = 'Rp ' + curPayment.sum.toLocaleString('id-ID');
    if (mTotalKunjungan) mTotalKunjungan.textContent = curVisit.count.toLocaleString('id-ID');
    if (mGrowth) mGrowth.textContent = formatGrowth(growthIncome);
    if (mGrowthKunjungan) mGrowthKunjungan.textContent = formatGrowth(growthVisit);
    if (mAvg) mAvg.textContent = formatRupiahAvg(avgIncome) + ' /hari';
    if (mAvgKunjungan) mAvgKunjungan.textContent = avgVisit.toFixed(1).replace('.', ',') + ' /hari';
  }

  document.querySelectorAll('#revenueFilters .filter-tab').forEach(btn=>{
    btn.addEventListener('click', function(){
      document.querySelectorAll('#revenueFilters .filter-tab').forEach(b=>b.classList.remove('active'));
      this.classList.add('active');
      updateRevenue(this.dataset.range);
    });
  });

  /* =========================================================
     2. DONUT & 4 BAR CHART BAWAH
     ========================================================= */
  const jadwalCtx = document.getElementById('jadwalChart');
  if(jadwalCtx && typeof Chart !== 'undefined') {
    doughnutChart = new Chart(jadwalCtx, {
      type: 'doughnut',
      data: {
        labels: ['Pagi', 'Siang', 'Malam'],
        datasets: [{
          data: DEFAULT_DASHBOARD_DATA.jadwalShift,
          backgroundColor: ['#349AA1', '#F8B248', '#DE763B']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, datalabels: { display: false } } }
    });
  }

  const ITEMS_PER_PAGE = 5;
  const barChartFullData = {}; // { canvasId: { entries: [[label,value],...], page: 0, total: number } }

  function createHorizontalBarChart(canvasId, dataLabels, dataValues) {
    const ctx = document.getElementById(canvasId);
    if(!ctx || typeof Chart === 'undefined') return;
    
    const finalLabels = dataLabels && dataLabels.length > 0 ? dataLabels : ['Belum ada data'];
    const finalValues = dataValues && dataValues.length > 0 ? dataValues.map(v => Number(v)) : [0];

    barChartsInstance[canvasId] = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: finalLabels,
        datasets: [{
          data: finalValues,
          backgroundColor: PALETTE,
          borderRadius: 6,
          borderSkipped: false
        }]
      },
      options: {
        indexAxis: 'y', responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false }, datalabels: { display: false } },
        scales: {
          x: { display: false, grid: { display: false }, grace: '35%' },
          y: { grid: { display: false }, ticks: { color: '#1F3A3D', font: { size: 11 } } }
        }
      },
      plugins: [{
        id: 'customDataLabels',
        afterDatasetsDraw(chart) {
          const { ctx, data } = chart;
          const visibleSum = data.datasets[0].data.reduce((a, b) => a + Number(b), 0) || 1;
          // Persentase dihitung terhadap total KESELURUHAN data (chart.grandTotal),
          // bukan cuma jumlah 5 data yang sedang tampil di halaman ini.
          const grandTotal = chart.grandTotal || visibleSum;
          chart.getDatasetMeta(0).data.forEach((bar, index) => {
            const value = data.datasets[0].data[index];
            const pct = ((value / grandTotal) * 100).toFixed(1) + '%';
            
            ctx.fillStyle = '#FFFFFF';
            ctx.font = 'bold 10px sans-serif';
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            if (bar.width > 38) { ctx.fillText(pct, bar.x - 8, bar.y); }

            ctx.fillStyle = '#1F3A3D';
            ctx.font = 'bold 11px sans-serif';
            ctx.textAlign = 'left';
            ctx.textBaseline = 'middle';
            ctx.fillText(' ' + value, bar.x + 4, bar.y);
          });
        }
      }]
    });
  }

  // Menyimpan SELURUH data (tidak dipotong ke 5 saja) supaya tombol ‹ › bisa menampilkan
  // data sebelumnya/berikutnya, dan persentase selalu dihitung dari total keseluruhan data.
  function setBarChartFullData(canvasId, mapData) {
    const sorted = Object.entries(mapData).sort((a, b) => b[1] - a[1]);
    const grandTotal = sorted.reduce((sum, [, v]) => sum + Number(v), 0) || 1;
    const prevPage = barChartFullData[canvasId] ? barChartFullData[canvasId].page : 0;
    const maxPage = Math.max(0, Math.ceil(sorted.length / ITEMS_PER_PAGE) - 1);
    barChartFullData[canvasId] = { entries: sorted, page: Math.min(prevPage, maxPage), total: grandTotal };
    renderBarChartPage(canvasId);
  }

  function renderBarChartPage(canvasId) {
    const store = barChartFullData[canvasId];
    const chart = barChartsInstance[canvasId];
    if (!chart || !store) return;
    const start = store.page * ITEMS_PER_PAGE;
    const pageEntries = store.entries.slice(start, start + ITEMS_PER_PAGE);
    chart.data.labels = pageEntries.length ? pageEntries.map(e => e[0]) : ['Belum ada data'];
    chart.data.datasets[0].data = pageEntries.length ? pageEntries.map(e => e[1]) : [0];
    chart.grandTotal = store.total;
    chart.update();
    updateBarChartPaginationButtons(canvasId);
  }

  function updateBarChartPaginationButtons(canvasId) {
    const store = barChartFullData[canvasId];
    const suffixMap = { chartLayanan: 'Layanan', chartPoli: 'Poli', chartKeluhan: 'Keluhan', chartDiagnosa: 'Diagnosa' };
    const suffix = suffixMap[canvasId];
    if (!suffix || !store) return;
    const prevBtn = document.getElementById('btnPrev' + suffix);
    const nextBtn = document.getElementById('btnNext' + suffix);
    const maxPage = Math.max(0, Math.ceil(store.entries.length / ITEMS_PER_PAGE) - 1);
    if (prevBtn) prevBtn.disabled = store.page <= 0;
    if (nextBtn) nextBtn.disabled = store.page >= maxPage;
  }

  function setupBarChartPaginationButtons() {
    const suffixMap = { Layanan: 'chartLayanan', Poli: 'chartPoli', Keluhan: 'chartKeluhan', Diagnosa: 'chartDiagnosa' };
    Object.entries(suffixMap).forEach(([suffix, canvasId]) => {
      document.getElementById('btnPrev' + suffix)?.addEventListener('click', () => {
        const store = barChartFullData[canvasId];
        if (store && store.page > 0) { store.page--; renderBarChartPage(canvasId); }
      });
      document.getElementById('btnNext' + suffix)?.addEventListener('click', () => {
        const store = barChartFullData[canvasId];
        if (!store) return;
        const maxPage = Math.max(0, Math.ceil(store.entries.length / ITEMS_PER_PAGE) - 1);
        if (store.page < maxPage) { store.page++; renderBarChartPage(canvasId); }
      });
    });
  }

  // Mengumpulkan data LENGKAP (bukan cuma top 5) dari tabel Pembayaran & Kunjungan,
  // baik untuk kondisi awal (semua baris) maupun setelah filter diterapkan (hanya baris yg tidak disembunyikan).
  function collectFullMapsFromTables(onlyActiveRows) {
    let layananMap = {}, poliMap = {}, diagnosaMap = {};

    document.querySelectorAll('#mainPembayaranTable tbody tr:not(.empty-row)').forEach(row => {
      if (onlyActiveRows && row.getAttribute('data-hidden-by-filter') === 'true') return;
      const tds = row.querySelectorAll('td');
      const layananName = tds[3]?.innerText || 'Umum';
      layananMap[layananName] = (layananMap[layananName] || 0) + 1;
    });

    document.querySelectorAll('#mainKunjunganTable tbody tr:not(.empty-row)').forEach(row => {
      if (onlyActiveRows && row.getAttribute('data-hidden-by-filter') === 'true') return;
      const tds = row.querySelectorAll('td');
      const poliName = row.getAttribute('data-poli') || tds[3]?.innerText || 'Lainnya';
      poliMap[poliName] = (poliMap[poliName] || 0) + 1;
      const diagnosaName = tds[4]?.innerText || 'Lainnya';
      diagnosaMap[diagnosaName] = (diagnosaMap[diagnosaName] || 0) + 1;
    });

    return { layananMap, poliMap, diagnosaMap };
  }

  /* =========================================================
     3. LOGIKA INTEGRASI SEARCH, FILTER TANGGAL & PAGINATION
     ========================================================= */
  const infoSearch = document.getElementById('infoSearchBox');
  const infoStart = document.getElementById('infoStartDate');
  const infoEnd = document.getElementById('infoEndDate');

  const dashStart = document.getElementById('dashboardStartDate');
  const dashEnd = document.getElementById('dashboardEndDate');
  const dashPoli = document.getElementById('dashboardPoliFilter');

  const ROWS_PER_PAGE = 5;
  let pembayaranCurrentPage = 1;
  let kunjunganCurrentPage = 1;

  function applyDashboardFilter() {
    executeTableFiltering(true);
    executeChartFiltering();
  }

  function executeChartFiltering() {
    let pagi = 0, siang = 0, malam = 0;
    let layananMap = {}, poliMap = {}, diagnosaMap = {};

    document.querySelectorAll('#mainKunjunganTable tbody tr:not(.empty-row)').forEach(row => {
      if (row.getAttribute('data-hidden-by-filter') !== 'true') {
        const tds = row.querySelectorAll('td');
        const poliName = row.getAttribute('data-poli') || tds[3]?.innerText || 'Lainnya';
        poliMap[poliName] = (poliMap[poliName] || 0) + 1;

        const diagnosaName = tds[4]?.innerText || 'Lainnya';
        diagnosaMap[diagnosaName] = (diagnosaMap[diagnosaName] || 0) + 1;

        const dateStr = row.getAttribute('data-date');
        if(dateStr) {
          const hourFallback = new Date().getHours(); 
          if(hourFallback >= 7 && hourFallback < 14) pagi++;
          else if(hourFallback >= 14 && hourFallback < 22) siang++;
          else malam++;
        } else {
          pagi++;
        }
      }
    });

    document.querySelectorAll('#mainPembayaranTable tbody tr:not(.empty-row)').forEach(row => {
      if (row.getAttribute('data-hidden-by-filter') !== 'true') {
        const tds = row.querySelectorAll('td');
        const layananName = tds[3]?.innerText || 'Umum';
        layananMap[layananName] = (layananMap[layananName] || 0) + 1;
      }
    });

    if (doughnutChart) {
      const totalWaktu = (pagi + siang + malam) || 1;
      doughnutChart.data.datasets[0].data = [
        ((pagi/totalWaktu)*100).toFixed(1), 
        ((siang/totalWaktu)*100).toFixed(1), 
        ((malam/totalWaktu)*100).toFixed(1)
      ];
      doughnutChart.update();
    }

    // Bar chart Top 5 memakai SELURUH data yg lolos filter (bukan dipotong ke 5 dulu),
    // supaya tombol ‹ › & persentase (terhadap total keseluruhan) tetap akurat.
    setBarChartFullData('chartLayanan', layananMap);
    setBarChartFullData('chartPoli', poliMap);
    setBarChartFullData('chartDiagnosa', diagnosaMap);

    // TOTAL / GROWTH RATE / AVG-HARI dihitung ulang mengikuti filter utama dashboard
    // dan tab Minggu/Bulan/Tahun yang sedang aktif di chart Analisis Pendapatan & Kunjungan.
    updateRevenueSubmetrics();
  }

  function executeTableFiltering(isDashboard = false) {
    let query = "", startVal = null, endVal = null, poliVal = "ALL";

    if (isDashboard) {
      startVal = dashStart && dashStart.value ? new Date(dashStart.value) : null;
      endVal = dashEnd && dashEnd.value ? new Date(dashEnd.value) : null;
      poliVal = dashPoli ? dashPoli.value : "ALL";
    } else {
      query = infoSearch ? infoSearch.value.toLowerCase().trim() : "";
      startVal = infoStart && infoStart.value ? new Date(infoStart.value) : null;
      endVal = infoEnd && infoEnd.value ? new Date(infoEnd.value) : null;
    }

    if (startVal) startVal.setHours(0,0,0,0);
    if (endVal) endVal.setHours(23,59,59,999);

    ['mainPembayaranTable', 'mainKunjunganTable'].forEach(tableId => {
      const table = document.getElementById(tableId);
      if(!table) return;
      const rows = table.querySelectorAll('tbody tr:not(.empty-row)');

      rows.forEach(row => {
        const searchData = row.getAttribute('data-search') || '';
        const dateData = row.getAttribute('data-date');
        const rowPoli = row.getAttribute('data-poli') || '';
        
        let rowDate = null;
        if (dateData) {
          const parts = dateData.split('-');
          if(parts.length === 3) rowDate = new Date(parts[0], parts[1] - 1, parts[2]);
        }

        let validSearch = true, validDate = true, validPoli = true;

        if (query && !searchData.includes(query)) validSearch = false;
        if (rowDate) {
          if (startVal && rowDate < startVal) validDate = false;
          if (endVal && rowDate > endVal) validDate = false;
        }
        if (poliVal !== "ALL" && rowPoli !== poliVal) validPoli = false;

        if (validSearch && validDate && validPoli) {
          row.removeAttribute('data-hidden-by-filter');
        } else {
          row.setAttribute('data-hidden-by-filter', 'true');
        }
      });
    });

    pembayaranCurrentPage = 1;
    kunjunganCurrentPage = 1;
    renderPembayaranPagination();
    renderKunjunganPagination();
  }

  function renderPembayaranPagination() {
    const table = document.getElementById('mainPembayaranTable');
    if (!table) return;
    const activeRows = Array.from(table.querySelectorAll('tbody tr:not(.empty-row)')).filter(r => r.getAttribute('data-hidden-by-filter') !== 'true');
    const totalPages = Math.ceil(activeRows.length / ROWS_PER_PAGE) || 1;

    table.querySelectorAll('tbody tr:not(.empty-row)').forEach(row => row.style.display = 'none');
    const startIdx = (pembayaranCurrentPage - 1) * ROWS_PER_PAGE;
    activeRows.slice(startIdx, startIdx + ROWS_PER_PAGE).forEach(row => row.style.display = '');

    const indicator = document.getElementById('pembayaranPageIndicator');
    if (indicator) indicator.textContent = `${pembayaranCurrentPage} / ${totalPages}`;
  }

  function renderKunjunganPagination() {
    const table = document.getElementById('mainKunjunganTable');
    if (!table) return;
    const activeRows = Array.from(table.querySelectorAll('tbody tr:not(.empty-row)')).filter(r => r.getAttribute('data-hidden-by-filter') !== 'true');
    const totalPages = Math.ceil(activeRows.length / ROWS_PER_PAGE) || 1;

    table.querySelectorAll('tbody tr:not(.empty-row)').forEach(row => row.style.display = 'none');
    const startIdx = (kunjunganCurrentPage - 1) * ROWS_PER_PAGE;
    activeRows.slice(startIdx, startIdx + ROWS_PER_PAGE).forEach(row => row.style.display = '');

    const indicator = document.getElementById('kunjunganPageIndicator');
    if (indicator) indicator.textContent = `${kunjunganCurrentPage} / ${totalPages}`;
  }

  // REPARASI FUNGSI RESET TERPADU (Sudah Bersih dari Typo)
  function resetDashboardFilter() {
    if(dashStart) dashStart.value = "";
    if(dashEnd) dashEnd.value = "";
    if(dashPoli) dashPoli.value = "ALL";
    
    document.querySelectorAll('#revenueFilters .filter-tab').forEach(tab => tab.classList.remove('active'));
    const defaultTab = document.querySelector('#revenueFilters .filter-tab[data-range="week"]');
    if(defaultTab) {
      defaultTab.classList.add('active'); // <--- Diperbaiki ke sintaks standar classList
    }
    currentActiveRange = 'week';

    if (revenueChart) {
      revenueChart.data.labels = DEFAULT_DASHBOARD_DATA.revenue.week.labels;
      revenueChart.data.datasets[0].data = DEFAULT_DASHBOARD_DATA.revenue.week.income; 
      revenueChart.data.datasets[1].data = DEFAULT_DASHBOARD_DATA.revenue.week.visit;  
      revenueChart.update();
    }

    if (doughnutChart) {
      doughnutChart.data.datasets[0].data = DEFAULT_DASHBOARD_DATA.jadwalShift;
      doughnutChart.update();
    }

    // Bar chart Top 5 dikembalikan ke data LENGKAP (semua baris tabel, tanpa filter),
    // supaya tombol ‹ › & persentase tetap akurat setelah reset.
    const resetMaps = collectFullMapsFromTables(false);
    setBarChartFullData('chartLayanan', resetMaps.layananMap);
    setBarChartFullData('chartPoli', resetMaps.poliMap);
    setBarChartFullData('chartDiagnosa', resetMaps.diagnosaMap);

    const keluhanMapReset = {};
    (DEFAULT_DASHBOARD_DATA.keluhan.labels || []).forEach((label, i) => {
      keluhanMapReset[label] = Number(DEFAULT_DASHBOARD_DATA.keluhan.data[i]) || 0;
    });
    setBarChartFullData('chartKeluhan', keluhanMapReset);

    executeTableFiltering(true);

    // TOTAL / GROWTH RATE / AVG-HARI dihitung ulang tanpa filter (memakai rentang default tab Minggu)
    updateRevenueSubmetrics();
  }

  function resetInfoFilter() {
    if (infoSearch) infoSearch.value = "";
    if (infoStart) infoStart.value = "";
    if (infoEnd) infoEnd.value = "";
    executeTableFiltering(false);
  }

  // Pagination Listeners dengan Pengaman Elvis Operator
  document.getElementById('btnPrevPembayaran')?.addEventListener('click', () => { if (pembayaranCurrentPage > 1) { pembayaranCurrentPage--; renderPembayaranPagination(); } });
  document.getElementById('btnNextPembayaran')?.addEventListener('click', () => {
    const activeCount = Array.from(document.querySelectorAll('#mainPembayaranTable tbody tr:not(.empty-row)')).filter(r => r.getAttribute('data-hidden-by-filter') !== 'true').length;
    if (pembayaranCurrentPage < Math.ceil(activeCount / ROWS_PER_PAGE)) { pembayaranCurrentPage++; renderPembayaranPagination(); }
  });
  document.getElementById('btnPrevKunjungan')?.addEventListener('click', () => { if (kunjunganCurrentPage > 1) { kunjunganCurrentPage--; renderKunjunganPagination(); } });
  document.getElementById('btnNextKunjungan')?.addEventListener('click', () => {
    const activeCount = Array.from(document.querySelectorAll('#mainKunjunganTable tbody tr:not(.empty-row)')).filter(r => r.getAttribute('data-hidden-by-filter') !== 'true').length;
    if (kunjunganCurrentPage < Math.ceil(activeCount / ROWS_PER_PAGE)) { kunjunganCurrentPage++; renderKunjunganPagination(); }
  });

  if(infoSearch) infoSearch.addEventListener('input', () => executeTableFiltering(false));
  if(infoStart) infoStart.addEventListener('change', () => executeTableFiltering(false));
  if(infoEnd) infoEnd.addEventListener('change', () => executeTableFiltering(false));

  // RUN PERTAMA KALI SAAT HALAMAN DI-LOAD
  document.addEventListener("DOMContentLoaded", () => {
    createHorizontalBarChart('chartLayanan', DEFAULT_DASHBOARD_DATA.layanan.labels, DEFAULT_DASHBOARD_DATA.layanan.data);
    createHorizontalBarChart('chartPoli', DEFAULT_DASHBOARD_DATA.poli.labels, DEFAULT_DASHBOARD_DATA.poli.data);
    createHorizontalBarChart('chartKeluhan', DEFAULT_DASHBOARD_DATA.keluhan.labels, DEFAULT_DASHBOARD_DATA.keluhan.data);
    createHorizontalBarChart('chartDiagnosa', DEFAULT_DASHBOARD_DATA.diagnosa.labels, DEFAULT_DASHBOARD_DATA.diagnosa.data);

    updateRevenue('week');
    renderPembayaranPagination();
    renderKunjunganPagination();
  });

  /* =========================================================
     4. EXPORT METODE PDF & EXCEL KHUSUS
     ========================================================= */
  function exportDashboardToPDF() {
    const element = document.getElementById('page-dashboard');
    if(typeof html2pdf !== 'undefined' && element) {
      const opt = {
        margin: 10, filename: 'Dashboard_Analisis_KlinikSehat.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
      };
      html2pdf().set(opt).from(element).save();
    }
  }

  async function exportDashboardToExcel() {
    if(typeof ExcelJS === 'undefined') return;
    const workbook = new ExcelJS.Workbook();
    const sheet = workbook.addWorksheet('Ringkasan Performa');
    sheet.mergeCells('A1:C1');
    sheet.getCell('A1').value = 'LAPORAN SUMMARY PERFORMA KLINIK SEHAT';
    sheet.getCell('A1').font = { size: 14, bold: true };
    sheet.addRow([]);
    sheet.addRow(['Metrik Utama', 'Nilai Capaian']);
    sheet.addRow(['Total Pasien Terdaftar', '{{ $totalPasien ?? 0 }}']);
    sheet.addRow(['Total Dokter Aktif', '{{ $dokterAktif ?? 0 }}']);
    sheet.addRow(['Kunjungan Hari Ini', '{{ $kunjunganHariIni ?? 0 }}']);
    const buffer = await workbook.xlsx.writeBuffer();
    if(typeof saveAs !== 'undefined') saveAs(new Blob([buffer]), 'Dashboard_Performa_KlinikSehat.xlsx');
  }

  async function exportDataToExcel() {
    if(typeof ExcelJS === 'undefined') return;
    const workbook = new ExcelJS.Workbook();
    const ws1 = workbook.addWorksheet('Daftar Pembayaran');
    ws1.columns = [{ header: 'Nama Pasien', key: 'nama', width: 25 }, { header: 'Tanggal', key: 'tgl', width: 16 }, { header: 'Layanan', key: 'layanan', width: 22 }, { header: 'Total Bayar', key: 'total', width: 18 }, { header: 'Status Bayar', key: 'status', width: 18 }];
    
    document.querySelectorAll('#mainPembayaranTable tbody tr:not(.empty-row)').forEach(row => {
      if (row.getAttribute('data-hidden-by-filter') !== 'true') {
        const tds = row.querySelectorAll('td');
        ws1.addRow({ nama: tds[0].innerText, tgl: tds[2].innerText, layanan: tds[3].innerText, total: tds[4].innerText, status: tds[5].innerText });
      }
    });
    const buffer = await workbook.xlsx.writeBuffer();
    if(typeof saveAs !== 'undefined') saveAs(new Blob([buffer]), 'Laporan_Data_KlinikSehat.xlsx');
  }

  function exportDataToPDF() {
    if(window.jspdf) {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF('p', 'pt', 'a4');
      doc.setFontSize(14); doc.text('LAPORAN DATA STRUKTUR KLINIK SEHAT', 40, 40);
      doc.save('Laporan_Data_KlinikSehat.pdf');
    }
  }
</script>
</body>
</html>