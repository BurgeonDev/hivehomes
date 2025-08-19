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
            AdminsTableSeeder::class,
            SocietiesTableSeeder::class,
            MembersTableSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
