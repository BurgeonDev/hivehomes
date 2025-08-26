<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Giveaway',
            'Event',
            'Announcement',
            'News',
            'Update',
            'Promotion',
            'Offer',
            'Tutorial',
            'Tips & Tricks',
            'Partnership',
            'Poll',
            'Survey',
            'Milestone',
        ];

        collect($categories)->each(
            fn($name) => Category::firstOrCreate(['name' => $name])
        );
    }
}
