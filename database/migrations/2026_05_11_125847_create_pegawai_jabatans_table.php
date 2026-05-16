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
        Schema::create('pegawai_jabatans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->foreignId('jabatan_id')->constrained()->cascadeOnDelete();
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai')->nullable();
        $table->boolean('is_aktif')->default(true);
        $table->enum('jenis', ['utama', 'rangkap'])->default('utama');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_jabatans');
    }
};
