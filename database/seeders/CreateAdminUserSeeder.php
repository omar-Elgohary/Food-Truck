<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'random_id' => '#54854',
            'name' => 'Admin',
            'phone' => '+201234567890',
            'password' => bcrypt('12345678'),
            'type' => 'admin',
        ]);

        $user = User::create([
            'random_id' => '#67954',
            'name' => 'Sara Mohamed',
            'phone' => '+201018611653',
            'password' => bcrypt('12345678'),
            'type' => 'customer',
        ]);

        $user = User::create([
            'random_id' => '#17859',
            'name' => 'Mahmoud ElSayed',
            'phone' => '+201015696025',
            'password' => bcrypt('12345678'),
            'type' => 'customer',
        ]);

        $user = User::create([
            'random_id' => '#87986',
            'name' => 'Yosry Ahmed',
            'phone' => '+201015691035',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Nissan',
            'plate_num' => '43565',
            'food_type_id' => 1,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
        ]);

        $user = User::create([
            'random_id' => '#45721',
            'name' => 'Amina Sobhy',
            'phone' => '+20104526025',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Hyundai',
            'plate_num' => '54578',
            'food_type_id' => 2,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
            'delivery' => '1',
            'deliveryPrice' => 10,
        ]);

        $user = User::create([
            'random_id' => '#89478',
            'name' => 'Khaled Ezz',
            'phone' => '+20104896025',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Toyota',
            'plate_num' => '12321',
            'food_type_id' => 3,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
            'delivery' => '1',
            'deliveryPrice' => 15,
        ]);
    }
}
