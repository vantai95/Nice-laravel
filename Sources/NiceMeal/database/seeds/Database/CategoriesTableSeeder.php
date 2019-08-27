<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
 
use Faker\Factory as Faker;
 
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant_ids = array(
            1,
            2,
            3,
            4,
            5,
            6
        );
        $title_en = ['Sushi & Sashimi', 'Rice & Noodle','Pizza'];
        foreach ( range( 1, 10 ) as $index ) {
            DB::table('categories')->insert([
                [
                    'title_en' => $title_en[ array_rand( $title_en, 1 ) ],
                    'restaurant_id' => $restaurant_ids[ array_rand( $restaurant_ids, 1 ) ],
                    'slug' => $index
                ]
            ]);
        }
    }
}