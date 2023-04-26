<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WithoutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('withouts')->insert([
            'name' => 'onion',
        ]);

        DB::table('withouts')->insert([
            'name' => 'potatoes',
        ]);

        DB::table('withouts')->insert([
            'name' => 'tomatos',
        ]);

        DB::table('withouts')->insert([
            'name' => 'chesse',
        ]);

        DB::table('withouts')->insert([
            'name' => 'cucumber ',
        ]);

        DB::table('withouts')->insert([
            'name' => 'Jalapeno',
        ]);

        DB::table('withouts')->insert([
            'name' => 'lettuce',
        ]);
    }
}
