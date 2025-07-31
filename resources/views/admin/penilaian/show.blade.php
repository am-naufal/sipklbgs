@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Nilai PKL - {{ $siswa->nama }}</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Informasi Siswa</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                        <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
                        <p><strong>Jurusan:</strong> {{ $siswa->jurusan }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Instansi:</strong> {{ $siswa->industri->nama ?? '-' }}</p>
                        <p><strong>Pembimbing:</strong> {{ $penilaian->pembimbing->nama_lengkap ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Nilai Teknis</h4>
            </div>
            <div class="card-body">
                @if ($penilaian && $penilaian->nilai_teknis)
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nilai:</strong> {{ $penilaian->nilai_teknis }}</p>
                            <p><strong>Kualifikasi:</strong> {{ $penilaian->kualifikasiTeknis() }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $penilaian->nilai_teknis }}%"
                                    aria-valuenow="{{ $penilaian->nilai_teknis }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $penilaian->nilai_teknis }}%
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-danger">Belum dinilai</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Nilai Non-Teknis</h4>
            </div>
            <div class="card-body">
                @if ($penilaian && $penilaian->disiplin)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Aspek</th>
                                <th>Nilai</th>
                                <th>Kualifikasi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Disiplin</td>
                                <td>{{ $penilaian->disiplin }}</td>
                                <td>{{ $penilaian->kualifikasiNonTeknis($penilaian->disiplin) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $penilaian->disiplin }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kerjasama</td>
                                <td>{{ $penilaian->kerjasama }}</td>
                                <td>{{ $penilaian->kualifikasiNonTeknis($penilaian->kerjasama) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $penilaian->kerjasama }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Inisiatif</td>
                                <td>{{ $penilaian->inisiatif }}</td>
                                <td>{{ $penilaian->kualifikasiNonTeknis($penilaian->inisiatif) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $penilaian->inisiatif }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggung Jawab</td>
                                <td>{{ $penilaian->tanggung_jawab }}</td>
                                <td>{{ $penilaian->kualifikasiNonTeknis($penilaian->tanggung_jawab) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $penilaian->tanggung_jawab }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kebersihan</td>
                                <td>{{ $penilaian->kebersihan }}</td>
                                <td>{{ $penilaian->kualifikasiNonTeknis($penilaian->kebersihan) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $penilaian->kebersihan }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($penilaian->catatan)
                        <div class="mt-3">
                            <h5>Catatan:</h5>
                            <p>{{ $penilaian->catatan }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-danger">Belum dinilai</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    @endsectionn
