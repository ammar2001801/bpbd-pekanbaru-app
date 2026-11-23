<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@bpbd.pekanbaru.go.id'],
            [
                'name' => 'Administrator BPBD',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081275001122',
                'jabatan' => 'Pranata Komputer / Admin IT Pusdalops',
                'status_aktif' => true,
            ]
        );

        // 2. Akun Petugas
        User::updateOrCreate(
            ['email' => 'petugas@bpbd.pekanbaru.go.id'],
            [
                'name' => 'Rian Hidayat (Petugas Pusdalops)',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'no_hp' => '082169004455',
                'jabatan' => 'Petugas TRC Pusdalops-PB',
                'status_aktif' => true,
            ]
        );

        // 3. Akun Pimpinan (Read-Only & Tinjauan Laporan)
        User::updateOrCreate(
            ['email' => 'pimpinan@bpbd.pekanbaru.go.id'],
            [
                'name' => 'Zarman Candra, S.STP, M.Si',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
                'no_hp' => '081176008899',
                'jabatan' => 'Kepala Pelaksana BPBD Kota Pekanbaru',
                'status_aktif' => true,
            ]
        );
    }
}
