@extends('adminlte::page')
@section('title', 'Jadwal Praktik Dokter')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');
        body, .content-wrapper { font-family: 'Nunito', sans-serif !important; background-color: #f0f4f8 !important; }
        
        /* BANNER HEADER */
        .page-header-custom { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); border-radius: 16px; padding: 25px 30px; color: white; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15); margin-bottom: 25px; position: relative; overflow: hidden; }
        .page-header-custom::after { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; }
        .page-header-custom h1 { color: white !important; font-weight: 800; font-size: 1.8rem; margin-bottom: 5px; z-index: 2; position: relative; }
        .page-header-custom p { color: #e0f2fe; font-size: 0.95rem; font-weight: 400; z-index: 2; position: relative; }
        .btn-tambah-header { background-color: #ffffff; color: #2563eb; font-weight: 800; border-radius: 10px; padding: 0.6rem 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s; border: none; z-index: 2; position: relative; }
        .btn-tambah-header:hover { background-color: #f8fafc; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.15); color: #1d4ed8; }

        /* Card & Table */
        .card-custom { border: none; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid #3b82f6; overflow: hidden; }
        .card-header-custom { background-color: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; }
        .table thead th { background-color: #f8fafc; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; border-top: none; }
        .table tbody td { padding: 1rem 1.2rem; vertical-align: middle; border-top: 1px solid #f1f5f9; color: #334155; }
        
        /* Ikon Kalender */
        .icon-box { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb; width: 45px; height: 45px; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; box-shadow: 0 2px 5px rgba(37,99,235,0.15); border: 2px solid #ffffff; }
        
        /* Badge & Tombol */
        .badge-modern { padding: 0.5em 1em; border-radius: 8px; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.5px; display: inline-block; }
        .bg-soft-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .bg-soft-warning { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .bg-soft-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .btn-edit { background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; border-radius: 8px; font-weight: 700; padding: 0.4rem 1rem; transition: all 0.2s; }
        .btn-edit:hover { background-color: #fef3c7; color: #b45309; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); }

        /* Modal */
        .modal-content { border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .modal-header { border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom: 2px solid #f1f5f9; padding: 1.5rem; }
        .modal-body { padding: 1.5rem; }
        .form-control, .custom-select { border-radius: 10px; border: 1px solid #cbd5e1; padding: 0.6rem 1rem; background-color: #f8fafc; }
        .form-control:focus, .custom-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); background-color: #ffffff; }
        .input-group-text { border-radius: 10px 0 0 10px; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #64748b; border-right: none; }
        .input-group .form-control { border-left: none; padding-left: 0; }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid mt-3">
        <div class="page-header-custom d-flex justify-content-between align-items-center flex-wrap">
            <div class="mb-2 mb-md-0">
                <h1 class="m-0"><i class="fas fa-calendar-alt mr-2"></i> Jadwal Praktik</h1>
                <p class="mb-0 mt-1"><i class="fas fa-info-circle mr-1"></i> Atur hari dan jam praktik masing-masing dokter di klinik.</p>
            </div>
            <div>
                <button class="btn btn-tambah-header" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Jadwal Praktik
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show card-custom mb-4 px-4 py-3" style="..." role="alert">
            <i class="fas fa-check-circle mr-2 fa-lg"></i> <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close" style="opacity: 0.8; text-shadow: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold" style="color: #0f172a; font-size: 1.1rem;">
                <i class="fas fa-list-ul mr-2 text-primary"></i> Daftar Jadwal Dokter
            </h3>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th>Nama Dokter</th>
                            <th>Hari Praktik</th>
                            <th>Jam Praktik</th>
                            <th class="text-center">Status Jadwal</th>
                            <th class="text-center" style="width: 12%;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $index => $j)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box mr-3">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color: #0f172a; font-size: 1.05rem;">
                                            {{ $j->dokter->nama_dokter ?? 'Dokter Dihapus/Tidak Ditemukan' }}
                                        </div>
                                        <div style="color: #64748b; font-size: 0.85rem;"><i class="fas fa-clinic-medical mr-1"></i> Poli: {{ $j->dokter->poli->nama_poli ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #334155; font-weight: 800; font-size: 1.1rem;">{{ $j->hari }}</div>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB</span>
                            </td>
                            <td class="text-center">
                                @if($j->status == 'tersedia')
                                    <span class="badge-modern bg-soft-success"><i class="fas fa-check mr-1"></i> Tersedia</span>
                                @elseif($j->status == 'penuh')
                                    <span class="badge-modern bg-soft-warning"><i class="fas fa-users mr-1"></i> Kuota Penuh</span>
                                @else
                                    <span class="badge-modern bg-soft-danger"><i class="fas fa-ban mr-1"></i> Tutup/Libur</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-modern btn-edit btn-sm" data-toggle="modal" data-target="#modalEdit{{ $j->id }}" title="Ubah Jadwal">
                                    <i class="fas fa-pen mr-1"></i> Edit Jadwal
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $j->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="/jadwal/{{ $j->id }}" method="POST">
                                        @csrf 
                                        @method('PUT')
                                        <div class="modal-header bg-white">
                                            <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-calendar-check text-warning mr-2"></i> Ubah Jadwal Praktik</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-white">
                                            <div class="form-group mb-4">
                                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">PILIH DOKTER <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                                                    <select name="dokter_id" class="custom-select font-weight-bold" required>
                                                        @foreach($dokters as $dokter)
                                                            <option value="{{ $dokter->id }}" {{ $j->dokter_id == $dokter->id ? 'selected' : '' }}>
                                                                {{ $dokter->nama_dokter }} ({{ $dokter->spesialisasi }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-4">
                                                    <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">HARI PRAKTIK <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-day"></i></span></div>
                                                        <select name="hari" class="custom-select font-weight-bold" required>
                                                            <option value="Senin" {{ $j->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                                                            <option value="Selasa" {{ $j->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                                            <option value="Rabu" {{ $j->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                                            <option value="Kamis" {{ $j->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                                            <option value="Jumat" {{ $j->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                                            <option value="Sabtu" {{ $j->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                                            <option value="Minggu" {{ $j->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group mb-4">
                                                    <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">STATUS JADWAL</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-info-circle"></i></span></div>
                                                        <select name="status" class="custom-select font-weight-bold">
                                                            <option value="tersedia" {{ $j->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                            <option value="penuh" {{ $j->status == 'penuh' ? 'selected' : '' }}>Penuh</option>
                                                            <option value="tutup" {{ $j->status == 'tutup' ? 'selected' : '' }}>Tutup/Libur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group mb-0">
                                                    <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">JAM MULAI <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div>
                                                        <input type="time" name="jam_mulai" class="form-control font-weight-bold text-primary" value="{{ $j->jam_mulai }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group mb-0">
                                                    <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">JAM SELESAI <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div>
                                                        <input type="time" name="jam_selesai" class="form-control font-weight-bold text-danger" value="{{ $j->jam_selesai }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 1.2rem 1.5rem;">
                                            <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                                            <button type="submit" class="btn btn-warning font-weight-bold text-dark px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($jadwals->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="color: #94a3b8;"><i class="fas fa-calendar-times fa-4x mb-3"></i></div>
                                <h5 class="text-muted font-weight-bold">Tidak ada Jadwal Praktik</h5>
                                <p class="text-muted mb-0" style="font-size: 0.95rem;">Silakan tambahkan jadwal praktik untuk dokter yang tersedia.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div> <div class="card-footer bg-white border-top-0 d-flex justify-content-end pt-3">
            {{ $jadwals->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/jadwal" method="POST">
                @csrf
                <div class="modal-header bg-white">
                    <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-calendar-plus text-primary mr-2"></i> Tambah Jadwal Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white">
                    <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">PILIH DOKTER <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                            <select name="dokter_id" class="custom-select font-weight-bold" required>
                                <option value="" selected disabled>-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }} ({{ $dokter->spesialisasi }})</option>
                                @endforeach
                            </select>
                        </div>
                        @if($dokters->isEmpty())
                            <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle"></i> Anda harus membuat Data Dokter terlebih dahulu!</small>
                        @endif
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">HARI PRAKTIK <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-day"></i></span></div>
                            <select name="hari" class="custom-select font-weight-bold" required>
                                <option value="" selected disabled>-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-0">
                            <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">JAM MULAI <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div>
                                <input type="time" name="jam_mulai" class="form-control font-weight-bold text-primary" required>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-0">
                            <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">JAM SELESAI <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div>
                                <input type="time" name="jam_selesai" class="form-control font-weight-bold text-danger" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 1.2rem 1.5rem;">
                    <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm" {{ $dokters->isEmpty() ? 'disabled' : '' }}><i class="fas fa-save mr-1"></i> Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Animasi Pop-up jika data berhasil disimpan/diubah
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500, // Hilang otomatis dalam 2,5 detik
                    backdrop: `rgba(0,0,0,0.4)` // Efek redup di latar belakang
                });
            @endif

            // Animasi Pop-up jika ada error validasi (Gagal Simpan)
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan!',
                    text: 'Terdapat kesalahan pada inputan Anda. Silakan periksa kembali form pengisian.',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#e3342f'
                });
            @endif
        });
    </script>
@endsection