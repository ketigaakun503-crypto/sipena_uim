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
        Schema::create('pegawais', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('nip')->nullable()->unique();
        $table->string('nidn')->nullable()->unique();
        $table->string('nama_lengkap');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->string('no_hp')->nullable();
        $table->string('email')->nullable();
        $table->string('foto')->nullable();
        $table->enum('status', ['aktif', 'nonaktif', 'pensiun'])->default('aktif');
        $table->enum('jenis_pegawai', ['dosen', 'tendik']);
        $table->integer('sisa_cuti')->default(12);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
