<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class RestaurantDeliveriesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create( 'vi_VN' );
		$distrct_ids = array(
			760,
			761,
			762,
			763,
			764,
			765
		);
		$price_range = array(
			'15 min',
			'30 min',
			'45 min',
			'1 hr',
			'2 hr',
			'4 hr',
			'1 day',
		);
		foreach ( range( 1, 50 ) as $index ) {
			$inx = array_rand( $distrct_ids, 1 );
			$location = $distrct_ids[$inx];
			DB::table( 'restaurant_delivery_settings' )->insert( [
				'location'         => $location,
				'delivery_time'    => $price_range[array_rand( $price_range, 1 )],
				'delivery_cost'    => $faker->numberBetween( 100, 1000 ) * 1000,
				'min_order_amount' => $faker->numberBetween( 100, 1000 ) * 1000,
				'restaurant_id'       => rand( 1, 3 ),
			] );
		}
	}
}