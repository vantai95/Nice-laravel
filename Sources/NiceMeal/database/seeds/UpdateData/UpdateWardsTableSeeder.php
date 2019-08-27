<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
 
use Faker\Factory as Faker;
 
class UpdateWardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * php artisan db:seed --class=UpdateWardsTableSeeder
     */
    public function run()
    {
       DB::table('wards')->insert([
           'id' => '27208',
           'name_en' => '15',
           'type_en' => 'Ward',
           'location' => '10 46 17N, 106 39 15E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27211',
           'name_en' => '05',
           'type_en' => 'Ward',
           'location' => '10 46 17N, 106 38 24E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27214',
           'name_en' => '14',
           'type_en' => 'Ward',
           'location' => '10 46 13N, 106 38 47E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27217',
           'name_en' => '11',
           'type_en' => 'Ward',
           'location' => '10 46 02N, 106 38 54E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27220',
           'name_en' => '03',
           'type_en' => 'Ward',
           'location' => '10 45 52N, 106 38 11E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27223',
           'name_en' => '10',
           'type_en' => 'Ward',
           'location' => '10 45 49N, 106 38 32E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27226',
           'name_en' => '13',
           'type_en' => 'Ward',
           'location' => '10 45 55N, 106 39 08E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27229',
           'name_en' => '08',
           'type_en' => 'Ward',
           'location' => '10 45 45N, 106 38 48E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27232',
           'name_en' => '09',
           'type_en' => 'Ward',
           'location' => '10 45 46N, 106 38 38E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27235',
           'name_en' => '12',
           'type_en' => 'Ward',
           'location' => '10 45 42N, 106 39 07E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27238',
           'name_en' => '07',
           'type_en' => 'Ward',
           'location' => '10 45 42N, 106 39 25E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27241',
           'name_en' => '06',
           'type_en' => 'Ward',
           'location' => '10 45 40N, 106 39 11E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27244',
           'name_en' => '04',
           'type_en' => 'Ward',
           'location' => '10 45 33N, 106 39 12E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27247',
           'name_en' => '01',
           'type_en' => 'Ward',
           'location' => '10 45 28N, 106 38 12E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27250',
           'name_en' => '02',
           'type_en' => 'Ward',
           'location' => '10 45 27N, 106 38 36E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27253',
           'name_en' => '16',
           'type_en' => 'Ward',
           'location' => '10 45 26N, 106 38 44E',
           'district_id' => '772'
       ]);
       DB::table('wards')->insert([
           'id' => '27256',
           'name_en' => '12',
           'type_en' => 'Ward',
           'location' => '10 46 01N, 106 42 13E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27259',
           'name_en' => '13',
           'type_en' => 'Ward',
           'location' => '10 45 48N, 106 42 30E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27262',
           'name_en' => '09',
           'type_en' => 'Ward',
           'location' => '10 45 52N, 106 42 02E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27265',
           'name_en' => '06',
           'type_en' => 'Ward',
           'location' => '10 45 42N, 106 41 52E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27268',
           'name_en' => '08',
           'type_en' => 'Ward',
           'location' => '10 45 40N, 106 42 03E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27271',
           'name_en' => '10',
           'type_en' => 'Ward',
           'location' => '10 45 42N, 106 42 13E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27274',
           'name_en' => '05',
           'type_en' => 'Ward',
           'location' => '10 45 35N, 106 41 44E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27277',
           'name_en' => '18',
           'type_en' => 'Ward',
           'location' => '10 45 30N, 106 42 54E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27280',
           'name_en' => '14',
           'type_en' => 'Ward',
           'location' => '10 45 33N, 106 42 25E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27283',
           'name_en' => '04',
           'type_en' => 'Ward',
           'location' => '10 45 26N, 106 42 05E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27286',
           'name_en' => '03',
           'type_en' => 'Ward',
           'location' => '10 45 23N, 106 41 48E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27289',
           'name_en' => '16',
           'type_en' => 'Ward',
           'location' => '10 45 23N, 106 42 39E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27292',
           'name_en' => '02',
           'type_en' => 'Ward',
           'location' => '10 45 27N, 106 41 35E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27295',
           'name_en' => '15',
           'type_en' => 'Ward',
           'location' => '10 45 22N, 106 42 21E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27298',
           'name_en' => '01',
           'type_en' => 'Ward',
           'location' => '10 45 21N, 106 41 21E',
           'district_id' => '773'
       ]);
       DB::table('wards')->insert([
           'id' => '27301',
           'name_en' => '04',
           'type_en' => 'Ward',
           'location' => '10 45 46N, 106 40 37E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27304',
           'name_en' => '09',
           'type_en' => 'Ward',
           'location' => '10 45 35N, 106 40 07E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27307',
           'name_en' => '03',
           'type_en' => 'Ward',
           'location' => '10 45 35N, 106 40 39E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27310',
           'name_en' => '12',
           'type_en' => 'Ward',
           'location' => '10 45 28N, 106 39 33E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27313',
           'name_en' => '02',
           'type_en' => 'Ward',
           'location' => '10 45 28N, 106 40 43E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27316',
           'name_en' => '08',
           'type_en' => 'Ward',
           'location' => '10 45 26N, 106 40 09E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27319',
           'name_en' => '15',
           'type_en' => 'Ward',
           'location' => '10 45 23N, 106 39 06E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27322',
           'name_en' => '07',
           'type_en' => 'Ward',
           'location' => '10 45 19N, 106 40 11E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27325',
           'name_en' => '01',
           'type_en' => 'Ward',
           'location' => '10 45 17N, 106 40 48E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27328',
           'name_en' => '11',
           'type_en' => 'Ward',
           'location' => '10 45 18N, 106 39 38E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27331',
           'name_en' => '14',
           'type_en' => 'Ward',
           'location' => '10 45 13N, 106 39 10E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27334',
           'name_en' => '05',
           'type_en' => 'Ward',
           'location' => '10 45 08N, 106 40 22E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27337',
           'name_en' => '06',
           'type_en' => 'Ward',
           'location' => '10 45 06N, 106 40 06E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27340',
           'name_en' => '10',
           'type_en' => 'Ward',
           'location' => '10 45 05N, 106 39 40E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27343',
           'name_en' => '13',
           'type_en' => 'Ward',
           'location' => '10 44 59N, 106 39 18E',
           'district_id' => '774'
       ]);
       DB::table('wards')->insert([
           'id' => '27346',
           'name_en' => '14',
           'type_en' => 'Ward',
           'location' => '10 45 30N, 106 37 46E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27349',
           'name_en' => '13',
           'type_en' => 'Ward',
           'location' => '10 45 10N, 106 37 38E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27352',
           'name_en' => '09',
           'type_en' => 'Ward',
           'location' => '10 45 11N, 106 38 17E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27355',
           'name_en' => '06',
           'type_en' => 'Ward',
           'location' => '10 45 10N, 106 38 39E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27358',
           'name_en' => '12',
           'type_en' => 'Ward',
           'location' => '10 45 04N, 106 37 47E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27361',
           'name_en' => '05',
           'type_en' => 'Ward',
           'location' => '10 44 57N, 106 38 31E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27364',
           'name_en' => '11',
           'type_en' => 'Ward',
           'location' => '10 44 46N, 106 37 46E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27367',
           'name_en' => '02',
           'type_en' => 'Ward',
           'location' => '10 45 06N, 106 38 55E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27370',
           'name_en' => '01',
           'type_en' => 'Ward',
           'location' => '10 44 49N, 106 38 58E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27373',
           'name_en' => '04',
           'type_en' => 'Ward',
           'location' => '10 44 47N, 106 38 37E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27376',
           'name_en' => '08',
           'type_en' => 'Ward',
           'location' => '10 44 38N, 106 38 13E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27379',
           'name_en' => '03',
           'type_en' => 'Ward',
           'location' => '10 44 38N, 106 38 40E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27382',
           'name_en' => '07',
           'type_en' => 'Ward',
           'location' => '10 44 21N, 106 38 13E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27385',
           'name_en' => '10',
           'type_en' => 'Ward',
           'location' => '10 44 14N, 106 37 34E',
           'district_id' => '775'
       ]);
       DB::table('wards')->insert([
           'id' => '27388',
           'name_en' => '08',
           'type_en' => 'Ward',
           'location' => '10 45 00N, 106 40 42E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27391',
           'name_en' => '02',
           'type_en' => 'Ward',
           'location' => '10 44 48N, 106 41 04E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27394',
           'name_en' => '01',
           'type_en' => 'Ward',
           'location' => '10 44 49N, 106 41 17E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27397',
           'name_en' => '03',
           'type_en' => 'Ward',
           'location' => '10 44 45N, 106 40 49E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27400',
           'name_en' => '11',
           'type_en' => 'Ward',
           'location' => '10 44 51N, 106 39 33E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27403',
           'name_en' => '09',
           'type_en' => 'Ward',
           'location' => '10 44 50N, 106 40 07E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27406',
           'name_en' => '10',
           'type_en' => 'Ward',
           'location' => '10 44 49N, 106 39 48E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27409',
           'name_en' => '04',
           'type_en' => 'Ward',
           'location' => '10 44 32N, 106 40 26E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27412',
           'name_en' => '13',
           'type_en' => 'Ward',
           'location' => '10 44 47N, 106 39 13E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27415',
           'name_en' => '12',
           'type_en' => 'Ward',
           'location' => '10 44 39N, 106 39 16E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27418',
           'name_en' => '05',
           'type_en' => 'Ward',
           'location' => '10 44 20N, 106 39 43E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27421',
           'name_en' => '14',
           'type_en' => 'Ward',
           'location' => '10 44 25N, 106 38 44E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27424',
           'name_en' => '06',
           'type_en' => 'Ward',
           'location' => '10 44 09N, 106 38 47E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27427',
           'name_en' => '15',
           'type_en' => 'Ward',
           'location' => '10 43 33N, 106 37 57E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27430',
           'name_en' => '16',
           'type_en' => 'Ward',
           'location' => '10 43 15N, 106 37 18E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27433',
           'name_en' => '07',
           'type_en' => 'Ward',
           'location' => '10 42 48N, 106 37 43E',
           'district_id' => '776'
       ]);
       DB::table('wards')->insert([
           'id' => '27436',
           'name_en' => 'Bình Hưng Hòa',
           'type_en' => 'Ward',
           'location' => '10 48 09N, 106 36 00E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27439',
           'name_en' => 'Binh Hưng Hoà A',
           'type_en' => 'Ward',
           'location' => '10 47 10N, 106 36 19E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27442',
           'name_en' => 'Binh Hưng Hoà B',
           'type_en' => 'Ward',
           'location' => '10 48 12N, 106 35 27E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27445',
           'name_en' => 'Bình Trị Đông',
           'type_en' => 'Ward',
           'location' => '10 46 01N, 106 36 56E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27448',
           'name_en' => 'Bình Trị Đông A',
           'type_en' => 'Ward',
           'location' => '10 46 06N, 106 35 58E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27451',
           'name_en' => 'Bình Trị Đông B',
           'type_en' => 'Ward',
           'location' => '10 45 14N, 106 36 37E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27454',
           'name_en' => 'Tân Tạo',
           'type_en' => 'Ward',
           'location' => '10 45 30N, 106 35 06E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27457',
           'name_en' => 'Tân Tạo A',
           'type_en' => 'Ward',
           'location' => '10 44 52N, 106 34 50E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27460',
           'name_en' => 'An Lạc',
           'type_en' => 'Ward',
           'location' => '10 43 45N, 106 36 36E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27463',
           'name_en' => 'An Lạc A',
           'type_en' => 'Ward',
           'location' => '10 44 06N, 106 36 37E',
           'district_id' => '777'
       ]);
       DB::table('wards')->insert([
           'id' => '27466',
           'name_en' => 'Tân Thuận Đông',
           'type_en' => 'Ward',
           'location' => '10 45 30N, 106 44 06E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27469',
           'name_en' => 'Tân Thuận Tây',
           'type_en' => 'Ward',
           'location' => '10 45 06N, 106 43 14E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27472',
           'name_en' => 'Tân Kiểng',
           'type_en' => 'Ward',
           'location' => '10 44 58N, 106 42 31E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27475',
           'name_en' => 'Tân Hưng',
           'type_en' => 'Ward',
           'location' => '10 44 43N, 106 41 45E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27478',
           'name_en' => 'Bình Thuận',
           'type_en' => 'Ward',
           'location' => '10 44 41N, 106 43 17E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27481',
           'name_en' => 'Tân Quy',
           'type_en' => 'Ward',
           'location' => '10 44 33N, 106 42 28E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27484',
           'name_en' => 'Phú Thuận',
           'type_en' => 'Ward',
           'location' => '10 43 47N, 106 44 48E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27487',
           'name_en' => 'Tân Phú',
           'type_en' => 'Ward',
           'location' => '10 43 34N, 106 43 22E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27490',
           'name_en' => 'Tân Phong',
           'type_en' => 'Ward',
           'location' => '10 43 49N, 106 42 13E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27493',
           'name_en' => 'Phú Mỹ',
           'type_en' => 'Ward',
           'location' => '10 42 32N, 106 44 11E',
           'district_id' => '778'
       ]);
       DB::table('wards')->insert([
           'id' => '27496',
           'name_en' => 'Củ Chi',
           'type_en' => 'Town',
           'location' => '10 58 31N, 106 29 32E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27499',
           'name_en' => 'Phú Mỹ Hưng',
           'type_en' => 'Ward',
           'location' => '11 07 19N, 106 27 39E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27502',
           'name_en' => 'An Phú',
           'type_en' => 'Ward',
           'location' => '11 06 53N, 106 29 58E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27505',
           'name_en' => 'Trung Lập Thượng',
           'type_en' => 'Ward',
           'location' => '11 03 58N, 106 26 14E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27508',
           'name_en' => 'An Nhơn Tây',
           'type_en' => 'Ward',
           'location' => '11 04 27N, 106 29 26E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27511',
           'name_en' => 'Nhuận Đức',
           'type_en' => 'Ward',
           'location' => '11 02 29N, 106 29 13E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27514',
           'name_en' => 'Phạm Văn Cội',
           'type_en' => 'Ward',
           'location' => '11 02 30N, 106 31 19E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27517',
           'name_en' => 'Phú Hòa Đông',
           'type_en' => 'Ward',
           'location' => '11 01 32N, 106 32 50E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27520',
           'name_en' => 'Trung Lập Hạ',
           'type_en' => 'Ward',
           'location' => '11 01 16N, 106 27 49E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27523',
           'name_en' => 'Trung An',
           'type_en' => 'Ward',
           'location' => '11 00 54N, 106 35 30E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27526',
           'name_en' => 'Phước Thạnh',
           'type_en' => 'Ward',
           'location' => '11 01 05N, 106 25 40E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27529',
           'name_en' => 'Phước Hiệp',
           'type_en' => 'Ward',
           'location' => '10 58 59N, 106 26 50E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27532',
           'name_en' => 'Tân An Hội',
           'type_en' => 'Ward',
           'location' => '10 58 04N, 106 28 39E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27535',
           'name_en' => 'Phước Vĩnh An',
           'type_en' => 'Ward',
           'location' => '10 58 58N, 106 31 10E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27538',
           'name_en' => 'Thái Mỹ',
           'type_en' => 'Ward',
           'location' => '10 59 12N, 106 23 35E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27541',
           'name_en' => 'Tân Thạnh Tây',
           'type_en' => 'Ward',
           'location' => '10 59 20N, 106 33 26E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27544',
           'name_en' => 'Hòa Phú',
           'type_en' => 'Ward',
           'location' => '10 58 41N, 106 36 31E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27547',
           'name_en' => 'Tân Thạnh Đông',
           'type_en' => 'Ward',
           'location' => '10 57 14N, 106 35 32E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27550',
           'name_en' => 'Bình Mỹ',
           'type_en' => 'Ward',
           'location' => '10 56 55N, 106 37 37E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27553',
           'name_en' => 'Tân Phú Trung',
           'type_en' => 'Ward',
           'location' => '10 56 50N, 106 32 59E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27556',
           'name_en' => 'Tân Thông Hội',
           'type_en' => 'Ward',
           'location' => '10 56 53N, 106 30 32E',
           'district_id' => '783'
       ]);
       DB::table('wards')->insert([
           'id' => '27559',
           'name_en' => 'Hóc Môn',
           'type_en' => 'Town',
           'location' => '10 53 12N, 106 35 28E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27562',
           'name_en' => 'Tân Hiệp',
           'type_en' => 'Ward',
           'location' => '10 54 40N, 106 35 26E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27565',
           'name_en' => 'Nhị Bình',
           'type_en' => 'Ward',
           'location' => '10 54 46N, 106 40 15E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27568',
           'name_en' => 'Đông Thạnh',
           'type_en' => 'Ward',
           'location' => '10 54 12N, 106 38 32E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27571',
           'name_en' => 'Tân Thới Nhì',
           'type_en' => 'Ward',
           'location' => '10 54 12N, 106 32 26E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27574',
           'name_en' => 'Thới Tam Thôn',
           'type_en' => 'Ward',
           'location' => '10 53 32N, 106 36 40E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27577',
           'name_en' => 'Xuân Thới Sơn',
           'type_en' => 'Ward',
           'location' => '10 52 42N, 106 33 24E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27580',
           'name_en' => 'Tân Xuân',
           'type_en' => 'Ward',
           'location' => '10 52 14N, 106 35 51E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27583',
           'name_en' => 'Xuân Thới Đông',
           'type_en' => 'Ward',
           'location' => '10 52 03N, 106 35 35E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27586',
           'name_en' => 'Trung Chánh',
           'type_en' => 'Ward',
           'location' => '10 52 00N, 106 36 24E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27589',
           'name_en' => 'Xuân Thới Thượng',
           'type_en' => 'Ward',
           'location' => '10 51 17N, 106 33 44E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27592',
           'name_en' => 'Bà Điểm',
           'type_en' => 'Ward',
           'location' => '10 50 34N, 106 35 43E',
           'district_id' => '784'
       ]);
       DB::table('wards')->insert([
           'id' => '27595',
           'name_en' => 'Tân Túc',
           'type_en' => 'Town',
           'location' => '10 41 15N, 106 34 14E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27598',
           'name_en' => 'Phạm Văn Hai',
           'type_en' => 'Ward',
           'location' => '10 49 24N, 106 31 41E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27601',
           'name_en' => 'Vĩnh Lộc A',
           'type_en' => 'Ward',
           'location' => '10 49 28N, 106 33 49E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27604',
           'name_en' => 'Vĩnh Lộc B',
           'type_en' => 'Ward',
           'location' => '10 47 27N, 106 33 43E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27607',
           'name_en' => 'Bình Lợi',
           'type_en' => 'Ward',
           'location' => '10 45 21N, 106 28 20E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27610',
           'name_en' => 'Lê Minh Xuân',
           'type_en' => 'Ward',
           'location' => '10 45 22N, 106 31 32E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27613',
           'name_en' => 'Tân Nhựt',
           'type_en' => 'Ward',
           'location' => '10 42 58N, 106 33 05E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27616',
           'name_en' => 'Tân Kiên',
           'type_en' => 'Ward',
           'location' => '10 42 55N, 106 34 59E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27619',
           'name_en' => 'Bình Hưng',
           'type_en' => 'Ward',
           'location' => '10 43 03N, 106 40 07E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27622',
           'name_en' => 'Phong Phú',
           'type_en' => 'Ward',
           'location' => '10 42 02N, 106 39 03E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27625',
           'name_en' => 'An Phú Tây',
           'type_en' => 'Ward',
           'location' => '10 41 17N, 106 36 22E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27628',
           'name_en' => 'Hưng Long',
           'type_en' => 'Ward',
           'location' => '10 40 02N, 106 37 26E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27631',
           'name_en' => 'Đa Phước',
           'type_en' => 'Ward',
           'location' => '10 39 51N, 106 39 28E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27634',
           'name_en' => 'Tân Quý Tây',
           'type_en' => 'Ward',
           'location' => '10 40 05N, 106 35 43E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27637',
           'name_en' => 'Bình Chánh',
           'type_en' => 'Ward',
           'location' => '10 39 55N, 106 33 53E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27640',
           'name_en' => 'Quy Đức',
           'type_en' => 'Ward',
           'location' => '10 38 24N, 106 38 45E',
           'district_id' => '785'
       ]);
       DB::table('wards')->insert([
           'id' => '27643',
           'name_en' => 'Nhà Bè',
           'type_en' => 'Town',
           'location' => '10 41 38N, 106 44 23E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27646',
           'name_en' => 'Phước Kiển',
           'type_en' => 'Ward',
           'location' => '10 42 14N, 106 42 24E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27649',
           'name_en' => 'Phước Lộc',
           'type_en' => 'Ward',
           'location' => '10 41 57N, 106 41 03E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27652',
           'name_en' => 'Nhơn Đức',
           'type_en' => 'Ward',
           'location' => '10 40 20N, 106 42 05E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27655',
           'name_en' => 'Phú Xuân',
           'type_en' => 'Ward',
           'location' => '10 40 43N, 106 44 57E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27658',
           'name_en' => 'Long Thới',
           'type_en' => 'Ward',
           'location' => '10 39 09N, 106 43 22E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27661',
           'name_en' => 'Hiệp Phước',
           'type_en' => 'Ward',
           'location' => '10 36 49N, 106 44 57E',
           'district_id' => '786'
       ]);
       DB::table('wards')->insert([
           'id' => '27664',
           'name_en' => 'Cần Thạnh',
           'type_en' => 'Town',
           'location' => '10 24 41N, 106 57 11E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27667',
           'name_en' => 'Bình Khánh',
           'type_en' => 'Ward',
           'location' => '10 38 22N, 106 47 24E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27670',
           'name_en' => 'Tam Thôn Hiệp',
           'type_en' => 'Ward',
           'location' => '10 35 00N, 106 52 57E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27673',
           'name_en' => 'An Thới Đông',
           'type_en' => 'Ward',
           'location' => '10 33 17N, 106 48 20E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27676',
           'name_en' => 'Thạnh An',
           'type_en' => 'Ward',
           'location' => '10 30 57N, 106 58 19E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27679',
           'name_en' => 'Long Hòa',
           'type_en' => 'Ward',
           'location' => '10 26 45N, 106 54 09E',
           'district_id' => '787'
       ]);
       DB::table('wards')->insert([
           'id' => '27682',
           'name_en' => 'Lý Nhơn',
           'type_en' => 'Ward',
           'location' => '10 27 22N, 106 48 09E',
           'district_id' => '787'
       ]);

       DB::table('wards')
        ->update([
            "name_ja" =>  DB::raw("`name_en`"),
            "type_ja" =>  DB::raw("`type_en`")
        ]);
    }
}