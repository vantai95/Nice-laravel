<?php

use Illuminate\Database\Seeder;

class SettingKeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting_keys = [
            [
                'name' => 'exchange_rate'
            ]
        ];

        if(\DB::table('setting_keys')->count() == 0){
            \DB::table('setting_keys')->insert($setting_keys);
        }

    }
}
