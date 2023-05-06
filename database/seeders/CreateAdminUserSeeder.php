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
            'name' => 'Admin',
            'phone' => '+201234567890',
            'password' => bcrypt('12345678'),
            'type' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Sara Mohamed',
            'phone' => '+201018611653',
            'password' => bcrypt('12345678'),
            'type' => 'customer',
        ]);

        $user = User::create([
            'name' => 'Mahmoud ElSayed',
            'phone' => '+201015696025',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Honda',
            'plate_num' => '13567',
            'food_type_id' => 1,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
            'delivery' => '1',
            'deliveryPrice' => 5,
        ]);

        $user = User::create([
            'name' => 'Osama Gamal',
            'phone' => '+201015691035',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Nissan',
            'plate_num' => '43565',
            'food_type_id' => 2,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
        ]);

        $user = User::create([
            'name' => 'Amina Ali',
            'phone' => '+20104526025',
            'password' => bcrypt('12345678'),
            'type' => 'seller',
            'vehicle_name' => 'Hyundai',
            'plate_num' => '54578',
            'food_type_id' => 3,
            'food_truck_licence' => 'food_truck_licence',
            'vehicle_image' => 'vehicle_image',
            'delivery' => '1',
            'deliveryPrice' => 10,
        ]);
    }
}
