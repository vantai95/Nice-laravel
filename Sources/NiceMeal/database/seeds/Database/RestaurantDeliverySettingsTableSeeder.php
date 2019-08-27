<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class RestaurantDeliverySettingsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create( 'vi_VN' );

		foreach ( range( 1, 3 ) as $index ) {
			foreach ( range( 760, 763 ) as $index1 ) {
				DB::table( 'restaurant_delivery_settings' )->insert( [
					'min_order_amount' => 50000,
					'delivery_cost'    => 20000,
					'from'    => "10000",
                    'to'    => "100000",
					'district_id'    => $index1,
					'restaurant_id'       => $index,
				] );
			}
			
		}
	}
}