<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JafaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SerdosController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Notifikasi ────────────────────────────────────────────────────────────
    Route::post('notifikasi/{id}/baca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.baca');
    Route::post('notifikasi/baca-semua', [NotifikasiController::class, 'tandaiSemuaDibaca'])->name('notifikasi.baca-semua');

    // ── Admin SDM ─────────────────────────────────────────────────────────────
    Route::middleware('role:admin_sdm')->group(function () {
        // Master Data
        Route::resource('unit-kerja', UnitKerjaController::class);
        Route::resource('jabatan', JabatanController::class);
        Route::post('pegawai/{id}/upload-foto', [PegawaiController::class, 'uploadFoto'])->name('pegawai.upload-foto');
Route::get('pegawai/export-excel', [PegawaiController::class, 'exportExcel'])->name('pegawai.export');
Route::get('pegawai/template-import', [PegawaiController::class, 'templateImport'])->name('pegawai.template');
Route::post('pegawai/import-excel', [PegawaiController::class, 'importExcel'])->name('pegawai.import');

Route::resource('pegawai', PegawaiController::class);
Route::post('pegawai/{id}/assign-jabatan', [PegawaiController::class, 'assignJabatan'])->name('pegawai.assign-jabatan');
Route::delete('pegawai/{pegawai}/jabatan/{jabatan}/revoke', [PegawaiController::class, 'revokeJabatan'])->name('pegawai.revoke-jabatan');

        // Verifikasi
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('verifikasi/jafa/{id}', [VerifikasiController::class, 'prosesJafa'])->name('verifikasi.jafa');
        Route::post('verifikasi/serdos/{id}', [VerifikasiController::class, 'prosesSerdos'])->name('verifikasi.serdos');

        // Laporan
        Route::get('laporan/pegawai', [LaporanController::class, 'pegawai'])->name('laporan.pegawai');
        Route::get('laporan/pegawai/pdf', [LaporanController::class, 'pegawaiPdf'])->name('laporan.pegawai.pdf');
        Route::get('laporan/pegawai/excel', [LaporanController::class, 'pegawaiExcel'])->name('laporan.pegawai.excel');
        Route::get('laporan/cuti', [LaporanController::class, 'cuti'])->name('laporan.cuti');
        Route::get('laporan/cuti/pdf', [LaporanController::class, 'cutiPdf'])->name('laporan.cuti.pdf');
        Route::get('laporan/cuti/excel', [LaporanController::class, 'cutiExcel'])->name('laporan.cuti.excel');
        Route::get('laporan/lembur', [LaporanController::class, 'lembur'])->name('laporan.lembur');
        Route::get('laporan/lembur/pdf', [LaporanController::class, 'lemburPdf'])->name('laporan.lembur.pdf');
        Route::get('laporan/jafa-serdos', [LaporanController::class, 'jafaSerdos'])->name('laporan.jafa-serdos');
    });

    // ── Pejabat Struktural ────────────────────────────────────────────────────
    Route::middleware('role:admin_sdm,rektor,wakil_rektor,dekan,kaprodi,ka_biro')->group(function () {
        Route::get('approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::post('approval/cuti/{id}', [ApprovalController::class, 'prosesCuti'])->name('approval.cuti');
        Route::post('approval/lembur/{id}', [ApprovalController::class, 'prosesLembur'])->name('approval.lembur');
    });

    // ── Dosen & Tendik ────────────────────────────────────────────────────────
    Route::middleware('role:dosen,tendik,admin_sdm,rektor,wakil_rektor,dekan,kaprodi,ka_biro')->group(function () {
        Route::resource('cuti', CutiController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('lembur', LemburController::class)->only(['index', 'create', 'store', 'show']);
    });

    // ── Dosen (Jafa & Serdos) ─────────────────────────────────────────────────
    Route::middleware('role:dosen,admin_sdm,rektor,wakil_rektor,dekan,kaprodi,ka_biro')->group(function () {
        Route::resource('jafa', JafaController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('jafa/{id}/pdf', [JafaController::class, 'cetakPdf'])->name('jafa.pdf');
        Route::post('jafa/{id}/upload-scan', [JafaController::class, 'uploadScan'])->name('jafa.upload-scan');

        Route::resource('serdos', SerdosController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('serdos/{id}/pdf', [SerdosController::class, 'cetakPdf'])->name('serdos.pdf');
        Route::post('serdos/{id}/upload-scan', [SerdosController::class, 'uploadScan'])->name('serdos.upload-scan');
    });
    Route::delete('cuti/{id}/batal', [CutiController::class, 'batal'])->name('cuti.batal');
});