<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontrak_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_kontrak')->unique();
            $table->enum('jenis_kontrak', ['tetap', 'tidak_tetap', 'paruh_waktu'])->default('tidak_tetap');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'berakhir', 'diperpanjang'])->default('aktif');
            $table->boolean('notif_terkirim')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrak_kerjas');
    }
};