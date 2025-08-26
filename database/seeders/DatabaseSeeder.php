<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            LocationSeeder::class,
            AdminsTableSeeder::class,
            SocietiesTableSeeder::class,
            CategorySeeder::class,
            ProductCategorySeeder::class,
            ServiceProviderTypeSeeder::class,
        ]);
    }
}
