<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super_admin');

        $societyAdmin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Society Admin',
            'password' => bcrypt('password'),
        ]);
        $societyAdmin->assignRole('society_admin');
    }
}
