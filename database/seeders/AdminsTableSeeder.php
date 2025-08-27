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
            'phone' => '1234567890',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('super_admin');

        $societyAdmin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Society Admin',
            'password' => bcrypt('password'),
            'society_id' => 1, // Assuming society with ID 1 exists
            'phone' => '12345678910',
            'is_active' => true,

        ]);
        $societyAdmin->assignRole('society_admin');
    }
}
