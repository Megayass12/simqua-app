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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('nisn');
            $table->string('tempat');
            $table->date('tanggal');
            $table->string('alamat');
            $table->string('no_hp');
            $table->enum('status', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('file_kk')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('kode_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Lunas'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
