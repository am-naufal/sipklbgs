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
}
