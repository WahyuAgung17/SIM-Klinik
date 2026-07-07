@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

@section('content_header')
    <h1>Manajemen Mahasiswa (SIAKAD)</h1>
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
    @php
        $prodiOptions = [
            1 => 'Sistem Informasi',
            2 => 'Teknik Informatika',
            3 => 'Teknik Komputer',
            4 => 'TRPL',
        ];
    @endphp

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa Aktif</h3>
            <div class="card-tools">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Data
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

            <table id="tableMahasiswa" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $prodiOptions[(int) $item->id_prodi] ?? '-' }}</td>
                            <td>
                                @if ($item->status_keaktifan)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="action-buttons">
                                <button
                                    type="button"
                                    class="btn btn-xs btn-default text-primary mx-1 shadow btn-edit"
                                    data-id="{{ $item->id }}"
                                    data-nim="{{ $item->nim }}"
                                    data-nama="{{ $item->nama }}"
                                    data-prodi="{{ $item->id_prodi }}"
                                    data-status="{{ (int) $item->status_keaktifan }}"
                                    title="Edit"
                                >
                                    <i class="fa fa-pen"></i>
                                </button>

                                <form action="{{ url('/mahasiswa/hapus/' . $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');">
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
            <form action="{{ url('/mahasiswa/simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input
                                type="text"
                                name="nim"
                                id="nim"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('nim') ? 'is-invalid' : '' }}"
                                value="{{ old('form_type') === 'create' ? old('nim') : '' }}"
                            >
                            @if (old('form_type') === 'create')
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Mahasiswa</label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('nama') ? 'is-invalid' : '' }}"
                                value="{{ old('form_type') === 'create' ? old('nama') : '' }}"
                            >
                            @if (old('form_type') === 'create')
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select
                                name="prodi"
                                id="prodi"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('prodi') ? 'is-invalid' : '' }}"
                            >
                                @foreach ($prodiOptions as $value => $label)
                                    <option value="{{ $value }}" @selected((int) old('prodi', 1) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'create')
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status Mahasiswa</label>
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statusSwitch"
                                    name="status_keaktifan"
                                    value="1"
                                    @checked(old('form_type') === 'create' ? old('status_keaktifan', 1) : true)
                                >
                                <label class="custom-control-label" for="statusSwitch">Aktif</label>
                            </div>
                            @if (old('form_type') === 'create')
                                @error('status_keaktifan')
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
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nim">NIM</label>
                            <input
                                type="text"
                                name="nim"
                                id="edit_nim"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('nim') ? 'is-invalid' : '' }}"
                            >
                            @if (old('form_type') === 'update')
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="edit_nama">Nama</label>
                            <input
                                type="text"
                                name="nama"
                                id="edit_nama"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('nama') ? 'is-invalid' : '' }}"
                            >
                            @if (old('form_type') === 'update')
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="edit_prodi">Program Studi</label>
                            <select
                                name="prodi"
                                id="edit_prodi"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('prodi') ? 'is-invalid' : '' }}"
                            >
                                @foreach ($prodiOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'update')
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_status" name="status_keaktifan" value="1">
                                <label class="custom-control-label" for="edit_status">Aktif</label>
                            </div>
                            @if (old('form_type') === 'update')
                                @error('status_keaktifan')
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
            const editModal = $('#modalEdit');
            const createModal = $('#modalTambah');
            const editForm = document.getElementById('formEdit');
            const editIdField = document.getElementById('edit_id');
            const editNimField = document.getElementById('edit_nim');
            const editNamaField = document.getElementById('edit_nama');
            const editProdiField = document.getElementById('edit_prodi');
            const editStatusField = document.getElementById('edit_status');
            const updateBaseUrl = @json(url('/mahasiswa'));

            function setEditFormAction(id) {
                editForm.action = `${updateBaseUrl}/${id}`;
            }

            function fillEditForm(data) {
                editIdField.value = data.id;
                editNimField.value = data.nim;
                editNamaField.value = data.nama;
                editProdiField.value = String(data.prodi);
                editStatusField.checked = Number(data.status) === 1;
                setEditFormAction(data.id);
            }

            document.querySelectorAll('.btn-edit').forEach((button) => {
                button.addEventListener('click', function () {
                    fillEditForm({
                        id: this.dataset.id,
                        nim: this.dataset.nim,
                        nama: this.dataset.nama,
                        prodi: this.dataset.prodi,
                        status: this.dataset.status,
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
                    nim: @json(old('nim')),
                    nama: @json(old('nama')),
                    prodi: @json(old('prodi')),
                    status: @json(old('status_keaktifan', 0)),
                });
                editModal.modal('show');
            @endif
        })();
    </script>
@endsection
