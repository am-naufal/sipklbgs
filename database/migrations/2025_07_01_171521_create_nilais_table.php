<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('penempatan_id')->constrained('penempatans')->onDelete('cascade');
            $table->unsignedInteger('nilai_industri')->nullable();
            $table->unsignedInteger('nilai_pembimbing')->nullable();
            $table->unsignedInteger('nilai_ujian_dasar')->nullable();
            $table->unsignedInteger('total_nilai')->nullable();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
