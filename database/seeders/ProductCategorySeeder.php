<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Groceries',
            'Furniture',
            'Toys',
            'Sports Equipment',
            'Beauty Products'
        ];

        foreach ($categories as $name) {
            DB::table('product_categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $name . ' category description.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
