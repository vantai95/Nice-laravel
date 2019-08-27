<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
 
use Faker\Factory as Faker;
 
class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('provinces')->insert([
//            'id' => '33300',
//            'name_en' => '',
//            'type' => ''
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '01',
//            'name_en' => 'Hà Nội',
//            'type' => 'City'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '02',
//            'name_en' => 'Hà Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '04',
//            'name_en' => 'Cao Bằng',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '06',
//            'name_en' => 'Bắc Kạn',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '08',
//            'name_en' => 'Tuyên Quang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '10',
//            'name_en' => 'Lào Cai',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '11',
//            'name_en' => 'Điện Biên',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '12',
//            'name_en' => 'Lai Châu',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '14',
//            'name_en' => 'Sơn La',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '15',
//            'name_en' => 'Yên Bái',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '17',
//            'name_en' => 'Hòa Bình',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '19',
//            'name_en' => 'Thái Nguyên',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '20',
//            'name_en' => 'Lạng Sơn',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '22',
//            'name_en' => 'Quảng Ninh',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '24',
//            'name_en' => 'Bắc Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '25',
//            'name_en' => 'Phú Thọ',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '26',
//            'name_en' => 'Vĩnh Phúc',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '27',
//            'name_en' => 'Bắc Ninh',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '30',
//            'name_en' => 'Hải Dương',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '31',
//            'name_en' => 'Hải Phòng',
//            'type' => 'City'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '33',
//            'name_en' => 'Hưng Yên',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '34',
//            'name_en' => 'Thái Bình',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '35',
//            'name_en' => 'Hà Nam',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '36',
//            'name_en' => 'Nam Định',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '37',
//            'name_en' => 'Ninh Bình',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '38',
//            'name_en' => 'Thanh Hóa',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '40',
//            'name_en' => 'Nghệ An',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '42',
//            'name_en' => 'Hà Tĩnh',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '44',
//            'name_en' => 'Quảng Bình',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '45',
//            'name_en' => 'Quảng Trị',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '46',
//            'name_en' => 'Thừa Thiên Huế',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '48',
//            'name_en' => 'Đà Nẵng',
//            'type' => 'City'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '49',
//            'name_en' => 'Quảng Nam',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '51',
//            'name_en' => 'Quảng Ngãi',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '52',
//            'name_en' => 'Bình Định',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '54',
//            'name_en' => 'Phú Yên',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '56',
//            'name_en' => 'Khánh Hòa',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '58',
//            'name_en' => 'Ninh Thuận',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '60',
//            'name_en' => 'Bình Thuận',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '62',
//            'name_en' => 'Kon Tum',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '64',
//            'name_en' => 'Gia Lai',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '66',
//            'name_en' => 'Đắk Lắk',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '67',
//            'name_en' => 'Đắk Nông',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '68',
//            'name_en' => 'Lâm Đồng',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '70',
//            'name_en' => 'Bình Phước',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '72',
//            'name_en' => 'Tây Ninh',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '74',
//            'name_en' => 'Bình Dương',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '75',
//            'name_en' => 'Đồng Nai',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '77',
//            'name_en' => 'Bà Rịa - Vũng Tàu',
//            'type' => 'Province'
//        ]);
        DB::table('provinces')->insert([
            'id' => '1',
            'name_en' => 'Hồ Chí Minh',
            'type_en' => 'City'
        ]);
//        DB::table('provinces')->insert([
//            'id' => '80',
//            'name_en' => 'Long An',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '82',
//            'name_en' => 'Tiền Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '83',
//            'name_en' => 'Bến Tre',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '84',
//            'name_en' => 'Trà Vinh',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '86',
//            'name_en' => 'Vĩnh Long',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '87',
//            'name_en' => 'Đồng Tháp',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '89',
//            'name_en' => 'An Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '91',
//            'name_en' => 'Kiên Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '92',
//            'name_en' => 'Cần Thơ',
//            'type' => 'City'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '93',
//            'name_en' => 'Hậu Giang',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '94',
//            'name_en' => 'Sóc Trăng',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '95',
//            'name_en' => 'Bạc Liêu',
//            'type' => 'Province'
//        ]);
//        DB::table('provinces')->insert([
//            'id' => '96',
//            'name_en' => 'Cà Mau',
//            'type' => 'Province'
//        ]);
    }
}