<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            'seller_id' => '3',
            'section_id' => '1',
            'name' => 'gambarey',
            'price' => '210',
            'calories' => '350',
            'description' => 'new gambary'
        ]);

        DB::table('products')->insert([
            'seller_id' => '4',
            'section_id' => '2',
            'name' => 'Spicy Burger',
            'price' => '130',
            'calories' => '470',
            'description' => 'new Spicy Burger'
        ]);

        DB::table('products')->insert([
            'seller_id' => '3',
            'section_id' => '4',
            'name' => 'tofies',
            'price' => '80',
            'calories' => '175',
            'description' => 'new toitrl tofies'
        ]);
    }
}
