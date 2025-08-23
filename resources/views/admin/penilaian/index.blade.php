@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Nilai Siswa PKL</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.penilaian.teknis.create') }}" class="btn btn-primary">Input Nilai Teknis</a>
            <a href="{{ route('admin.penilaian.nonteknis.create') }}" class="btn btn-success">Input Nilai Non-Teknis</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Instansi</th>
                            <th>Nilai Teknis</th>
                            <th>Nilai Non-Teknis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($penilaian as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->siswa->nama }}</td>
                                <td>{{ $siswa->siswa->kelas }}</td>
                                <td>{{ $siswa->industri->nama ?? '-' }}</td>
                                <td>
                                    @if ($siswa->nilai_teknis)
                                        {{ $siswa->nilai_teknis }} ({{ $siswa->kualifikasiTeknis() }})
                                    @else
                                        <span class="text-danger">Belum dinilai</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($siswa->disiplin)
                                        <span class="badge bg-primary">D:
                                            {{ $siswa->kualifikasiNonTeknis($siswa->disiplin) }}</span>
                                        <span class="badge bg-success">K:
                                            {{ $siswa->kualifikasiNonTeknis($siswa->kerjasama) }}</span>
                                        <span class="badge bg-warning">I:
                                            {{ $siswa->kualifikasiNonTeknis($siswa->inisiatif) }}</span>
                                        <span class="badge bg-info">T:
                                            {{ $siswa->kualifikasiNonTeknis($siswa->tanggung_jawab) }}</span>
                                        <span class="badge bg-secondary">Keb:
                                            {{ $siswa->kualifikasiNonTeknis($siswa->kebersihan) }}</span>
                                    @else
                                        <span class="text-danger">Belum dinilai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.penilaian.show', $siswa) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('admin.penilaian.edit', $siswa) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
