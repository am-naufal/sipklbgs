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
        'jurusan',
        'alamat',
        'no_hp',
        'email',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
