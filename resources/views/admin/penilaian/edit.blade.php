@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')

    <div class="container">
        <h2>Edit Nilai Siswa PKL</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.penilaian.update', $penilaian) }}">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Siswa -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Nama Siswa:</strong></label>
                                <p class="form-control-plaintext">{{ $penilaian->siswa->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Kelas:</strong></label>
                                <p class="form-control-plaintext">{{ $penilaian->siswa->kelas }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Instansi:</strong></label>
                                <p class="form-control-plaintext">{{ $penilaian->industri->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="siswa_id" name="siswa_id"
                        value="{{ $penilaian->siswa_id }}" hidden>
                    <input type="text" class="form-control" id="pembimbing_id" name="pembimbing_id"
                        value="{{ $penilaian->pembimbing_id }}" hidden>
                    <input type="text" class="form-control" id="industri_id" name="industri_id"
                        value="{{ $penilaian->industri_id }}" hidden>




                    <!-- Nilai Teknis -->
                    <div class="form-group mb-3">
                        <label for="nilai_teknis">Nilai Teknis</label>
                        <input type="number" class="form-control" id="nilai_teknis" name="nilai_teknis"
                            value="{{ old('nilai_teknis', $penilaian->nilai_teknis) }}" min="0" max="100"
                            required>
                        <small class="form-text text-muted">Nilai antara 0-100</small>
                    </div>

                    <!-- Nilai Non-Teknis -->
                    <h5 class="mt-4 mb-3">Nilai Non-Teknis</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="disiplin">Disiplin</label>
                                <input type="number" class="form-control" id="disiplin" name="disiplin"
                                    value="{{ old('disiplin', $penilaian->disiplin) }}" min="0" max="100"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kerjasama">Kerjasama</label>
                                <input type="number" class="form-control" id="kerjasama" name="kerjasama"
                                    value="{{ old('kerjasama', $penilaian->kerjasama) }}" min="0" max="100"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="inisiatif">Inisiatif</label>
                                <input type="number" class="form-control" id="inisiatif" name="inisiatif"
                                    value="{{ old('inisiatif', $penilaian->inisiatif) }}" min="0" max="100"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggung_jawab">Tanggung Jawab</label>
                                <input type="number" class="form-control" id="tanggung_jawab" name="tanggung_jawab"
                                    value="{{ old('tanggung_jawab', $penilaian->tanggung_jawab) }}" min="0"
                                    max="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kebersihan">Kebersihan</label>
                                <input type="number" class="form-control" id="kebersihan" name="kebersihan"
                                    value="{{ old('kebersihan', $penilaian->kebersihan) }}" min="0" max="100"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="form-group mb-4">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                            placeholder="Tambahkan catatan tentang penilaian siswa">{{ old('catatan', $penilaian->catatan) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Nilai</button>
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

@endsection
