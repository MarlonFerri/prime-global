<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('products')->insert([[
                'id' => 1,
                'name' => 'Adidas 1',
                'category_id' => 1
            ],[
                'id' => 2,
                'name' => 'Adidas 2',
                'category_id' => 1
            ],[
                'id' => 3,
                'name' => 'Adidas 3',
                'category_id' => 1
            ],[
                'id' => 4,
                'name' => 'Necklace 1',
                'category_id' => 2
            ],[
                'id' => 5,
                'name' => 'Necklace 2',
                'category_id' => 2
            ],[
                'id' => 6,
                'name' => 'Necklace 3',
                'category_id' => 2
            ]]);
    }
}
