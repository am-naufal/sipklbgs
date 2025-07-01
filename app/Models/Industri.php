<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'nama_pj',
        'jabatan_pj',
        'telepon_pj',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
