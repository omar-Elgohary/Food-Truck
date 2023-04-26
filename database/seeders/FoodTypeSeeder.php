<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('food_types')->insert([
            'name' => 'Sea Food',
        ]);

        DB::table('food_types')->insert([
            'name' => 'Fast Food',
        ]);

        DB::table('food_types')->insert([
            'name' => 'Desert',
        ]);
    }
}
