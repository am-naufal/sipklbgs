<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'siswa_id',
        'industri_id',
        'pembimbing_id',
        'file_path',
        'status_validasi',
        'keterangan_validasi',
    ];
    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke model Penempatan
     */
    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class);
    }
}
