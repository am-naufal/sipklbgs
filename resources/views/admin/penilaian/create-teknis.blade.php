@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Input Nilai Teknis Siswa PKL</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.penilaian.teknis.store') }}">
                    @csrf

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Instansi</th>
                                <th>Nilai Teknis (0-100)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $siswa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>{{ $siswa->industri->nama ?? '-' }}</td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="nilai[{{ $loop->index }}][nilai_teknis]"
                                            value="{{ old('nilai.' . $loop->index . '.nilai_teknis', $siswa->penilaian->nilai_teknis ?? '') }}"
                                            min="0" max="100" required>
                                        <input type="hidden" name="nilai[{{ $loop->index }}][siswa_id]"
                                            value="{{ $siswa->id }}">
                                    </td>
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
