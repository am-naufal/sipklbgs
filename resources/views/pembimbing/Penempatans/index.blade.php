@extends('layouts.app')
@section('title', 'Daftar Penempatan')

{{-- PUSH STYLES --}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.3.2/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush


@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Penempatan</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="penempatan-table" class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Industri</th>
                        <th>Pembimbing</th>
                        <th>Status</th>
                        <th>Tgl Penempatan</th>
                        <th>Tgl Selesai</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penempatans as $penempatan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penempatan->siswa->nama ?? '-' }}</td>
                            <td>{{ $penempatan->industri->nama ?? '-' }}</td>
                            <td>{{ $penempatan->pembimbing->nama_lengkap ?? '-' }}</td>
                            <td>{{ ucfirst($penempatan->status) }}</td>
                            <td>{{ $penempatan->tanggal_penempatan }}</td>
                            <td>{{ $penempatan->tanggal_selesai }}</td>
                            <td>{{ $penempatan->keterangan }}</td>
                            <td>
                                <a href="{{ route('pembimbing.penempatans.show', $penempatan) }}"
                                    class="btn btn-sm btn-info text-white" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pembimbing.penempatans.edit', $penempatan) }}"
                                    class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pembimbing.penempatans.destroy', $penempatan) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
{{-- PUSH SCRIPTS --}}
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.3.2/datatables.min.js"
        integrity="sha384-JRUjeYWWUGO171YFugrU0ksSC6CaWnl4XzwP6mNjnnDh4hfFGRyYbEXwryGwLsEp" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            $('#penempatan-table').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                    zeroRecords: "Data tidak ditemukan",
                }
            });
        });
    </script>
@endpush
