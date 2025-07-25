@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Laporan</h1>

        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="siswa_id" class="form-label">Siswa</label>
                <select class="form-select" id="siswa_id" name="siswa_id" required>
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ $laporan->siswa_id == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="penempatan_id" class="form-label">Penempatan</label>
                <select class="form-select" id="penempatan_id" name="penempatan_id" required>
                    <option value="">Pilih Penempatan</option>
                    @foreach ($penempatans as $penempatan)
                        <option value="{{ $penempatan->id }}"
                            {{ $laporan->penempatan_id == $penempatan->id ? 'selected' : '' }}>{{ $penempatan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $laporan->judul }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File Laporan (PDF/DOC/DOCX, max 2MB)</label>
                <input type="file" class="form-control" id="file" name="file">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                @if ($laporan->file_path)
                    <div class="mt-2">
                        <span>File saat ini: </span>
                        <a href="{{ route('laporan.download', $laporan->id) }}" target="_blank">Download</a>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $laporan->catatan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Menunggu Validasi
                    </option>
                    <option value="valid" {{ $laporan->status == 'valid' ? 'selected' : '' }}>Diterima</option>
                    <option value="revisi" {{ $laporan->status == 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                </select>
            </div>

            <div class="mb-3" id="catatan-revisi-container"
                style="{{ $laporan->status != 'revisi' ? 'display: none;' : '' }}">
                <label for="catatan_revisi" class="form-label">Catatan Revisi</label>
                <textarea class="form-control" id="catatan_revisi" name="catatan_revisi" rows="3">{{ $laporan->catatan_revisi }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        document.getElementById('status').addEventListener('change', function() {
            const catatanRevisiContainer = document.getElementById('catatan-revisi-container');
            if (this.value === 'revisi') {
                catatanRevisiContainer.style.display = 'block';
                document.getElementById('catatan_revisi').setAttribute('required', 'required');
            } else {
                catatanRevisiContainer.style.display = 'none';
                document.getElementById('catatan_revisi').removeAttribute('required');
            }
        });
    </script>
@endsection
