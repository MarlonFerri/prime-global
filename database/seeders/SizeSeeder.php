<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([[
            'id' => 1,
            'name' => '38'
        ],[
            'id' => 2,
            'name' => '40',
        ],[
            'id' => 3,
            'name' => '42',
        ],[
            'id' => 4,
            'name' => '20cm',
        ],[
            'id' => 5,
            'name' => '22cm',
        ],[
            'id' => 6,
            'name' => '24cm',
        ]]);
    }
}
