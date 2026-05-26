<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'foto'          => $data['foto'] ?? null, // ← langsung pakai dari controller
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

        $updateUser = ['name' => $data['nama_lengkap'] ?? $pegawai->nama_lengkap,
                       'email' => $data['email'] ?? $pegawai->user->email];

        if (!empty($data['password'])) {
            $updateUser['password'] = Hash::make($data['password']);
        }

        // Hanya update user kalau ada data user
        if (isset($data['nama_lengkap']) || isset($data['email'])) {
            $pegawai->user->update($updateUser);
        }

        // Update role kalau ada
        if (!empty($data['role'])) {
            $pegawai->user->syncRoles([$data['role']]);
        }
// Handle upload foto
$fotoPath = null;
if (!empty($data['foto']) && $data['foto'] instanceof \Illuminate\Http\UploadedFile) {
    $extension = $data['foto']->getClientOriginalExtension();
    $filename  = time() . '_' . uniqid() . '.' . $extension;
    $data['foto']->move(public_path('foto-pegawai'), $filename);
    $fotoPath = 'foto-pegawai/' . $filename;
}
        // Update data pegawai
        $updateData = array_filter([
            'nip'           => $data['nip'] ?? null,
            'nidn'          => $data['nidn'] ?? null,
            'nama_lengkap'  => $data['nama_lengkap'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'tempat_lahir'  => $data['tempat_lahir'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'no_hp'         => $data['no_hp'] ?? null,
            'email'         => $data['email'] ?? null,
            'status'        => $data['status'] ?? null,
            'jenis_pegawai' => $data['jenis_pegawai'] ?? null,
            'foto'          => $data['foto'] ?? null,
        ], fn($v) => $v !== null);

        $this->pegawaiRepository->update($id, $updateData);
    });
}

  public function delete(int $id): void
{
    DB::transaction(function () use ($id) {
        $pegawai = $this->pegawaiRepository->findById($id);
        
        // Hapus jabatan pivot dulu
        $pegawai->jabatans()->detach();
        
        $user = $pegawai->user;
        
        // Hapus pegawai dulu, baru user
        $this->pegawaiRepository->delete($id);
        
        if ($user) {
            $user->delete();
        }
    });
}

    public function assignJabatan(int $pegawaiId, int $jabatanId, string $jenis = 'rangkap'): void
    {
        $pegawai = $this->pegawaiRepository->findById($pegawaiId);

        // Cek apakah jabatan sudah diassign
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
            'is_aktif'       => false,
            'tanggal_selesai' => now(),
        ]);
    }
}