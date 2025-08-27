<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'siswa_id',
        'industri_id',
        'pembimbing_id',
        'nilai_teknis',
        'disiplin',
        'kerjasama',
        'inisiatif',
        'tanggung_jawab',
        'kebersihan',
        'catatan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'siswa_id', 'siswa_id');
    }

    // Helper method untuk mendapatkan kualifikasi
    public function kualifikasiTeknis()
    {
        if ($this->nilai_teknis >= 86) return 'Baik Sekali';
        if ($this->nilai_teknis >= 70) return 'Baik';
        if ($this->nilai_teknis >= 60) return 'Cukup';
        if ($this->nilai_teknis >= 50) return 'Kurang';
        return 'Kurang Sekali';
    }

    // Helper method untuk kualifikasi non-teknis
    public function kualifikasiNonTeknis($nilai)
    {
        if ($nilai >= 86) return 'A (Baik Sekali)';
        if ($nilai >= 70) return 'B (Baik)';
        if ($nilai >= 60) return 'C (Cukup)';
        return 'D (Kurang)';
    }

    // Helper method untuk mendapatkan warna progress bar berdasarkan nilai
    public function getProgressBarColor($nilai)
    {
        if ($nilai >= 86) return 'bg-success'; // Green for excellent
        if ($nilai >= 70) return 'bg-info';    // Blue for good
        if ($nilai >= 60) return 'bg-warning'; // Yellow for average
        return 'bg-danger';                    // Red for poor
    }

    // Helper method untuk menghitung rata-rata nilai non-teknis
    public function rataRataNonTeknis()
    {
        $nilaiNonTeknis = [
            $this->disiplin,
            $this->kerjasama,
            $this->inisiatif,
            $this->tanggung_jawab,
            $this->kebersihan
        ];

        // Filter out null values
        $validNilai = array_filter($nilaiNonTeknis, function ($nilai) {
            return !is_null($nilai);
        });

        if (count($validNilai) === 0) {
            return null;
        }

        return array_sum($validNilai) / count($validNilai);
    }

    // Helper method untuk mendapatkan kualifikasi rata-rata
    public function kualifikasiRataRata()
    {
        $rataRata = $this->rataRataNonTeknis();
        if (is_null($rataRata)) {
            return 'Belum dinilai';
        }

        return $this->kualifikasiNonTeknis($rataRata);
    }

    // Helper method untuk mendapatkan nilai akhir (rata-rata nilai teknis dan non-teknis)
    public function nilaiAkhir()
    {
        $nilaiTeknis = $this->nilai_teknis;
        $rataRataNonTeknis = $this->rataRataNonTeknis();

        if (is_null($nilaiTeknis) && is_null($rataRataNonTeknis)) {
            return null;
        }

        if (is_null($nilaiTeknis)) {
            return $rataRataNonTeknis;
        }

        if (is_null($rataRataNonTeknis)) {
            return $nilaiTeknis;
        }

        return ($nilaiTeknis + $rataRataNonTeknis) / 2;
    }

    // Helper method untuk mendapatkan kualifikasi nilai akhir
    public function kualifikasiNilaiAkhir()
    {
        $nilaiAkhir = $this->nilaiAkhir();
        if (is_null($nilaiAkhir)) {
            return 'Belum dinilai';
        }

        return $this->kualifikasiTeknis($nilaiAkhir);
    }
}
