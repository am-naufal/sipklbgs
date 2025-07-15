@extends('layouts.app')

@section('title', 'Edit Pembimbing')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    Edit Pembimbing
                </div>
            </div>

            <form action="{{ route('admin.pembimbings.update', $pembimbing) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                            value="{{ old('nama_lengkap', $pembimbing->nama_lengkap) }}">
                        @error('nama_lengkap')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="niy" class="form-label">NIY</label>
                        <input type="text" name="niy" id="niy" class="form-control"
                            value="{{ old('niy', $pembimbing->niy) }}">
                        @error('niy')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_pembimbing" class="form-label">Email Pembimbing</label>
                        <input type="email" name="email" id="email_pembimbing" class="form-control"
                            value="{{ old('email', $pembimbing->email) }}">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control"
                            value="{{ old('no_hp', $pembimbing->no_hp) }}">
                        @error('no_hp')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control"
                            value="{{ old('jabatan', $pembimbing->jabatan) }}">
                        @error('jabatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $pembimbing->alamat) }}</textarea>
                        @error('alamat')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_user" class="form-label">Alamat Email Akun</label>
                        <input type="email" name="email_user" id="email_user" class="form-control"
                            aria-describedby="emailHelp" value="{{ old('email_user', $pembimbing->user->email) }}">
                        <div id="emailHelp" class="form-text">Email digunakan untuk login ke sistem.</div>
                        @error('email_user')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi (opsional)</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.pembimbings.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
