<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignUserRoles extends Command
{
    protected $signature = 'roles:assign'; //ini command nya
    protected $description = 'Assign roles to existing users';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Assign role berdasarkan default_role atau logic lainnya
            $role = $user->default_role ?: 'mahasiswa';
            $user->assignRole($role);
            $this->info("Assigned role {$role} to user {$user->name}");
        }

        $this->info('All users have been assigned roles.');
    }
}
