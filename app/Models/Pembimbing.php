<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'niy',
        'email',
        'no_hp',
        'jabatan',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
