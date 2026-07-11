@extends('adminlte::page')
@section('title', 'Manajemen Akun Sistem')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');
        body, .content-wrapper { font-family: 'Nunito', sans-serif !important; background-color: #f0f4f8 !important; }
        
        /* BANNER HEADER */
        .page-header-custom { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 16px; padding: 25px 30px; color: white; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); margin-bottom: 25px; position: relative; overflow: hidden; }
        .page-header-custom::after { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        .page-header-custom h1 { color: white !important; font-weight: 800; font-size: 1.8rem; margin-bottom: 5px; z-index: 2; position: relative; }
        .page-header-custom p { color: #cbd5e1; font-size: 0.95rem; font-weight: 400; z-index: 2; position: relative; }
        .btn-tambah-header { background-color: #3b82f6; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 0.6rem 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s; border: none; z-index: 2; position: relative; }
        .btn-tambah-header:hover { background-color: #2563eb; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(37,99,235,0.2); color: white; }

        /* Card & Table */
        .card-custom { border: none; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid #1e293b; overflow: hidden; }
        .card-header-custom { background-color: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; }
        .table thead th { background-color: #f8fafc; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; border-top: none; }
        .table tbody td { padding: 1rem 1.2rem; vertical-align: middle; border-top: 1px solid #f1f5f9; color: #334155; }
        
        /* Ikon & Badge Role */
        .icon-box { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); color: #334155; width: 45px; height: 45px; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 2px solid #ffffff; }
        .badge-modern { padding: 0.5em 1em; border-radius: 8px; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.5px; }
        
        /* Pewarnaan Role Khusus */
        .role-admin { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .role-dokter { background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .role-petugas { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .role-kasir { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .role-kepala { background-color: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }

        .btn-edit { background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; border-radius: 8px; font-weight: 700; padding: 0.4rem 1rem; transition: all 0.2s; }
        .btn-edit:hover { background-color: #fef3c7; color: #b45309; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); }

        /* Modal */
        .modal-content { border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .modal-header { border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom: 2px solid #f1f5f9; padding: 1.5rem; }
        .modal-body { padding: 1.5rem; }
        .form-control, .custom-select { border-radius: 10px; border: 1px solid #cbd5e1; padding: 0.6rem 1rem; background-color: #f8fafc; }
        .form-control:focus, .custom-select:focus { border-color: #1e293b; box-shadow: 0 0 0 4px rgba(30, 41, 59, 0.1); background-color: #ffffff; }
        .input-group-text { border-radius: 10px 0 0 10px; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #64748b; border-right: none; }
        .input-group .form-control { border-left: none; padding-left: 0; }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid mt-3">
        <div class="page-header-custom d-flex justify-content-between align-items-center flex-wrap">
            <div class="mb-2 mb-md-0">
                <h1 class="m-0"><i class="fas fa-user-shield mr-2"></i> Pengaturan Akun & Akses</h1>
                <p class="mb-0 mt-1"><i class="fas fa-lock mr-1"></i> Buat kredensial login (Email & Password) dan atur hak akses (Role) staf.</p>
            </div>
            <div>
                <button class="btn btn-tambah-header" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-user-plus mr-1"></i> Buat Akun Baru
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show card-custom mb-4 px-4 py-3" style="border: none; border-radius: 12px;" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Pendaftaran Gagal!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                <i class="fas fa-users-cog mr-2 text-dark"></i> Daftar Pengguna Sistem
            </h3>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th>Profil Pengguna</th>
                            <th>Email Login</th>
                            <th class="text-center">Hak Akses (Role)</th>
                            <th class="text-center" style="width: 12%;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box mr-3">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color: #0f172a; font-size: 1.05rem;">{{ $u->name }}</div>
                                        <div style="color: #64748b; font-size: 0.8rem;">Dibuat: {{ $u->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #334155; font-weight: 700;"><i class="fas fa-envelope text-muted mr-1"></i> {{ $u->email }}</div>
                            </td>
                            <td class="text-center">
                                @if($u->role == 'Admin')
                                    <span class="badge-modern role-admin"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                                @elseif($u->role == 'Dokter')
                                    <span class="badge-modern role-dokter"><i class="fas fa-stethoscope mr-1"></i> Dokter</span>
                                @elseif($u->role == 'Petugas Pendaftaran')
                                    <span class="badge-modern role-petugas"><i class="fas fa-headset mr-1"></i> Petugas Pendaftaran</span>
                                @elseif($u->role == 'Kasir')
                                    <span class="badge-modern role-kasir"><i class="fas fa-cash-register mr-1"></i> Kasir</span>
                                @else
                                    <span class="badge-modern role-kepala"><i class="fas fa-user-tie mr-1"></i> Kepala Klinik</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-modern btn-edit btn-sm" data-toggle="modal" data-target="#modalEdit{{ $u->id }}" title="Ubah Akun">
                                    <i class="fas fa-user-edit mr-1"></i> Kelola
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="/user/{{ $u->id }}" method="POST">
                                        @csrf 
                                        @method('PUT')
                                        <div class="modal-header bg-white">
                                            <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-user-edit text-warning mr-2"></i> Ubah Data Akun</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-white">
                                            <div class="form-group mb-4">
                                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NAMA PENGGUNA <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-badge"></i></span></div>
                                                    <input type="text" name="name" class="form-control font-weight-bold" value="{{ $u->name }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group mb-4">
                                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">EMAIL LOGIN <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                                    <input type="email" name="email" class="form-control font-weight-bold" value="{{ $u->email }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">HAK AKSES (ROLE) <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-tag"></i></span></div>
                                                    <select name="role" class="custom-select font-weight-bold" required>
                                                        <option value="Admin" {{ $u->role == 'Admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                                                        <option value="Petugas Pendaftaran" {{ $u->role == 'Petugas Pendaftaran' ? 'selected' : '' }}>Petugas Pendaftaran</option>
                                                        <option value="Dokter" {{ $u->role == 'Dokter' ? 'selected' : '' }}>Dokter (Medis)</option>
                                                        <option value="Kasir" {{ $u->role == 'Kasir' ? 'selected' : '' }}>Kasir (Keuangan)</option>
                                                        <option value="Kepala Klinik" {{ $u->role == 'Kepala Klinik' ? 'selected' : '' }}>Kepala Klinik (Laporan)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group mb-0">
                                                <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">UBAH PASSWORD</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                                </div>
                                                <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle"></i> Hanya isi bagian ini jika pengguna lupa passwordnya.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 1.2rem 1.5rem;">
                                            <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                                            <button type="submit" class="btn btn-warning font-weight-bold text-dark px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Pembaruan</button>
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
            {{ $users->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/user" method="POST">
                @csrf
                <div class="modal-header bg-white">
                    <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fas fa-user-plus text-primary mr-2"></i> Buat Akun Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white">
                    <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">NAMA PENGGUNA <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-badge"></i></span></div>
                            <input type="text" name="name" class="form-control" placeholder="Nama asli pegawai/staf" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">EMAIL LOGIN <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                            <input type="email" name="email" class="form-control" placeholder="email@klinik.com" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">HAK AKSES (ROLE) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-tag"></i></span></div>
                            <select name="role" class="custom-select font-weight-bold" required>
                                <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                <option value="Admin">Admin (Akses Penuh)</option>
                                <option value="Petugas Pendaftaran">Petugas Pendaftaran</option>
                                <option value="Dokter">Dokter (Medis)</option>
                                <option value="Kasir">Kasir (Keuangan)</option>
                                <option value="Kepala Klinik">Kepala Klinik (Laporan)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="text-muted font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">PASSWORD AWAL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                            <input type="password" name="password" class="form-control" placeholder="Buat password (min. 5 karakter)" required minlength="5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 1.2rem 1.5rem;">
                    <button type="button" class="btn btn-light border font-weight-bold text-muted mr-2" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Buat Akun</button>
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
                    title: 'Gagal Menyimpan!',
                    text: 'Terdapat kesalahan pada inputan Anda. Silakan periksa kembali form pengisian.',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#e3342f'
                });
            @endif
        });
    </script>
@endsection