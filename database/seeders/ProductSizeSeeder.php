<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_size')->insert([[
            'product_id' => 1,
            'size_id' => 1
        ],[
            'product_id' => 1,
            'size_id' => 2
        ],[
            'product_id' => 1,
            'size_id' => 3
        ],[
            'product_id' => 4,
            'size_id' => 4
        ],[
            'product_id' => 4,
            'size_id' => 5
        ],[
            'product_id' => 4,
            'size_id' => 6
        ]]);
    }
}
