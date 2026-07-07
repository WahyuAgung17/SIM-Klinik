@extends('adminlte::page')

@section('title', 'Data Mata Kuliah')

@section('content_header')
    <h1>Manajemen Mata Kuliah (SIAKAD)</h1>
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
            <h3 class="card-title">Daftar Mata Kuliah</h3>
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

            <table id="tableMataKuliah" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>Prodi</th>
                        <th>Semester</th>
                        <th>SKS</th>
                        <th>Dosen Pengampu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->prodi_label }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->sks }}</td>
                            <td>{{ $item->dosenPengampu?->nama ?? '-' }}</td>
                            <td>
                                @if ($item->status_aktif)
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
                                    data-kode="{{ $item->kode }}"
                                    data-nama="{{ $item->nama }}"
                                    data-prodi="{{ $item->id_prodi }}"
                                    data-sks="{{ $item->sks }}"
                                    data-semester="{{ $item->semester }}"
                                    data-dosen-pengampu-id="{{ $item->dosen_pengampu_id }}"
                                    data-status="{{ (int) $item->status_aktif }}"
                                    title="Edit"
                                >
                                    <i class="fa fa-pen"></i>
                                </button>

                                <form action="{{ url('/mata-kuliah/hapus/' . $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data mata kuliah ini?');">
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
            <form action="{{ url('/mata-kuliah/simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Mata Kuliah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode">Kode Mata Kuliah</label>
                            <input
                                type="text"
                                name="kode"
                                id="kode"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('kode') ? 'is-invalid' : '' }}"
                                value="{{ old('form_type') === 'create' ? old('kode') : '' }}"
                            >
                            @if (old('form_type') === 'create')
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Mata Kuliah</label>
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

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="sks">SKS</label>
                                <input
                                    type="number"
                                    name="sks"
                                    id="sks"
                                    min="1"
                                    max="6"
                                    class="form-control {{ old('form_type') === 'create' && $errors->has('sks') ? 'is-invalid' : '' }}"
                                    value="{{ old('form_type') === 'create' ? old('sks', 2) : 2 }}"
                                >
                                @if (old('form_type') === 'create')
                                    @error('sks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="semester">Semester</label>
                                <input
                                    type="number"
                                    name="semester"
                                    id="semester"
                                    min="1"
                                    max="14"
                                    class="form-control {{ old('form_type') === 'create' && $errors->has('semester') ? 'is-invalid' : '' }}"
                                    value="{{ old('form_type') === 'create' ? old('semester', 1) : 1 }}"
                                >
                                @if (old('form_type') === 'create')
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
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
                            <label for="dosen_pengampu_id">Dosen Pengampu</label>
                            <select
                                name="dosen_pengampu_id"
                                id="dosen_pengampu_id"
                                class="form-control {{ old('form_type') === 'create' && $errors->has('dosen_pengampu_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih dosen pengampu</option>
                                @foreach ($dosenOptions as $item)
                                    <option value="{{ $item->id }}" @selected((int) old('dosen_pengampu_id') === (int) $item->id)>
                                        {{ $item->nama }} ({{ $item->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'create')
                                @error('dosen_pengampu_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status Mata Kuliah</label>
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statusSwitch"
                                    name="status_aktif"
                                    value="1"
                                    @checked(old('form_type') === 'create' ? old('status_aktif', 1) : true)
                                >
                                <label class="custom-control-label" for="statusSwitch">Aktif</label>
                            </div>
                            @if (old('form_type') === 'create')
                                @error('status_aktif')
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
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Mata Kuliah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_kode">Kode Mata Kuliah</label>
                            <input
                                type="text"
                                name="kode"
                                id="edit_kode"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('kode') ? 'is-invalid' : '' }}"
                            >
                            @if (old('form_type') === 'update')
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="edit_nama">Nama Mata Kuliah</label>
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

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_sks">SKS</label>
                                <input
                                    type="number"
                                    name="sks"
                                    id="edit_sks"
                                    min="1"
                                    max="6"
                                    class="form-control {{ old('form_type') === 'update' && $errors->has('sks') ? 'is-invalid' : '' }}"
                                >
                                @if (old('form_type') === 'update')
                                    @error('sks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_semester">Semester</label>
                                <input
                                    type="number"
                                    name="semester"
                                    id="edit_semester"
                                    min="1"
                                    max="14"
                                    class="form-control {{ old('form_type') === 'update' && $errors->has('semester') ? 'is-invalid' : '' }}"
                                >
                                @if (old('form_type') === 'update')
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
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
                            <label for="edit_dosen_pengampu_id">Dosen Pengampu</label>
                            <select
                                name="dosen_pengampu_id"
                                id="edit_dosen_pengampu_id"
                                class="form-control {{ old('form_type') === 'update' && $errors->has('dosen_pengampu_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">Pilih dosen pengampu</option>
                                @foreach ($dosenOptions as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->nip }})</option>
                                @endforeach
                            </select>
                            @if (old('form_type') === 'update')
                                @error('dosen_pengampu_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status Mata Kuliah</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_status" name="status_aktif" value="1">
                                <label class="custom-control-label" for="edit_status">Aktif</label>
                            </div>
                            @if (old('form_type') === 'update')
                                @error('status_aktif')
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
            $('#tableMataKuliah').DataTable({
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
            const editKodeField = document.getElementById('edit_kode');
            const editNamaField = document.getElementById('edit_nama');
            const editSksField = document.getElementById('edit_sks');
            const editSemesterField = document.getElementById('edit_semester');
            const editProdiField = document.getElementById('edit_prodi');
            const editDosenPengampuField = document.getElementById('edit_dosen_pengampu_id');
            const editStatusField = document.getElementById('edit_status');
            const updateBaseUrl = @json(url('/mata-kuliah'));

            function setEditFormAction(id) {
                editForm.action = `${updateBaseUrl}/${id}`;
            }

            function fillEditForm(data) {
                editIdField.value = data.id;
                editKodeField.value = data.kode;
                editNamaField.value = data.nama;
                editSksField.value = data.sks;
                editSemesterField.value = data.semester;
                editProdiField.value = String(data.prodi);
                editDosenPengampuField.value = data.dosenPengampuId ? String(data.dosenPengampuId) : '';
                editStatusField.checked = Number(data.status) === 1;
                setEditFormAction(data.id);
            }

            document.querySelectorAll('.btn-edit').forEach((button) => {
                button.addEventListener('click', function () {
                    fillEditForm({
                        id: this.dataset.id,
                        kode: this.dataset.kode,
                        nama: this.dataset.nama,
                        sks: this.dataset.sks,
                        semester: this.dataset.semester,
                        prodi: this.dataset.prodi,
                        dosenPengampuId: this.dataset.dosenPengampuId,
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
                    kode: @json(old('kode')),
                    nama: @json(old('nama')),
                    sks: @json(old('sks')),
                    semester: @json(old('semester')),
                    prodi: @json(old('prodi')),
                    dosenPengampuId: @json(old('dosen_pengampu_id')),
                    status: @json(old('status_aktif', 0)),
                });
                editModal.modal('show');
            @endif
        })();
    </script>
@endsection
