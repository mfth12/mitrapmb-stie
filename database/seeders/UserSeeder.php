<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role 'agen' tersedia
        $role = Role::firstOrCreate(['name' => 'agen']);

        $users = [
            [
                'siakad_id'         => null,
                'username'          => 'agen111',
                'password'          => Hash::make('123123'),
                'name'              => 'Agen Sekolah Pertama',
                'asal_sekolah'      => 'SMA Negeri 1 Tanjungpinang',
                'email'             => 'agen01@example.com',
                'nomor_hp'          => '081234567801',
                'nomor_hp2'         => null,
                'email_verified_at' => Carbon::now(),
                'about'             => 'Agen pertamanya sistem.',
                'default_role'      => 'agen',
                'theme'             => 'default',
                'avatar'            => null,
                'status'            => 'active',
                'status_login'      => 'offline',
                'isdeleted'         => false,
                'last_logged_in'    => null,
                'last_synced_at'    => null,
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'siakad_id'         => null,
                'username'          => 'agen222',
                'password'          => Hash::make('123123'),
                'name'              => 'Agen Sekolah Kedua',
                'asal_sekolah'      => 'SMA Negeri 2 Tanjungpinang',
                'email'             => 'agen02@example.com',
                'nomor_hp'          => '081234567802',
                'nomor_hp2'         => null,
                'email_verified_at' => Carbon::now(),
                'about'             => 'Agen kedua untuk pengujian.',
                'default_role'      => 'agen',
                'theme'             => 'default',
                'avatar'            => null,
                'status'            => 'active',
                'status_login'      => 'offline',
                'isdeleted'         => false,
                'last_logged_in'    => null,
                'last_synced_at'    => null,
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['username' => $data['username']],
                $data
            );

            // Sinkronkan role
            $user->syncRoles([$role]);
        }
    }
}
