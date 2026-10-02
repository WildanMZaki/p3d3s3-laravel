<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Workshop', 'slug' => 'workshop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seminar', 'slug' => 'seminar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bootcamp', 'slug' => 'bootcamp', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
