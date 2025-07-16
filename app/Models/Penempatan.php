<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    protected $fillable = [
        'siswa_id',
        'industri_id',
        'pembimbing_id',
        'status',
        'tanggal_penempatan',
        'tanggal_selesai',
        'keterangan',
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
    public function laporanHarian()
    {
        return $this->hasMany(LaporanHarian::class);
    }
}
