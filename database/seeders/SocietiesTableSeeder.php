<?php

namespace Database\Seeders;

use App\Models\Society;
use Illuminate\Database\Seeder;

class SocietiesTableSeeder extends Seeder
{
    public function run(): void
    {
        Society::create([
            'name' => 'Hive Residency',
            'address' => '123 Main Street, Hive Town',
            'country_id' => 1,     // Make sure these IDs exist
            'state_id' => 1,
            'city_id' => 1,
            'admin_user_id' => 1,  // An existing user who is an admin of this society
        ]);

        Society::create([
            'name' => 'Green Valley',
            'address' => 'Plot #45, Sector B',
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 1,
            'admin_user_id' => 2,
        ]);
    }
}
