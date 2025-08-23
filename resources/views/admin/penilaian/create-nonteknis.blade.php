@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Input Nilai Non-Teknis Siswa PKL</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.penilaian.nonteknis.store') }}">
                    @csrf

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Kelas</th>
                                <th rowspan="2">Instansi</th>
                                <th colspan="5" class="text-center">Aspek Non-Teknis (0-100)</th>
                            </tr>
                            <tr>
                                <th>Disiplin</th>
                                <th>Kerjasama</th>
                                <th>Inisiatif</th>
                                <th>Tanggung Jawab</th>
                                <th>Kebersihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $siswa)
                                @php
                                    $penilaian = $siswa->penilaian ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $siswa->siswa->nama }}</td>
                                    <td>{{ $siswa->siswa->kelas }}</td>
                                    <td>{{ $siswa->industri->nama ?? '-' }}</td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][disiplin]"
                                            value="{{ old('nilai.' . $loop->index . '.disiplin', $penilaian->disiplin ?? '') }}"
                                            min="0" max="100" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][kerjasama]"
                                            value="{{ old('nilai.' . $loop->index . '.kerjasama', $penilaian->kerjasama ?? '') }}"
                                            min="0" max="100" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][inisiatif]"
                                            value="{{ old('nilai.' . $loop->index . '.inisiatif', $penilaian->inisiatif ?? '') }}"
                                            min="0" max="100" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][tanggung_jawab]"
                                            value="{{ old('nilai.' . $loop->index . '.tanggung_jawab', $penilaian->tanggung_jawab ?? '') }}"
                                            min="0" max="100" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][kebersihan]"
                                            value="{{ old('nilai.' . $loop->index . '.kebersihan', $penilaian->kebersihan ?? '') }}"
                                            min="0" max="100" required>
                                    </td>
                                    <input type="hidden" name="nilai[{{ $loop->index }}][siswa_id]"
                                        value="{{ $siswa->id }}">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan Semua Nilai</button>
                        <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
