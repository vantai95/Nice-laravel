<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
 
use Faker\Factory as Faker;
 
class CuisinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table( 'cuisines' )->insert( [
		    [
			    'name_en' => 'Italian',
		    ],
		    [
			    'name_en' => 'Indian',
		    ],
            [
                'name_en' => 'France',
            ],
            [
                'name_en' => 'Korean',
            ],
	    ] );
    }
}