<?php

use Illuminate\Database\Seeder;
use App\Models\CustomizationOption;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $options = CustomizationOption::all();
        $sequence = 0;
        foreach($options as $option){
          $option->sequence = $sequence;
          $sequence++;
          $option->save();
        }

    }
}
