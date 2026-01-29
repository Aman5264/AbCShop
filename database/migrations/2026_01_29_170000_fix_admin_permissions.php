<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure the user exists and has the 'admin' role column set
        $adminEmail = 'admin@example.com';
        $user = User::where('email', $adminEmail)->first();

        if ($user) {
            $user->update(['role' => 'admin']);

            // 2. Ensure Spatie Roles exist
            $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            
            // 3. Ensure essential permissions exist
            $permissions = [
                'manage_products',
                'manage_orders',
                'manage_users',
                'manage_settings'
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            }

            // 4. Sync everything
            $adminRole->syncPermissions(Permission::all());
            $user->assignRole($adminRole);
            
            error_log("Admin permissions forced for $adminEmail");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
