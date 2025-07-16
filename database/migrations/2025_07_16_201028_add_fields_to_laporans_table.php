<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('judul')->after('id');
            $table->text('catatan')->nullable()->after('file_path');
            $table->renameColumn('status_validasi', 'status');
            $table->renameColumn('keterangan_validasi', 'catatan_revisi');
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('judul');
            $table->dropColumn('catatan');
            $table->renameColumn('status', 'status_validasi');
            $table->renameColumn('catatan_revisi', 'keterangan_validasi');
        });
    }
};
