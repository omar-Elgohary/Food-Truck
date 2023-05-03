<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionsSeeder extends Seeder
{
    public function run(): void
    { 
        DB::table('sections')->insert([
            'seller_id' => '3',
            'food_type_id' => '1',
            'name' => 'Fishes',        
        ]);
        
        DB::table('sections')->insert([
            'seller_id' => '4',
            'food_type_id' => '2',
            'name' => 'Burgers',
        ]);

        DB::table('sections')->insert([
            'seller_id' => '5',
            'food_type_id' => '3',
            'name' => 'Vegan',
        ]);

        DB::table('sections')->insert([
            'seller_id' => '3',
            'food_type_id' => '4',
            'name' => 'Sweets',
        ]);
    }
}
