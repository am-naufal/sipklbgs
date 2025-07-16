<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian';

    protected $fillable = [
        'siswa_id',
        'penempatan_id',
        'kegiatan',
        'catatan',
        'tanggal',
        'status_validasi',
        'keterangan_validasi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Penempatan
    public function penempatan(): BelongsTo
    {
        return $this->belongsTo(Penempatan::class);
    }

    // Scope untuk filter status
    public function scopeMenunggu($query)
    {
        return $query->where('status_validasi', 'menunggu');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status_validasi', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_validasi', 'ditolak');
    }

    // Format tanggal
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->format('d F Y');
    }
}
