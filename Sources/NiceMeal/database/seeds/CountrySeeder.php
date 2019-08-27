<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $countries = [
          [
            'name_en' => 'Việt Nam',
            'name_ja' => 'Việt Nam',
          ]
        ];
        Country::insert($countries);
    }
}
