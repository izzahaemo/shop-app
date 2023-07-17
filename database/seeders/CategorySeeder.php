<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id'=> 1 ,'name'=> 'Electronic'],
            ['id'=> 2 ,'name'=> 'Beauty'],
            ['id'=> 3 ,'name'=> 'Household'],
        ];
        DB::table('categories')->insert($data);
    }
}
