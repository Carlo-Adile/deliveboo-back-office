<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\TypeSeeder;
use Database\Seeders\PivotSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UsersSeeder::class,
            TypeSeeder::class,
            RestaurantSeeder::class,      
            DishSeeder::class,
            OrderSeeder::class,
            PivotSeeder::class
        ]);    
    }
}
