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
}
