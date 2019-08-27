<?php

use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardReseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $wards = Ward::all();

      $sequence = 1;

      $wardsNameIsNumber = $wards->filter(function($item,$value){
        return is_numeric($item->name_en);
      });
      $wardsNameIsNumber = $wardsNameIsNumber->sortBy('name_en');

      $wardsNameIsNotNumber = $wards->filter(function($item,$value){
        return !is_numeric($item->name_en);
      });

      $wardsNameIsNotNumber = $wardsNameIsNotNumber->sortBy('name_en');

      foreach($wardsNameIsNotNumber as $ward){
        $ward->sequence = $sequence;
        $sequence++;
        $ward->save();
      }

      foreach($wardsNameIsNumber as $ward){
        $ward->sequence = $sequence;
        $sequence++;
        $ward->save();
      }
    }
}
