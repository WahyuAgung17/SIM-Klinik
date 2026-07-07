@extends('adminlte::page')

@section('title', 'Dosen Wali Mahasiswa')

@section('content_header')
    <h1>Manajemen Dosen Wali Mahasiswa (SIAKAD)</h1>
@endsection

@section('css')
    <style>
        .action-buttons {
            white-space: nowrap;
        }

        .modal .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Dosen Wali Mahasiswa</h3>
            <div class="card-tools">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Relasi
                </a>
                <button type="button" class="btn btn-default btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan validasi.</strong>
                    <ul class="mb-0 mt-2 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table id="tableDosenWaliMahasiswa" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th>Dosen Wali</th>
                        <th>NIP Dosen Wali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->mahasiswa?->nim ?? '-' }}</td>
                            <td>{{ $item->mahasiswa?->nama ?? '-' }}</td>
                            <td>{{ $item->mahasiswa?->prodi_label ?? '-' }}</td>
                            <td>
                                @if ($item->mahasiswa?->status_keaktifan)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $item->dosenWali?->nama ?? '-' }}</td>
                            <td>{{ $item->dosenWali?->nip ?? '-' }}</td>
                            <td class="action-buttons">
                                <button
                                    type="button"
                                    class="btn btn-xs btn-default text-primary mx-1 shadow btn-edit"
                                    data-id="{{ $item->id }}"
                                    data-mahasiswa-id="{{ $item->mahasiswa_id }}"
                                    data-dosen-wali-id="{{ $item->dosen_wali_id }}"
                                    title="Edit"
                                >
                                    <i class="fa fa-pen"></i>
                                </button>

                                <form action="{{ url('/dosen-wali-mahasiswa/hapus/' . $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus relasi dosen wali mahasiswa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('/dosen-wali-mahasiswa/simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Dosen Wali Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mahasiswa_id">Mahasiswa</label>
                            <select
                                name="mahasiswa_id"
                                id="mahasiswa_id"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('mahasiswa_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih mahasiswa</option>
                                @foreach ($mahasiswaOptions as $item)
                                    <option value="{{ $item->id }}" @selected((int) old('mahasiswa_id') === (int) $item->id)>
                                        {{ $item->nim }} - {{ $item->nama }} ({{ $prodiOptions[(int) $item->id_prodi] ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'create')
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="dosen_wali_id">Dosen Wali</label>
                            <select
                                name="dosen_wali_id"
                                id="dosen_wali_id"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('dosen_wali_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih dosen wali</option>
                                @foreach ($dosenOptions as $item)
                                    <option value="{{ $item->id }}" @selected((int) old('dosen_wali_id') === (int) $item->id)>
                                        {{ $item->nama }} ({{ $item->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'create')
                                @error('dosen_wali_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Dosen Wali Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_mahasiswa_id">Mahasiswa</label>
                            <select
                                name="mahasiswa_id"
                                id="edit_mahasiswa_id"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('mahasiswa_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih mahasiswa</option>
                                @foreach ($mahasiswaOptions as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nim }} - {{ $item->nama }} ({{ $prodiOptions[(int) $item->id_prodi] ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'update')
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="edit_dosen_wali_id">Dosen Wali</label>
                            <select
                                name="dosen_wali_id"
                                id="edit_dosen_wali_id"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('dosen_wali_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih dosen wali</option>
                                @foreach ($dosenOptions as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->nip }})</option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'update')
                                @error('dosen_wali_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            $('#tableDosenWaliMahasiswa').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                },
            });

            const editModal = $('#modalEdit');
            const createModal = $('#modalTambah');
            const editForm = document.getElementById('formEdit');
            const editIdField = document.getElementById('edit_id');
            const editMahasiswaField = document.getElementById('edit_mahasiswa_id');
            const editDosenWaliField = document.getElementById('edit_dosen_wali_id');
            const updateBaseUrl = @json(url('/dosen-wali-mahasiswa'));

            function setEditFormAction(id) {
                editForm.action = `${updateBaseUrl}/${id}`;
            }

            function fillEditForm(data) {
                editIdField.value = data.id;
                editMahasiswaField.value = data.mahasiswaId ? String(data.mahasiswaId) : '';
                editDosenWaliField.value = data.dosenWaliId ? String(data.dosenWaliId) : '';
                setEditFormAction(data.id);
            }

            document.querySelectorAll('.btn-edit').forEach((button) => {
                button.addEventListener('click', function () {
                    fillEditForm({
                        id: this.dataset.id,
                        mahasiswaId: this.dataset.mahasiswaId,
                        dosenWaliId: this.dataset.dosenWaliId,
                    });

                    editModal.modal('show');
                });
            });

            @if (old('form_type') === 'create' && $errors->any())
                createModal.modal('show');
            @endif

            @if (old('form_type') === 'update' && $errors->any())
                fillEditForm({
                    id: @json(old('edit_id')),
                    mahasiswaId: @json(old('mahasiswa_id')),
                    dosenWaliId: @json(old('dosen_wali_id')),
                });
                editModal.modal('show');
            @endif
        })();
    </script>
@endsection
