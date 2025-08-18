<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Role & permission management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.edit',

            // Content management
            'content.view',
            'content.create',
            'content.edit',
            'content.delete',

            // Reports
            'reports.view',
            'reports.generate',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
    }
}
