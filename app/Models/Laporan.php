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
        'status_validasi',
        'keterangan_revisi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    public function getStatusLabelAttribute()
    {
        $status = $this->status;
        switch ($status) {
            case 'draft':
                return ['Draft', 'secondary', 'file'];
            case 'submitted':
                return ['Terkirim', 'info', 'paper-plane'];
            case 'approved':
                return ['Disetujui', 'success', 'check'];
            case 'rejected':
                return ['Ditolak', 'danger', 'times'];
            default:
                return [$status, 'secondary', 'question'];
        }
    }

    public function getStatusIconAttribute()
    {
        return $this->status_label[2];
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
