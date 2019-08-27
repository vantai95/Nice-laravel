<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class RestaurantCuisineTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker       = Faker::create( 'vi_VN' );
		$restaurant_ids = array(
			1,
            2,
            3
		);
        $cuisine_ids = array(
            1,
            2,
            3,
            4
        );
		foreach ( range( 1, 10 ) as $index ) {
            DB::table( 'restaurants_cuisines' )->insert( [
                'restaurant_id'            => $restaurant_ids[ array_rand( $restaurant_ids, 1 ) ],
                'cuisine_id'           => $cuisine_ids[ array_rand( $cuisine_ids, 1 ) ]
            ] );
		}
	}
}