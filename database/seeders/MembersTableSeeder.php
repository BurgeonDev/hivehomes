<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class MembersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Single predefined member
        $member = User::firstOrCreate([
            'email' => 'member@hivehomes.com',
        ], [
            'name' => 'Regular Member',
            'password' => bcrypt('password'),
        ]);
        $member->assignRole('member');

        // 10 random members
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('member');
        });
    }
}
