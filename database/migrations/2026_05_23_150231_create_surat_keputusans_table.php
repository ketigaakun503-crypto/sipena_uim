<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keputusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_sk')->unique();
            $table->enum('jenis_sk', [
                'pengangkatan',
                'jabatan_fungsional',
                'jabatan_struktural',
            ]);
            $table->string('jabatan_yang_ditetapkan');
            $table->date('tanggal_sk');
            $table->date('tmt')->nullable(); // Terhitung Mulai Tanggal
            $table->text('pertimbangan')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['draft', 'diterbitkan', 'tidak_berlaku'])->default('draft');
            $table->string('file_sk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keputusans');
    }
};