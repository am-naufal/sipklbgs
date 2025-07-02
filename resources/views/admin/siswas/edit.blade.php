@extends('layouts.app')



@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Siswa</h1>
        <form action="{{ route('admin.siswas.update', $siswa) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block">Nama Akun</label>
                    <input type="text" name="name" id="name" class="border rounded w-full p-2"
                        value="{{ old('name', $siswa->user->name) }}">
                    @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block">Email Akun</label>
                    <input type="email" name="email" id="email" class="border rounded w-full p-2"
                        value="{{ old('email', $siswa->user->email) }}">
                    @error('email')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block">Password (isi jika ingin mengubah)</label>
                    <input type="password" name="password" id="password" class="border rounded w-full p-2">
                    @error('password')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="border rounded w-full p-2">
                </div>
                <div>
                    <label for="nama" class="block">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="border rounded w-full p-2"
                        value="{{ old('nama', $siswa->nama) }}">
                    @error('nama')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="tempat_lahir" class="block">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="border rounded w-full p-2"
                        value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    @error('tempat_lahir')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_lahir" class="block">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="border rounded w-full p-2"
                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    @error('tanggal_lahir')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nis" class="block">NIS</label>
                    <input type="text" name="nis" id="nis" class="border rounded w-full p-2"
                        value="{{ old('nis', $siswa->nis) }}">
                    @error('nis')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nisn" class="block">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="border rounded w-full p-2"
                        value="{{ old('nisn', $siswa->nisn) }}">
                    @error('nisn')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="kelas" class="block">Kelas</label>
                    <input type="text" name="kelas" id="kelas" class="border rounded w-full p-2"
                        value="{{ old('kelas', $siswa->kelas) }}">
                    @error('kelas')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jurusan" class="block">Jurusan</label>
                    <select name="jurusan" id="jurusan" class="border rounded w-full p-2">
                        <option value="">Pilih Jurusan</option>
                        <option value="tb" @selected(old('jurusan', $siswa->jurusan) == 'tb')>Teknik Boga</option>
                        <option value="mm" @selected(old('jurusan', $siswa->jurusan) == 'mm')>Multimedia</option>
                        <option value="aphp" @selected(old('jurusan', $siswa->jurusan) == 'aphp')>Agribisnis Pengolahan Hasil Pertanian</option>
                    </select>
                    @error('jurusan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="alamat" class="block">Alamat</label>
                    <textarea name="alamat" id="alamat" class="border rounded w-full p-2">{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="status_pkl" class="block">Status PKL</label>
                    <select name="status_pkl" id="status_pkl" class="border rounded w-full p-2">
                        <option value="belum_mulai" @selected(old('status_pkl', $siswa->status_pkl) == 'belum_mulai')>Belum Mulai</option>
                        <option value="sedang_berjalan" @selected(old('status_pkl', $siswa->status_pkl) == 'sedang_berjalan')>Sedang Berjalan</option>
                        <option value="selesai" @selected(old('status_pkl', $siswa->status_pkl) == 'selesai')>Selesai</option>
                    </select>
                    @error('status_pkl')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_mulai" class="block">Tanggal Mulai PKL</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="border rounded w-full p-2"
                        value="{{ old('tanggal_mulai', $siswa->tanggal_mulai) }}">
                    @error('tanggal_mulai')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_selesai" class="block">Tanggal Selesai PKL</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="border rounded w-full p-2"
                        value="{{ old('tanggal_selesai', $siswa->tanggal_selesai) }}">
                    @error('tanggal_selesai')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="tahun_angkatan" class="block">Tahun Angkatan</label>
                    <input type="number" name="tahun_angkatan" id="tahun_angkatan" class="border rounded w-full p-2"
                        value="{{ old('tahun_angkatan', $siswa->tahun_angkatan) }}">
                    @error('tahun_angkatan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('admin.siswas.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
@endsection
