<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class RestaurantWorkTimesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create( 'vi_VN' );

		$working_date = array(
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sunday',
		);
		foreach ( range( 1, 20 ) as $index ) {
			for($i=0;$i<count($working_date);$i++){
				DB::table( 'restaurant_work_times' )->insert( [
					'working_date_en'    => $working_date[$i],
					'opening_hours'    => "08:00",
					'closing_hours'    => "22:00",
					'restaurant_id'       => $index,
				] );
			}
			
		}
	}
}