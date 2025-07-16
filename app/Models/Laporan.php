<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'siswa_id',
        'penempatan_id',
        'judul',
        'file_path',
        'catatan',
        'status',
        'catatan_revisi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'menunggu' => ['Menunggu Validasi', 'warning'],
            'valid' => ['Diterima', 'success'],
            'revisi' => ['Perlu Revisi', 'danger']
        ];

        return $statuses[$this->status] ?? ['Unknown', 'secondary'];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class);
    }

    public function pembimbing()
    {
        return $this->through('penempatan')->has('pembimbing');
    }
}
