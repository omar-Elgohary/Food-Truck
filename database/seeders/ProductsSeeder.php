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
            'seller_id' => '4',
            'section_id' => '1',
            'name' => 'Gambary',
            'price' => '380',
            'calories' => '330',
            'description' => 'New Gambary Jambo'
        ]);

        DB::table('products')->insert([
            'seller_id' => '4',
            'section_id' => '1',
            'name' => 'Sobeet',
            'price' => '230',
            'calories' => '255',
            'description' => 'New Sobeet Fishes'
        ]);

        DB::table('products')->insert([
            'seller_id' => '5',
            'section_id' => '2',
            'name' => 'Spicy Burger',
            'price' => '180',
            'calories' => '460',
            'description' => 'New Spicy Meat Burger'
        ]);

        DB::table('products')->insert([
            'seller_id' => '5',
            'section_id' => '2',
            'name' => 'Fried Chicken',
            'price' => '260',
            'calories' => '820',
            'description' => 'New Fried Chicken'
        ]);

        DB::table('products')->insert([
            'seller_id' => '6',
            'section_id' => '3',
            'name' => 'Vegetable Pasta',
            'price' => '110',
            'calories' => '225',
            'description' => 'New Healthy Vegetable Pasta'
        ]);

        DB::table('products')->insert([
            'seller_id' => '6',
            'section_id' => '3',
            'name' => 'Macaroni Salad',
            'price' => '80',
            'calories' => '130',
            'description' => 'New Healthy Macaroni Salad'
        ]);
    }
}
