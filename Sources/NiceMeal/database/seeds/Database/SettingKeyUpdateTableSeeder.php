<?php

use Illuminate\Database\Seeder;

class SettingKeyUpdateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void 
     * * php artisan db:seed --class=SettingKeyUpdateTableSeeder
     */
    public function run()
    {
        $setting_keys = [
            [
                'name' => 'paypal'
            ],
            [
                'name' => 'nganluong'
            ]
        ];
        \DB::table('setting_keys')->insert($setting_keys);    

    }
}
