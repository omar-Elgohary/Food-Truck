<?php
namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrdersSeeder;
use Database\Seeders\FoodTypeSeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\SectionsSeeder;
use Database\Seeders\CreateAdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        // \App\Models\User::factory()->create([
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
            // ]);


            $this->call([
                FoodTypeSeeder::class,
                CreateAdminUserSeeder::class,
                WithoutSeeder::class,
                SectionsSeeder::class,
                ProductsSeeder::class,
            ]);
        }
}
