<?php

namespace App\Services;

use App\Models\KontrakKerja;
use App\Models\Pegawai;

class KontrakKerjaService
{
    public function __construct(
        protected NotifikasiService $notifikasiService
    ) {}

    public function getAll()
    {
        return KontrakKerja::with('pegawai')->latest()->get();
    }

    public function getByPegawai(int $pegawaiId)
    {
        return KontrakKerja::where('pegawai_id', $pegawaiId)->latest()->get();
    }

    public function findById(int $id)
    {
        return KontrakKerja::with('pegawai')->findOrFail($id);
    }

    public function create(array $data): KontrakKerja
    {
        return KontrakKerja::create($data);
    }

    public function update(int $id, array $data): void
    {
        KontrakKerja::findOrFail($id)->update($data);
    }

    public function delete(int $id): void
    {
        KontrakKerja::findOrFail($id)->delete();
    }

    // Dipanggil oleh Laravel Scheduler setiap hari
    public function cekKontrakAkanBerakhir(): void
    {
        $kontrakMauBerakhir = KontrakKerja::with('pegawai.user')
            ->where('status', 'aktif')
            ->where('notif_terkirim', false)
            ->whereNotNull('tanggal_selesai')
            ->whereRaw('DATEDIFF(tanggal_selesai, NOW()) <= 30')
            ->whereRaw('DATEDIFF(tanggal_selesai, NOW()) >= 0')
            ->get();

        foreach ($kontrakMauBerakhir as $kontrak) {
            $sisaHari = now()->diffInDays($kontrak->tanggal_selesai, false);

            // Notif ke Admin SDM
            $adminUsers = \App\Models\User::role('admin_sdm')->get();
            foreach ($adminUsers as $admin) {
                $this->notifikasiService->kirim(
                    $admin->id,
                    'Kontrak Kerja Akan Berakhir',
                    "Kontrak kerja {$kontrak->pegawai->nama_lengkap} ({$kontrak->nomor_kontrak}) akan berakhir dalam {$sisaHari} hari pada {$kontrak->tanggal_selesai->format('d/m/Y')}.",
                    'warning'
                );
            }

            // Notif ke pegawai bersangkutan
            if ($kontrak->pegawai->user) {
                $this->notifikasiService->kirim(
                    $kontrak->pegawai->user_id,
                    'Kontrak Kerja Anda Akan Berakhir',
                    "Kontrak kerja Anda ({$kontrak->nomor_kontrak}) akan berakhir dalam {$sisaHari} hari pada {$kontrak->tanggal_selesai->format('d/m/Y')}. Hubungi Admin SDM untuk informasi lebih lanjut.",
                    'warning'
                );
            }

            // Tandai notif sudah terkirim
            $kontrak->update(['notif_terkirim' => true]);
        }
    }
}