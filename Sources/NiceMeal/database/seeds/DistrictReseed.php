<?php

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictReseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $districts = District::all();
        $districts = $districts->map(function($item,$value){
          $item->name_en = str_replace("District","",$item->name_en);
          $item->name_en = trim($item->name_en,' ');
          return $item;
        });

        $sequence = 1;

        $districtsNameIsNumber = $districts->filter(function($item,$value){
          return is_numeric($item->name_en);
        });
        $districtsNameIsNumber = $districtsNameIsNumber->sortBy('name_en');

        $districtsNameIsNotNumber = $districts->filter(function($item,$value){
          return !is_numeric($item->name_en);
        });

        $districtsNameIsNotNumber = $districtsNameIsNotNumber->sortBy('name_en');

        foreach($districtsNameIsNotNumber as $district){
          $district->name_en = $district->name_en.' District';
          $district->sequence = $sequence;
          $sequence++;
          $district->save();
        }

        foreach($districtsNameIsNumber as $district){
          $district->name_en = 'District '.$district->name_en;
          $district->sequence = $sequence;
          $sequence++;
          $district->save();
        }

    }
}
