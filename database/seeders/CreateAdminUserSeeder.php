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
            'name' => 'Omar ElGohary',
            'phone' => '01156513661',
            'password' => bcrypt('12345678'),
            'type' => 'admin',
        ]);
    }
}
