<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PegawaiService
{
    public function __construct(
        protected PegawaiRepositoryInterface $pegawaiRepository
    ) {}

    public function getAll()
    {
        return $this->pegawaiRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->pegawaiRepository->findById($id);
    }

    public function create(array $data): void
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['nama_lengkap'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole($data['role']);

            $pegawai = $this->pegawaiRepository->create([
                'user_id'       => $user->id,
                'nip'           => $data['nip'] ?? null,
                'nidn'          => $data['nidn'] ?? null,
                'nama_lengkap'  => $data['nama_lengkap'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir'  => $data['tempat_lahir'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat'        => $data['alamat'] ?? null,
                'no_hp'         => $data['no_hp'] ?? null,
                'email'         => $data['email'],
                'status'        => $data['status'],
                'jenis_pegawai' => $data['jenis_pegawai'],
                'sisa_cuti'     => 12,
                'foto'          => $data['foto'] ?? null,
            ]);

            if (!empty($data['jabatan_id'])) {
                $pegawai->jabatans()->attach($data['jabatan_id'], [
                    'tanggal_mulai' => now(),
                    'is_aktif'      => true,
                    'jenis'         => 'utama',
                ]);
            }
        });
    }

    public function update(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $pegawai = $this->pegawaiRepository->findById($id);

            // Update user
            $updateUser = [
                'name'  => $data['nama_lengkap'] ?? $pegawai->nama_lengkap,
                'email' => $data['email'] ?? $pegawai->user->email,
            ];

            if (!empty($data['password'])) {
                $updateUser['password'] = Hash::make($data['password']);
            }

            $pegawai->user->update($updateUser);

            // Update role
            if (!empty($data['role'])) {
                $pegawai->user->syncRoles([$data['role']]);
            }

            // Handle foto — pakai path yang sudah diproses controller
            // Controller sudah set $data['foto'] = 'foto-pegawai/filename.ext'
            // Kalau tidak ada foto baru, pertahankan foto lama
            $updateData = [
                'nip'           => $data['nip'] ?? null,
                'nidn'          => $data['nidn'] ?? null,
                'nama_lengkap'  => $data['nama_lengkap'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir'  => $data['tempat_lahir'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat'        => $data['alamat'] ?? null,
                'no_hp'         => $data['no_hp'] ?? null,
                'email'         => $data['email'],
                'status'        => $data['status'],
                'jenis_pegawai' => $data['jenis_pegawai'],
            ];

            // Hanya update foto kalau ada foto baru (string path dari controller)
            if (!empty($data['foto']) && is_string($data['foto'])) {
                $updateData['foto'] = $data['foto'];
            }

            $this->pegawaiRepository->update($id, $updateData);
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $pegawai = $this->pegawaiRepository->findById($id);

            $pegawai->jabatans()->detach();

            $user = $pegawai->user;

            $this->pegawaiRepository->delete($id);

            if ($user) {
                $user->delete();
            }
        });
    }

    public function assignJabatan(int $pegawaiId, int $jabatanId, string $jenis = 'rangkap'): void
    {
        $pegawai = $this->pegawaiRepository->findById($pegawaiId);

        $exists = $pegawai->jabatans()
            ->wherePivot('jabatan_id', $jabatanId)
            ->wherePivot('is_aktif', true)
            ->exists();

        if (!$exists) {
            $pegawai->jabatans()->attach($jabatanId, [
                'tanggal_mulai' => now(),
                'is_aktif'      => true,
                'jenis'         => $jenis,
            ]);
        }
    }

    public function revokeJabatan(int $pegawaiId, int $jabatanId): void
    {
        $pegawai = $this->pegawaiRepository->findById($pegawaiId);
        $pegawai->jabatans()->updateExistingPivot($jabatanId, [
            'is_aktif'        => false,
            'tanggal_selesai' => now(),
        ]);
    }
}