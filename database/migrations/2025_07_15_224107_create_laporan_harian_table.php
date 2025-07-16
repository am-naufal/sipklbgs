<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('penempatan_id')->constrained('penempatans')->onDelete('cascade');
            $table->text('kegiatan');
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->enum('status_validasi', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('keterangan_validasi')->nullable();
            $table->timestamps();

            // Index untuk pencarian lebih cepat
            $table->index(['siswa_id', 'penempatan_id']);
            $table->index('tanggal');
            $table->index('status_validasi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_harian');
    }
};
