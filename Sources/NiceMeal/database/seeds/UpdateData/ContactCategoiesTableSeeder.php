<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContactCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * php artisan db:seed --class=ContactCategoriesTableSeeder
     */
    public function run()
    {
        $contact_categories = [
            [
                'title_en' => 'How it works',
                'title_ja' => 'How it works',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        if(DB::table('contact_categories')->count() == 0){
            DB::table('contact_categories')->insert($contact_categories);
        }
    }
}

