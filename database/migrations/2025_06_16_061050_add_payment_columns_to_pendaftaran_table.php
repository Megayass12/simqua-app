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
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('kode_pembayaran')
                ->nullable()
                ->after('file_akta');

            $table->enum('status_pembayaran', ['Belum Dibayar', 'Lunas'])
                ->default('Belum Dibayar')
                ->after('kode_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['kode_pembayaran', 'status_pembayaran']);
        });
    }
};