<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Insert countries
        $pakistanId = DB::table('countries')->insertGetId(['name' => 'Pakistan']);
        $usaId = DB::table('countries')->insertGetId(['name' => 'United States']);

        // Insert states for Pakistan
        $punjabId = DB::table('states')->insertGetId(['name' => 'Punjab', 'country_id' => $pakistanId]);
        $sindhId = DB::table('states')->insertGetId(['name' => 'Sindh', 'country_id' => $pakistanId]);

        // Insert states for USA
        $californiaId = DB::table('states')->insertGetId(['name' => 'California', 'country_id' => $usaId]);
        $texasId = DB::table('states')->insertGetId(['name' => 'Texas', 'country_id' => $usaId]);

        // Insert cities for Punjab
        DB::table('cities')->insert([
            ['name' => 'Lahore', 'state_id' => $punjabId],
            ['name' => 'Multan', 'state_id' => $punjabId],
        ]);

        // Insert cities for Sindh
        DB::table('cities')->insert([
            ['name' => 'Karachi', 'state_id' => $sindhId],
            ['name' => 'Hyderabad', 'state_id' => $sindhId],
        ]);

        // Insert cities for California
        DB::table('cities')->insert([
            ['name' => 'Los Angeles', 'state_id' => $californiaId],
            ['name' => 'San Francisco', 'state_id' => $californiaId],
        ]);

        // Insert cities for Texas
        DB::table('cities')->insert([
            ['name' => 'Houston', 'state_id' => $texasId],
            ['name' => 'Dallas', 'state_id' => $texasId],
        ]);
    }
}
