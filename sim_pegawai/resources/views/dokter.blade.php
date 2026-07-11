@extends('adminlte::page')
@section('title', 'Data Dokter')

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
        
        /* Avatar & Foto Dokter */
        .avatar-box { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb; width: 45px; height: 45px; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; box-shadow: 0 2px 5px rgba(37,99,235,0.15); border: 2px solid #ffffff; }
        .foto-dokter-table { width: 45px; height: 45px; border-radius: 12px; object-fit: cover; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 2px solid #ffffff; }
        
        /* Badge & Tombol */
        .badge-modern { padding: 0.5em 1em; border-radius: 8px; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.5px; }
        .bg-soft-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
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
        
        /* Input File Custom */
        .custom-file-input-wrapper { background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 10px; text-align: center; }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid mt-3">
        <div class="page-header-custom d-flex justify-content-between align-items-center flex-wrap">
            <div class="mb-2 mb-md-0">
                <h1 class="m-0"><i class="fas fa-user-md mr-2"></i> Manajemen Dokter</h1>
                <p class="mb-0 mt-1"><i class="fas fa-info-circle mr-1"></i> Kelola data dokter, foto profil, dan penempatan poli.</p>
            </div>
            <div>
                <button class="btn btn-tambah-header" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Data Dokter
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold" style="color: #0f172a; font-size: 1.1rem;">
                <i class="fas fa-list-ul mr-2 text-primary"></i> Daftar Dokter Klinik
            </h3>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th>Profil Dokter & SIP</th>
                            <th>Penempatan Poli</th>
                            <th>Kontak</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 12%;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokters as $index => $d)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if($d->foto)
                                            <img src="{{ asset('storage/' . $d->foto) }}" class="foto-dokter-table" alt="Foto {{ $d->nama_dokter }}">
                                        @else
                                            <div class="avatar-box">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color: #0f172a; font-size: 1.05rem;">{{ $d->nama_dokter }}</div>
                                        <div style="color: #64748b; font-size: 0.85rem;"><i class="fas fa-id-card mr-1"></i> SIP/Kode: {{ $d->kode_dokter }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #334155; font-weight: 700;">{{ $d->spesialisasi }}</div>
                                <div style="color: #3b82f6; font-size: 0.85rem;"><i class="fas fa-clinic-medical mr-1"></i> {{ $d->poli->nama_poli ?? 'Poli Dihapus' }}</div>
                            </td>
                            <td>
                                <span style="color: #475569;"><i class="fas fa-phone-alt text-muted mr-1"></i> {{ $d->no_hp }}</span>
                            </td>
                            <td class="text-center">
                                @if($d->status == 'aktif')
                                    <span class="badge-modern bg-soft-success"><i class="fas fa-check-circle mr-1"></i> Praktik</span>
                                @else
                                    <span class="badge-modern bg-soft-danger"><i class="fas fa-ban mr-1"></i> Cuti/Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-modern btn-edit btn-sm" data-toggle="modal" data-target="#modalEdit{{ $d->id }}" title="Ubah Data">
                                    <i class="fas fa-pen mr-1"></i> Edit
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $d->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form action="/dokter/{{ $d->id }}" method="POST" enctype="multipart/form-data">
                                        @csrf 
                                        @method('PUT')
                                        <div class="modal-header bg-white">
                                            <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-user-edit text-warning mr-2"></i> Ubah Data Dokter</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-white">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NAMA DOKTER <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                                                            <input type="text" name="nama_dokter" class="form-control font-weight-bold" value="{{ $d->nama_dokter }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">KODE DOKTER / SIP <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></div>
                                                            <input type="text" name="kode_dokter" class="form-control" value="{{ $d->kode_dokter }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">SPESIALISASI <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-certificate"></i></span></div>
                                                            <input type="text" name="spesialisasi" class="form-control" value="{{ $d->spesialisasi }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">PENEMPATAN POLI <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clinic-medical"></i></span></div>
                                                            <select name="poli_id" class="custom-select font-weight-bold" required>
                                                                <option value="" disabled>-- Pilih Poli --</option>
                                                                @foreach($polis as $poli)
                                                                    <option value="{{ $poli->id }}" {{ $d->poli_id == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-5">
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">FOTO PROFIL (OPSIONAL)</label>
                                                        <div class="custom-file-input-wrapper">
                                                            @if($d->foto)
                                                                <img src="{{ asset('storage/' . $d->foto) }}" alt="Foto Lama" class="img-thumbnail mb-2" style="max-height: 100px;">
                                                                <p class="text-muted" style="font-size: 0.75rem;">Upload gambar baru untuk mengganti foto ini.</p>
                                                            @else
                                                                <div class="mb-2" style="color: #94a3b8;"><i class="fas fa-cloud-upload-alt fa-3x"></i></div>
                                                            @endif
                                                            <input type="file" name="foto" class="form-control-file border-0 bg-transparent" accept="image/*">
                                                        </div>
                                                        <small class="text-muted mt-1 d-block">Format: JPG/PNG, Maks: 2MB.</small>
                                                    </div>
                                                    
                                                    <div class="form-group mb-3">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NO TELEPON <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                                            <input type="text" name="no_hp" class="form-control" value="{{ $d->no_hp }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group mb-0">
                                                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">STATUS PRAKTIK</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-toggle-on"></i></span></div>
                                                            <select name="status" class="custom-select font-weight-bold" style="color: {{ $d->status == 'aktif' ? '#166534' : '#991b1b' }};">
                                                                <option value="aktif" {{ $d->status == 'aktif' ? 'selected' : '' }}>Aktif Praktik</option>
                                                                <option value="tidak aktif" {{ $d->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                                            <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                                            <button type="submit" class="btn btn-warning font-weight-bold text-dark px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><div class="card-footer bg-white border-top-0 d-flex justify-content-end pt-3">
            {{ $dokters->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="/dokter" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-white">
                    <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-user-plus text-primary mr-2"></i> Tambah Dokter Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group mb-3">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NAMA DOKTER <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                                    <input type="text" name="nama_dokter" class="form-control" placeholder="Cth: dr. Budi Santoso" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">KODE DOKTER / SIP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></div>
                                    <input type="text" name="kode_dokter" class="form-control" placeholder="Masukkan Nomor SIP" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">SPESIALISASI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-certificate"></i></span></div>
                                    <input type="text" name="spesialisasi" class="form-control" placeholder="Cth: Spesialis Anak" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">PENEMPATAN POLI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clinic-medical"></i></span></div>
                                    <select name="poli_id" class="custom-select font-weight-bold" required>
                                        <option value="" selected disabled>-- Pilih Poli Penempatan --</option>
                                        @foreach($polis as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">FOTO PROFIL (OPSIONAL)</label>
                                <div class="custom-file-input-wrapper">
                                    <div class="mb-2" style="color: #94a3b8;"><i class="fas fa-cloud-upload-alt fa-3x"></i></div>
                                    <input type="file" name="foto" class="form-control-file border-0 bg-transparent" accept="image/*">
                                </div>
                                <small class="text-muted mt-1 d-block">Pilih gambar dari komputer Anda. (Maks: 2MB).</small>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NO TELEPON <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                    <input type="number" name="no_hp" class="form-control" placeholder="0812..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                    <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Data</button>
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
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: `
                        <ul class="text-left mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    confirmButtonText: 'Periksa Kembali',
                    confirmButtonColor: '#e3342f'
                });
            @endif
        });
    </script>
@endsection