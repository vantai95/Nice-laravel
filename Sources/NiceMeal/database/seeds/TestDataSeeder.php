<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(WardsTableSeeder::class);
        $this->call(RestaurantTableSeeder::class);
        $this->call(UsersRestaurantsTableSeeder::class);
        $this->call(RestaurantWorkTimesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CuisinesTableSeeder::class);
        $this->call(RestaurantCuisineTableSeeder::class);
        $this->call(RestaurantDeliverySettingsTableSeeder::class);
    }
}
