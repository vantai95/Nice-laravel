<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersRestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		foreach ( range( 1, 10 ) as $index ) {
		    
			DB::table( 'users_restaurants' )->insert( [
				'role_id'     => 1,
				'user_id'     => 1,
			    'restaurant_id'     => $index
			] );
        }
        DB::table( 'users_restaurants' )->insert( [
            'role_id'     => 2,
            'user_id'     => 2,
            'restaurant_id'     => 2
        ] );
    }
}
