<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('industri_id')->constrained()->onDelete('cascade');
            $table->foreignId('pembimbing_id')->constrained()->onDelete('cascade');
            $table->integer('nilai_teknis')->nullable();
            $table->integer('disiplin')->nullable();
            $table->integer('kerjasama')->nullable();
            $table->integer('inisiatif')->nullable();
            $table->integer('tanggung_jawab')->nullable();
            $table->integer('kebersihan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaians');
    }
};
