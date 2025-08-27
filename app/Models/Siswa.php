<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nisn',
        'kelas',
        'tempat_lahir',
        'tanggal_lahir',
        'nis',
        'jurusan',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function laporanHarian()
    {
        return $this->hasMany(LaporanHarian::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    // Alias for laporans to maintain compatibility with views
    public function laporan()
    {
        return $this->laporans();
    }
}
