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
            'name' => 'Meat',
        ]);

        DB::table('sections')->insert([
            'name' => 'Chicken',
        ]);

        DB::table('sections')->insert([
            'name' => 'Vegan',
        ]);

        DB::table('sections')->insert([
            'name' => 'Desserts',
        ]);
        
        DB::table('sections')->insert([
            'name' => 'Drinks',
        ]);
    }
}
