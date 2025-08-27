<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'email_industri',
        'bidang_usaha',
        'deskripsi',
        'nama_pj',
        'jabatan_pj',
        'telepon_pj',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class);
    }
}
