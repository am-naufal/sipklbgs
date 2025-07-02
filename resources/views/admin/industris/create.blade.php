@extends('layouts.app')

@section('title', 'Tambah Industri')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">Tambah Industri</div>
            </div>

            <form action="{{ route('admin.industris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Industri</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control"
                            value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control"
                            value="{{ old('telepon') }}">
                        @error('telepon')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="nama_pj" class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" name="nama_pj" id="nama_pj" class="form-control"
                            value="{{ old('nama_pj') }}">
                        @error('nama_pj')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan_pj" class="form-label">Jabatan PJ</label>
                        <input type="text" name="jabatan_pj" id="jabatan_pj" class="form-control"
                            value="{{ old('jabatan_pj') }}">
                        @error('jabatan_pj')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telepon_pj" class="form-label">Telepon PJ</label>
                        <input type="text" name="telepon_pj" id="telepon_pj" class="form-control"
                            value="{{ old('telepon_pj') }}">
                        @error('telepon_pj')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.industris.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
