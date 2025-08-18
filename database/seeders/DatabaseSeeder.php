<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            LocationSeeder::class,
            AdminsTableSeeder::class,      // ✅ Admins first
            SocietiesTableSeeder::class,   // ✅ Now this will work
            MembersTableSeeder::class,
        ]);
    }
}
