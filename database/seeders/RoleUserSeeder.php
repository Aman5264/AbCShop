<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Manager User
        $manager = User::firstOrCreate([
            'email' => 'manager@example.com',
        ], [
            'name' => 'Manager User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $manager->syncRoles('manager');

        // Staff User
        $staff = User::firstOrCreate([
            'email' => 'staff@example.com',
        ], [
            'name' => 'Staff User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $staff->syncRoles('staff');

        echo "Manager and Staff users created.\n";
    }
}
