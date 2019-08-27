<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class RestaurantTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker       = Faker::create( 'vi_VN' );
		$distrct_ids = array(
			761,
			762,
			763,
			764,
			765
		);
		$highlight_labels = ['new', 'promotion', 'popular', 'high quality'];

        foreach ( range( 1, 10 ) as $index ) {
            $otp = rand(1, 3);
            switch($otp) {
                case 1:
                case 2:
                    $otp_value = 3;
                    break;
                case 3:
                    $otp_value = 100000;
            }
            DB::table( 'restaurants' )->insert( [
                'name_en'            => $faker->lastName . ' ' . $faker->firstName,
                'name_ja'            => $faker->lastName . ' ' . $faker->firstName,
                'email'           => $faker->email,
                'phone'           => $faker->phoneNumber,
                'slug'              => $faker->slug,
                'address_en'         => $faker->address,
                'description_en'     => $faker->paragraph,
                'highlight_label_en' => $highlight_labels[ array_rand( $highlight_labels, 1 ) ],
                'title_brief_en'     => $faker->city,
                
                'address_ja'         => $faker->address,
                'description_ja'     => $faker->paragraph,
                'highlight_label_ja' => $highlight_labels[ array_rand( $highlight_labels, 1 ) ],
                'title_brief_ja'     => $faker->city,

                'province_id'     => 1,
                'district_id'     => 760,
                'ward_id'         => '26734',
                'banner'          => 1,
                'image'           => 2,
                'review_rate' => rand(1, 5),
                'otp' => $otp,
                'otp_value' => $otp_value,
                'slug' =>'nha-hang-'.$index
            ] );
        }

		foreach ( range( 1, 50 ) as $index ) {
		    $otp = rand(1, 3);
		    switch($otp) {
                case 1:
                case 2:
                    $otp_value = 3;
                    break;
                case 3:
                    $otp_value = 100000;
            }
			DB::table( 'restaurants' )->insert( [
				'name_en'            => $faker->lastName . ' ' . $faker->firstName,
				'email'           => $faker->email,
				'phone'           => $faker->phoneNumber,
				'slug'              => $faker->slug,
				'address_en'         => $faker->address,
				'description_en'     => $faker->paragraph,
				'highlight_label_en' => $highlight_labels[ array_rand( $highlight_labels, 1 ) ],
				'title_brief_en'     => $faker->city,
				'province_id'     => 1,
				'district_id'     => $distrct_ids[ array_rand( $distrct_ids, 1 ) ],
				'ward_id'         => '26734',
				'banner'          => 1,
				'image'           => 2,
				'review_rate' => rand(1, 5),
                'otp' => $otp,
                'otp_value' => $otp_value,
				'slug' =>'nha-hang-'.$index
			] );
		}
	}
}