<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure permissions exist first
        $this->call(PermissionsTableSeeder::class);

        // Fetch all permissions
        $allPermissions = Permission::all();

        // 1) Super Admin: gets everything
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions($allPermissions);

        // 2) Society Admin: limited admin rights
        $societyAdmin = Role::firstOrCreate(['name' => 'society_admin']);
        $societyAdmin->syncPermissions([
            'users.view',
            'users.create',
            'users.edit',
            'roles.view',
            'content.view',
            'content.create',
            'content.edit',
            'reports.view',
        ]);

        // 3) Member: view-only permissions
        $member = Role::firstOrCreate(['name' => 'member']);
        $member->syncPermissions([
            'content.view',
            'reports.view',
        ]);
    }
}
