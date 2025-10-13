<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role 'agen' tersedia
        $roleAgen = Role::firstOrCreate(['name' => 'agen']);
        $roleMahasiswa = Role::firstOrCreate(['name' => 'mahasiswa']);
        $roleDosen = Role::firstOrCreate(['name' => 'dosen']);

        // Buat user spesifik dari seeder lama (untuk keperluan testing)
        $specificUsers = [
            [
                'username' => 'agen111',
                'name' => 'Agen Sekolah Pertama',
                'asal_sekolah' => 'SMA Negeri 1 Tanjungpinang',
                'email' => 'agen01@example.com',
                'nomor_hp' => '081234567801',
            ],
            [
                'username' => 'agen222',
                'name' => 'Agen Sekolah Kedua',
                'asal_sekolah' => 'SMA Negeri 2 Tanjungpinang',
                'email' => 'agen02@example.com',
                'nomor_hp' => '081234567802',
            ],
        ];

        foreach ($specificUsers as $userData) {
            $user = User::factory()->create([
                'username' => $userData['username'],
                'name' => $userData['name'],
                'asal_sekolah' => $userData['asal_sekolah'],
                'email' => $userData['email'],
                'nomor_hp' => $userData['nomor_hp'],
                'password' => Hash::make('123123'),
            ]);
            $user->syncRoles([$roleAgen]);
        }

        // Buat user random menggunakan factory
        User::factory()->count(10)->create()->each(function ($user) use ($roleAgen) {
            $user->syncRoles([$roleAgen]);
        });

        // Buat beberapa user dengan role berbeda
        User::factory()->count(3)->withRole('mahasiswa')->create()->each(function ($user) use ($roleMahasiswa) {
            $user->syncRoles([$roleMahasiswa]);
        });

        User::factory()->count(2)->withRole('dosen')->create()->each(function ($user) use ($roleDosen) {
            $user->syncRoles([$roleDosen]);
        });

        // Buat beberapa user dengan status online
        User::factory()->count(2)->online()->create()->each(function ($user) use ($roleAgen) {
            $user->syncRoles([$roleAgen]);
        });

        // Buat beberapa user dengan siakad_id
        User::factory()->count(3)->withSiakad()->create()->each(function ($user) use ($roleAgen) {
            $user->syncRoles([$roleAgen]);
        });

        // Buat user dengan data lengkap
        User::factory()->count(2)->complete()->create()->each(function ($user) use ($roleAgen) {
            $user->syncRoles([$roleAgen]);
        });
    }
}
