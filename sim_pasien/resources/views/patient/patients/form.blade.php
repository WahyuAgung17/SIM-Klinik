<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Informasi Pasien
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            {{-- No RM --}}
            <div class="col-md-4 mb-3">
                <label>No. Rekam Medis</label>
                <input type="text"
                       class="form-control"
                       value="{{ $patient->medical_record_number ?? 'Otomatis' }}"
                       readonly>
            </div>

            {{-- NIK --}}
            <div class="col-md-4 mb-3">
                <label>NIK</label>
                <input type="text"
                       name="nik"
                       class="form-control"
                       maxlength="16"
                       value="{{ old('nik',$patient->nik ?? '') }}"
                       required>
            </div>

            {{-- KK --}}
            <div class="col-md-4 mb-3">
                <label>No. KK</label>
                <input type="text"
                       name="family_card_number"
                       class="form-control"
                       maxlength="16"
                       value="{{ old('family_card_number',$patient->family_card_number ?? '') }}">
            </div>

            {{-- Nama --}}
            <div class="col-md-6 mb-3">
                <label>Nama Lengkap</label>
                <input type="text"
                       name="full_name"
                       class="form-control"
                       value="{{ old('full_name',$patient->full_name ?? '') }}"
                       required>
            </div>

            {{-- Nama Panggilan --}}
            <div class="col-md-6 mb-3">
                <label>Nama Panggilan</label>
                <input type="text"
                       name="nickname"
                       class="form-control"
                       value="{{ old('nickname',$patient->nickname ?? '') }}">
            </div>

            {{-- Jenis Kelamin --}}
            <div class="col-md-4 mb-3">
                <label>Jenis Kelamin</label>

                <select name="gender" class="form-control" required>

                    <option value="">-- Pilih --</option>

                    <option value="Laki-laki"
                        {{ old('gender',$patient->gender ?? '')=='Laki-laki'?'selected':'' }}>
                        Laki-laki
                    </option>

                    <option value="Perempuan"
                        {{ old('gender',$patient->gender ?? '')=='Perempuan'?'selected':'' }}>
                        Perempuan
                    </option>

                </select>

            </div>

            {{-- Tempat Lahir --}}
            <div class="col-md-4 mb-3">
                <label>Tempat Lahir</label>

                <input type="text"
                       name="birth_place"
                       class="form-control"
                       value="{{ old('birth_place',$patient->birth_place ?? '') }}">
            </div>

            {{-- Tanggal Lahir --}}
            <div class="col-md-4 mb-3">
                <label>Tanggal Lahir</label>

                <input type="date"
                       name="birth_date"
                       class="form-control"
                       value="{{ old('birth_date',$patient->birth_date ?? '') }}"
                       required>
            </div>

            {{-- Golongan Darah --}}
            <div class="col-md-4 mb-3">

                <label>Golongan Darah</label>

                <select name="blood_type" class="form-control">

                    @foreach(['A','B','AB','O','Tidak Tahu'] as $item)

                        <option value="{{ $item }}"
                            {{ old('blood_type',$patient->blood_type ?? '')==$item?'selected':'' }}>
                            {{ $item }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Agama --}}
            <div class="col-md-4 mb-3">

                <label>Agama</label>

                <input type="text"
                       name="religion"
                       class="form-control"
                       value="{{ old('religion',$patient->religion ?? '') }}">

            </div>

            {{-- Status Nikah --}}
            <div class="col-md-4 mb-3">

                <label>Status Pernikahan</label>

                <select name="marital_status" class="form-control">

                    @foreach(['Belum Menikah','Menikah','Cerai Hidup','Cerai Mati'] as $item)

                        <option value="{{ $item }}"
                            {{ old('marital_status',$patient->marital_status ?? '')==$item?'selected':'' }}>
                            {{ $item }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Pekerjaan --}}
            <div class="col-md-6 mb-3">

                <label>Pekerjaan</label>

                <input type="text"
                       name="occupation"
                       class="form-control"
                       value="{{ old('occupation',$patient->occupation ?? '') }}">

            </div>

            {{-- HP --}}
            <div class="col-md-6 mb-3">

                <label>No HP</label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone',$patient->phone ?? '') }}">

            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email',$patient->email ?? '') }}">

            </div>

            {{-- Jenis Pembayaran --}}
            <div class="col-md-6 mb-3">

                <label>Jenis Pembayaran</label>

                <select name="insurance_type" class="form-control">

                    @foreach(['Umum','BPJS','Asuransi'] as $item)

                        <option value="{{ $item }}"
                            {{ old('insurance_type',$patient->insurance_type ?? '')==$item?'selected':'' }}>
                            {{ $item }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Nomor BPJS --}}
            <div class="col-md-6 mb-3">

                <label>No BPJS</label>

                <input type="text"
                       name="bpjs_number"
                       class="form-control"
                       value="{{ old('bpjs_number',$patient->bpjs_number ?? '') }}">

            </div>

            {{-- Nomor Asuransi --}}
            <div class="col-md-6 mb-3">

                <label>No Asuransi</label>

                <input type="text"
                       name="insurance_number"
                       class="form-control"
                       value="{{ old('insurance_number',$patient->insurance_number ?? '') }}">

            </div>

            {{-- Alamat --}}
            <div class="col-md-12 mb-3">

                <label>Alamat</label>

                <textarea name="address"
                          rows="3"
                          class="form-control">{{ old('address',$patient->address ?? '') }}</textarea>

            </div>

            {{-- RT --}}
            <div class="col-md-2 mb-3">
                <label>RT</label>
                <input type="text"
                       name="rt"
                       class="form-control"
                       value="{{ old('rt',$patient->rt ?? '') }}">
            </div>

            {{-- RW --}}
            <div class="col-md-2 mb-3">
                <label>RW</label>
                <input type="text"
                       name="rw"
                       class="form-control"
                       value="{{ old('rw',$patient->rw ?? '') }}">
            </div>

            {{-- Kelurahan --}}
            <div class="col-md-4 mb-3">
                <label>Kelurahan</label>
                <input type="text"
                       name="village"
                       class="form-control"
                       value="{{ old('village',$patient->village ?? '') }}">
            </div>

            {{-- Kecamatan --}}
            <div class="col-md-4 mb-3">
                <label>Kecamatan</label>
                <input type="text"
                       name="district"
                       class="form-control"
                       value="{{ old('district',$patient->district ?? '') }}">
            </div>

            {{-- Kota --}}
            <div class="col-md-4 mb-3">
                <label>Kota</label>
                <input type="text"
                       name="city"
                       class="form-control"
                       value="{{ old('city',$patient->city ?? '') }}">
            </div>

            {{-- Provinsi --}}
            <div class="col-md-4 mb-3">
                <label>Provinsi</label>
                <input type="text"
                       name="province"
                       class="form-control"
                       value="{{ old('province',$patient->province ?? '') }}">
            </div>

            {{-- Kode Pos --}}
            <div class="col-md-4 mb-3">
                <label>Kode Pos</label>
                <input type="text"
                       name="postal_code"
                       class="form-control"
                       value="{{ old('postal_code',$patient->postal_code ?? '') }}">
            </div>

            {{-- Tekanan Darah --}}
            <div class="col-md-4 mb-3">
                <label>Tekanan Darah</label>
                <input type="text"
                       name="blood_pressure"
                       class="form-control"
                       value="{{ old('blood_pressure',$patient->blood_pressure ?? '') }}">
            </div>

            {{-- Alergi --}}
            <div class="col-md-6 mb-3">

                <label>Alergi</label>

                <textarea name="allergy"
                          rows="3"
                          class="form-control">{{ old('allergy',$patient->allergy ?? '') }}</textarea>

            </div>

            {{-- Catatan Medis --}}
            <div class="col-md-6 mb-3">

                <label>Catatan Medis</label>

                <textarea name="medical_notes"
                          rows="3"
                          class="form-control">{{ old('medical_notes',$patient->medical_notes ?? '') }}</textarea>

            </div>

            {{-- Foto --}}
            <div class="col-md-6 mb-3">

                <label>Foto Pasien</label>

                <input type="file"
                       name="photo"
                       class="form-control">

                @if(isset($patient) && $patient->photo)

                    <div class="mt-2">

                        <img src="{{ asset('storage/'.$patient->photo) }}"
                             width="120"
                             class="img-thumbnail">

                    </div>

                @endif

            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    @foreach(['Aktif','Nonaktif','Meninggal'] as $item)

                        <option value="{{ $item }}"
                            {{ old('status',$patient->status ?? '')==$item?'selected':'' }}>
                            {{ $item }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>

</div>