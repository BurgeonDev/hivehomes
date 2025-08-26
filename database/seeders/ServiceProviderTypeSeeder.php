<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceProviderTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Plumber',
            'Electrician',
            'Carpenter',
            'Mechanic',
            'AC Technician',
            'House Cleaner',
            'Gardener',
            'Grocery Shop',
            'Butcher',
            'Bakery',
            'Tailor',
            'Laundry Service',
            'Salon / Barber',
            'Mobile Repair',
            'Electronics Repair',
            'Painter',
            'Security Services',
            'Courier Service',
        ];

        foreach ($types as $type) {
            DB::table('service_provider_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
