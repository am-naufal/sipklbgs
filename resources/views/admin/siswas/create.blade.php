@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    Tambah Siswa
                </div>
            </div>

            <form action="{{ route('admin.siswas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Akun</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Akun</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control"
                            value="{{ old('nis') }}">
                        @error('nis')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" name="nisn" id="nisn" class="form-control"
                            value="{{ old('nisn') }}">
                        @error('nisn')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" name="kelas" id="kelas" class="form-control"
                            value="{{ old('kelas') }}">
                        @error('kelas')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            <option value="tb" {{ old('jurusan') == 'tb' ? 'selected' : '' }}>Tata Boga</option>
                            <option value="mm" {{ old('jurusan') == 'mm' ? 'selected' : '' }}>Multimedia</option>
                            <option value="aphp" {{ old('jurusan') == 'aphp' ? 'selected' : '' }}>Agribisnis Pengolahan
                                Hasil Pertanian</option>
                        </select>
                        @error('jurusan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="status_pkl" class="form-label">Status PKL</label>
                        <select name="status_pkl" id="status_pkl" class="form-select">
                            <option value="belum_mulai" {{ old('status_pkl') == 'belum_mulai' ? 'selected' : '' }}>Belum
                                Mulai</option>
                            <option value="sedang_berjalan"
                                {{ old('status_pkl') == 'sedang_berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                            <option value="selesai" {{ old('status_pkl') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                        @error('status_pkl')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai PKL</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                            value="{{ old('tanggal_mulai') }}">
                        @error('tanggal_mulai')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai PKL</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai') }}">
                        @error('tanggal_selesai')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                        <input type="number" name="tahun_angkatan" id="tahun_angkatan" class="form-control"
                            value="{{ old('tahun_angkatan') }}">
                        @error('tahun_angkatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.siswas.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
