<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Home, Garden & Tools',
                'slug' => Str::slug('Home, Garden & Tools'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beauty & Personal Care',
                'slug' => Str::slug('Beauty & Personal Care'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => Str::slug('Sports & Outdoors'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Automotive & Industrial',
                'slug' => Str::slug('Automotive & Industrial'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health & Household',
                'slug' => Str::slug('Health & Household'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Products',
                'slug' => Str::slug('Office Products'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pet Supplies',
                'slug' => Str::slug('Pet Supplies'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grocery & Gourmet Food',
                'slug' => Str::slug('Grocery & Gourmet Food'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('departments')->insert($departments);

    }
}
