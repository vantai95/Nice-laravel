<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class DistrictsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run() {

		DB::table( 'districts' )->insert( [ [
			'id'         => '760',
			'name_en'       => '1',
			'type_en'       => 'District',
			'location'   => '10 46 34N, 106 41 45E',
			'province_id' => '1',
            'slug' => 'quan-1'
		], [
			'id'         => '761',
			'name_en'       => '12',
			'type_en'       => 'District',
			'location'   => '10 51 43N, 106 39 32E',
			'province_id' => '1',
            'slug' => 'quan-12'
		], [
			'id'         => '762',
			'name_en'       => 'Thủ Đức',
			'type_en'       => 'District',
			'location'   => '10 51 20N, 106 45 05E',
			'province_id' => '1',
            'slug' => 'quan-thu-duc'
		], [
			'id'         => '763',
			'name_en'       => '9',
			'type_en'       => 'District',
			'location'   => '10 49 49N, 106 49 03E',
			'province_id' => '1',
            'slug' => 'quan-9'
		], [
			'id'         => '764',
			'name_en'       => 'Gò Vấp',
			'type_en'       => 'District',
			'location'   => '10 50 12N, 106 39 52E',
			'province_id' => '1',
            'slug' => 'quan-go-vap'
		], [
			'id'         => '765',
			'name_en'       => 'Bình Thạnh',
			'type_en'       => 'District',
			'location'   => '10 48 46N, 106 42 57E',
			'province_id' => '1',
            'slug' => 'quan-binh-thanh'
		], [
			'id'         => '766',
			'name_en'       => 'Tân Bình',
			'type_en'       => 'District',
			'location'   => '10 48 13N, 106 39 03E',
			'province_id' => '1',
            'slug' => 'quan-tan-binh'
		], [
			'id'         => '767',
			'name_en'       => 'Tân Phú',
			'type_en'       => 'District',
			'location'   => '10 47 32N, 106 37 31E',
			'province_id' => '1',
            'slug' => 'quan-tan-phu'
		], [
			'id'         => '768',
			'name_en'       => 'Phú Nhuận',
			'type_en'       => 'District',
			'location'   => '10 48 06N, 106 40 39E',
			'province_id' => '1',
            'slug' => 'quan-phu-nhuan'
		], [
			'id'         => '769',
			'name_en'       => '2',
			'type_en'       => 'District',
			'location'   => '10 46 51N, 106 45 25E',
			'province_id' => '1',
            'slug' => 'quan-2'
		], [
			'id'         => '770',
			'name_en'       => '3',
			'type_en'       => 'District',
			'location'   => '10 46 48N, 106 40 46E',
			'province_id' => '1',
            'slug' => 'quan-3'
		], [
			'id'         => '771',
			'name_en'       => '10',
			'type_en'       => 'District',
			'location'   => '10 46 25N, 106 40 02E',
			'province_id' => '1',
            'slug' => 'quan-10'
		], [
			'id'         => '772',
			'name_en'       => '11',
			'type_en'       => 'District',
			'location'   => '10 46 01N, 106 38 44E',
			'province_id' => '1',
            'slug' => 'quan-11'
		], [
			'id'         => '773',
			'name_en'       => '4',
			'type_en'       => 'District',
			'location'   => '10 45 42N, 106 42 09E',
			'province_id' => '1',
            'slug' => 'quan-4'
		], [
			'id'         => '774',
			'name_en'       => '5',
			'type_en'       => 'District',
			'location'   => '10 45 24N, 106 40 00E',
			'province_id' => '1',
            'slug' => 'quan-5'
		], [
			'id'         => '775',
			'name_en'       => '6',
			'type_en'       => 'District',
			'location'   => '10 44 46N, 106 38 10E',
			'province_id' => '1',
            'slug' => 'quan-6'
		], [
			'id'         => '776',
			'name_en'       => '8',
			'type_en'       => 'District',
			'location'   => '10 43 24N, 106 37 40E',
			'province_id' => '1',
            'slug' => 'quan-8'
		], [
			'id'         => '777',
			'name_en'       => 'Bình Tân',
			'type_en'       => 'District',
			'location'   => '10 46 16N, 106 35 26E',
			'province_id' => '1',
            'slug' => 'quan-binh-tan'
		], [
			'id'         => '778',
			'name_en'       => '7',
			'type_en'       => 'District',
			'location'   => '10 44 19N, 106 43 35E',
			'province_id' => '1',
            'slug' => 'quan-7'
		], [
			'id'         => '783',
			'name_en'       => 'Củ Chi',
			'type_en'       => 'Huyện',
			'location'   => '11 02 17N, 106 30 20E',
			'province_id' => '1',
            'slug' => 'huyen-cu-chi'
		], [
			'id'         => '784',
			'name_en'       => 'Hóc Môn',
			'type_en'       => 'Huyện',
			'location'   => '10 52 42N, 106 35 33E',
			'province_id' => '1',
            'slug' => 'huyen-hoc-mon'
		], [
			'id'         => '785',
			'name_en'       => 'Bình Chánh',
			'type_en'       => 'Huyện',
			'location'   => '10 45 01N, 106 30 45E',
			'province_id' => '1',
            'slug' => 'huyen-binh-chanh'
		], [
			'id'         => '786',
			'name_en'       => 'Nhà Bè',
			'type_en'       => 'Huyện',
			'location'   => '10 39 06N, 106 43 35E',
			'province_id' => '1',
            'slug' => 'huyen-nha-be'
		], [
			'id'         => '787',
			'name_en'       => 'Cần Giờ',
			'type_en'       => 'Huyện',
			'location'   => '10 30 43N, 106 52 50E',
			'province_id' => '1',
            'slug' => 'huyen-can-gio'
		] ] );

//        DB::table('districts')->insert([
//            'id' => '33300',
//            'name_en' => '',
//            'type_en' => '',
//            'location' => '',
//            'province_id' => ''
//        ]);
//        DB::table('districts')->insert([
//            'id' => '001',
//            'name_en' => 'Ba Đình',
//            'type_en' => 'District',
//            'location' => '21 02 08N, 105 49 38E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '002',
//            'name_en' => 'Hoàn Kiếm',
//            'type_en' => 'District',
//            'location' => '21 01 53N, 105 51 09E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '003',
//            'name_en' => 'Tây Hồ',
//            'type_en' => 'District',
//            'location' => '21 04 10N, 105 49 07E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '004',
//            'name_en' => 'Long Biên',
//            'type_en' => 'District',
//            'location' => '21 02 21N, 105 53 07E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '005',
//            'name_en' => 'Cầu Giấy',
//            'type_en' => 'District',
//            'location' => '21 01 52N, 105 47 20E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '006',
//            'name_en' => 'Đống Đa',
//            'type_en' => 'District',
//            'location' => '21 00 56N, 105 49 06E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '007',
//            'name_en' => 'Hai Bà Trưng',
//            'type_en' => 'District',
//            'location' => '21 00 27N, 105 51 35E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '008',
//            'name_en' => 'Hoàng Mai',
//            'type_en' => 'District',
//            'location' => '20 58 33N, 105 51 22E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '009',
//            'name_en' => 'Thanh Xuân',
//            'type_en' => 'District',
//            'location' => '20 59 44N, 105 48 56E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '016',
//            'name_en' => 'Sóc Sơn',
//            'type_en' => 'Huyện',
//            'location' => '21 16 55N, 105 49 46E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '017',
//            'name_en' => 'Đông Anh',
//            'type_en' => 'Huyện',
//            'location' => '21 08 16N, 105 49 38E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '018',
//            'name_en' => 'Gia Lâm',
//            'type_en' => 'Huyện',
//            'location' => '21 01 28N, 105 56 54E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '019',
//            'name_en' => 'Từ Liêm',
//            'type_en' => 'Huyện',
//            'location' => '21 02 39N, 105 45 32E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '020',
//            'name_en' => 'Thanh Trì',
//            'type_en' => 'Huyện',
//            'location' => '20 56 32N, 105 50 55E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '024',
//            'name_en' => 'Hà Giang',
//            'type_en' => 'Thị Xã',
//            'location' => '22 46 23N, 105 02 39E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '026',
//            'name_en' => 'Đồng Văn',
//            'type_en' => 'Huyện',
//            'location' => '23 14 34N, 105 15 48E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '027',
//            'name_en' => 'Mèo Vạc',
//            'type_en' => 'Huyện',
//            'location' => '23 09 10N, 105 26 38E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '028',
//            'name_en' => 'Yên Minh',
//            'type_en' => 'Huyện',
//            'location' => '23 04 20N, 105 10 13E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '029',
//            'name_en' => 'Quản Bạ',
//            'type_en' => 'Huyện',
//            'location' => '23 04 03N, 104 58 05E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '030',
//            'name_en' => 'Vị Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '22 45 50N, 104 56 26E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '031',
//            'name_en' => 'Bắc Mê',
//            'type_en' => 'Huyện',
//            'location' => '22 45 48N, 105 16 26E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '032',
//            'name_en' => 'Hoàng Su Phì',
//            'type_en' => 'Huyện',
//            'location' => '22 41 37N, 104 40 06E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '033',
//            'name_en' => 'Xín Mần',
//            'type_en' => 'Huyện',
//            'location' => '22 38 05N, 104 28 35E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '034',
//            'name_en' => 'Bắc Quang',
//            'type_en' => 'Huyện',
//            'location' => '22 23 42N, 104 55 06E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '035',
//            'name_en' => 'Quang Bình',
//            'type_en' => 'Huyện',
//            'location' => '22 23 07N, 104 37 11E',
//            'province_id' => '02'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '040',
//            'name_en' => 'Cao Bằng',
//            'type_en' => 'Thị Xã',
//            'location' => '22 39 20N, 106 15 20E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '042',
//            'name_en' => 'Bảo Lâm',
//            'type_en' => 'Huyện',
//            'location' => '22 52 37N, 105 27 28E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '043',
//            'name_en' => 'Bảo Lạc',
//            'type_en' => 'Huyện',
//            'location' => '22 52 31N, 105 42 41E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '044',
//            'name_en' => 'Thông Nông',
//            'type_en' => 'Huyện',
//            'location' => '22 49 09N, 105 57 05E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '045',
//            'name_en' => 'Hà Quảng',
//            'type_en' => 'Huyện',
//            'location' => '22 53 42N, 106 06 32E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '046',
//            'name_en' => 'Trà Lĩnh',
//            'type_en' => 'Huyện',
//            'location' => '22 48 14N, 106 19 47E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '047',
//            'name_en' => 'Trùng Khánh',
//            'type_en' => 'Huyện',
//            'location' => '22 49 31N, 106 33 58E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '048',
//            'name_en' => 'Hạ Lang',
//            'type_en' => 'Huyện',
//            'location' => '22 42 37N, 106 41 42E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '049',
//            'name_en' => 'Quảng Uyên',
//            'type_en' => 'Huyện',
//            'location' => '22 40 15N, 106 27 42E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '050',
//            'name_en' => 'Phục Hoà',
//            'type_en' => 'Huyện',
//            'location' => '22 33 52N, 106 30 02E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '051',
//            'name_en' => 'Hoà An',
//            'type_en' => 'Huyện',
//            'location' => '22 41 20N, 106 02 05E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '052',
//            'name_en' => 'Nguyên Bình',
//            'type_en' => 'Huyện',
//            'location' => '22 38 52N, 105 57 02E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '053',
//            'name_en' => 'Thạch An',
//            'type_en' => 'Huyện',
//            'location' => '22 28 51N, 106 19 51E',
//            'province_id' => '04'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '058',
//            'name_en' => 'Bắc Kạn',
//            'type_en' => 'Thị Xã',
//            'location' => '22 08 00N, 105 51 10E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '060',
//            'name_en' => 'Pác Nặm',
//            'type_en' => 'Huyện',
//            'location' => '22 35 46N, 105 40 25E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '061',
//            'name_en' => 'Ba Bể',
//            'type_en' => 'Huyện',
//            'location' => '22 23 54N, 105 43 30E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '062',
//            'name_en' => 'Ngân Sơn',
//            'type_en' => 'Huyện',
//            'location' => '22 25 50N, 106 01 00E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '063',
//            'name_en' => 'Bạch Thông',
//            'type_en' => 'Huyện',
//            'location' => '22 12 04N, 105 51 01E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '064',
//            'name_en' => 'Chợ Đồn',
//            'type_en' => 'Huyện',
//            'location' => '22 11 18N, 105 34 43E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '065',
//            'name_en' => 'Chợ Mới',
//            'type_en' => 'Huyện',
//            'location' => '21 57 56N, 105 51 29E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '066',
//            'name_en' => 'Na Rì',
//            'type_en' => 'Huyện',
//            'location' => '22 09 48N, 106 05 09E',
//            'province_id' => '06'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '070',
//            'name_en' => 'Tuyên Quang',
//            'type_en' => 'Thị Xã',
//            'location' => '21 49 40N, 105 13 12E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '072',
//            'name_en' => 'Nà Hang',
//            'type_en' => 'Huyện',
//            'location' => '22 28 34N, 105 21 03E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '073',
//            'name_en' => 'Chiêm Hóa',
//            'type_en' => 'Huyện',
//            'location' => '22 12 49N, 105 14 32E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '074',
//            'name_en' => 'Hàm Yên',
//            'type_en' => 'Huyện',
//            'location' => '22 05 46N, 105 00 13E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '075',
//            'name_en' => 'Yên Sơn',
//            'type_en' => 'Huyện',
//            'location' => '21 51 53N, 105 18 14E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '076',
//            'name_en' => 'Sơn Dương',
//            'type_en' => 'Huyện',
//            'location' => '21 40 22N, 105 22 57E',
//            'province_id' => '08'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '080',
//            'name_en' => 'Lào Cai',
//            'type_en' => 'Thành Phố',
//            'location' => '22 25 07N, 103 58 43E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '082',
//            'name_en' => 'Bát Xát',
//            'type_en' => 'Huyện',
//            'location' => '22 35 50N, 103 44 49E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '083',
//            'name_en' => 'Mường Khương',
//            'type_en' => 'Huyện',
//            'location' => '22 41 05N, 104 08 26E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '084',
//            'name_en' => 'Si Ma Cai',
//            'type_en' => 'Huyện',
//            'location' => '22 39 46N, 104 16 05E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '085',
//            'name_en' => 'Bắc Hà',
//            'type_en' => 'Huyện',
//            'location' => '22 30 08N, 104 18 54E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '086',
//            'name_en' => 'Bảo Thắng',
//            'type_en' => 'Huyện',
//            'location' => '22 22 47N, 104 10 00E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '087',
//            'name_en' => 'Bảo Yên',
//            'type_en' => 'Huyện',
//            'location' => '22 17 38N, 104 25 02E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '088',
//            'name_en' => 'Sa Pa',
//            'type_en' => 'Huyện',
//            'location' => '22 18 54N, 103 54 18E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '089',
//            'name_en' => 'Văn Bàn',
//            'type_en' => 'Huyện',
//            'location' => '22 03 48N, 104 10 59E',
//            'province_id' => '10'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '094',
//            'name_en' => 'Điện Biên Phủ',
//            'type_en' => 'Thành Phố',
//            'location' => '21 24 52N, 103 02 31E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '095',
//            'name_en' => 'Mường Lay',
//            'type_en' => 'Thị Xã',
//            'location' => '22 01 47N, 103 07 10E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '096',
//            'name_en' => 'Mường Nhé',
//            'type_en' => 'Huyện',
//            'location' => '22 06 11N, 102 30 54E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '097',
//            'name_en' => 'Mường Chà',
//            'type_en' => 'Huyện',
//            'location' => '21 50 31N, 103 03 15E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '098',
//            'name_en' => 'Tủa Chùa',
//            'type_en' => 'Huyện',
//            'location' => '21 58 19N, 103 23 01E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '099',
//            'name_en' => 'Tuần Giáo',
//            'type_en' => 'Huyện',
//            'location' => '21 38 03N, 103 21 06E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '100',
//            'name_en' => 'Điện Biên',
//            'type_en' => 'Huyện',
//            'location' => '21 15 19N, 103 03 19E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '101',
//            'name_en' => 'Điện Biên Đông',
//            'type_en' => 'Huyện',
//            'location' => '21 14 07N, 103 15 19E',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '102',
//            'name_en' => 'Mường Ảng',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '11'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '104',
//            'name_en' => 'Lai Châu',
//            'type_en' => 'Thị Xã',
//            'location' => '22 23 15N, 103 24 22E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '106',
//            'name_en' => 'Tam Đường',
//            'type_en' => 'Huyện',
//            'location' => '22 20 16N, 103 32 53E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '107',
//            'name_en' => 'Mường Tè',
//            'type_en' => 'Huyện',
//            'location' => '22 24 16N, 102 43 11E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '108',
//            'name_en' => 'Sìn Hồ',
//            'type_en' => 'Huyện',
//            'location' => '22 17 21N, 103 18 12E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '109',
//            'name_en' => 'Phong Thổ',
//            'type_en' => 'Huyện',
//            'location' => '22 38 24N, 103 22 38E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '110',
//            'name_en' => 'Than Uyên',
//            'type_en' => 'Huyện',
//            'location' => '21 59 35N, 103 45 30E',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '111',
//            'name_en' => 'Tân Uyên',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '12'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '116',
//            'name_en' => 'Sơn La',
//            'type_en' => 'Thành Phố',
//            'location' => '21 20 39N, 103 54 52E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '118',
//            'name_en' => 'Quỳnh Nhai',
//            'type_en' => 'Huyện',
//            'location' => '21 46 34N, 103 39 02E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '119',
//            'name_en' => 'Thuận Châu',
//            'type_en' => 'Huyện',
//            'location' => '21 24 54N, 103 39 46E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '120',
//            'name_en' => 'Mường La',
//            'type_en' => 'Huyện',
//            'location' => '21 31 38N, 104 02 48E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '121',
//            'name_en' => 'Bắc Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 13 23N, 104 22 09E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '122',
//            'name_en' => 'Phù Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 13 33N, 104 41 51E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '123',
//            'name_en' => 'Mộc Châu',
//            'type_en' => 'Huyện',
//            'location' => '20 49 21N, 104 43 10E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '124',
//            'name_en' => 'Yên Châu',
//            'type_en' => 'Huyện',
//            'location' => '20 59 33N, 104 19 51E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '125',
//            'name_en' => 'Mai Sơn',
//            'type_en' => 'Huyện',
//            'location' => '21 10 08N, 103 59 36E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '126',
//            'name_en' => 'Sông Mã',
//            'type_en' => 'Huyện',
//            'location' => '21 06 04N, 103 43 56E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '127',
//            'name_en' => 'Sốp Cộp',
//            'type_en' => 'Huyện',
//            'location' => '20 52 46N, 103 30 38E',
//            'province_id' => '14'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '132',
//            'name_en' => 'Yên Bái',
//            'type_en' => 'Thành Phố',
//            'location' => '21 44 28N, 104 53 42E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '133',
//            'name_en' => 'Nghĩa Lộ',
//            'type_en' => 'Thị Xã',
//            'location' => '21 35 58N, 104 29 22E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '135',
//            'name_en' => 'Lục Yên',
//            'type_en' => 'Huyện',
//            'location' => '22 06 44N, 104 43 12E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '136',
//            'name_en' => 'Văn Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 55 55N, 104 33 51E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '137',
//            'name_en' => 'Mù Cang Chải',
//            'type_en' => 'Huyện',
//            'location' => '21 48 22N, 104 09 01E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '138',
//            'name_en' => 'Trấn Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 42 20N, 104 48 56E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '139',
//            'name_en' => 'Trạm Tấu',
//            'type_en' => 'Huyện',
//            'location' => '21 30 40N, 104 28 03E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '140',
//            'name_en' => 'Văn Chấn',
//            'type_en' => 'Huyện',
//            'location' => '21 34 15N, 104 35 19E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '141',
//            'name_en' => 'Yên Bình',
//            'type_en' => 'Huyện',
//            'location' => '21 52 24N, 104 55 16E',
//            'province_id' => '15'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '148',
//            'name_en' => 'Hòa Bình',
//            'type_en' => 'Thành Phố',
//            'location' => '20 50 36N, 105 19 20E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '150',
//            'name_en' => 'Đà Bắc',
//            'type_en' => 'Huyện',
//            'location' => '20 55 58N, 105 04 52E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '151',
//            'name_en' => 'Kỳ Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 54 06N, 105 23 18E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '152',
//            'name_en' => 'Lương Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 53 16N, 105 30 55E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '153',
//            'name_en' => 'Kim Bôi',
//            'type_en' => 'Huyện',
//            'location' => '20 40 34N, 105 32 15E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '154',
//            'name_en' => 'Cao Phong',
//            'type_en' => 'Huyện',
//            'location' => '20 41 23N, 105 17 48E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '155',
//            'name_en' => 'Tân Lạc',
//            'type_en' => 'Huyện',
//            'location' => '20 36 44N, 105 15 03E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '156',
//            'name_en' => 'Mai Châu',
//            'type_en' => 'Huyện',
//            'location' => '20 40 56N, 104 59 46E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '157',
//            'name_en' => 'Lạc Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 29 59N, 105 24 57E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '158',
//            'name_en' => 'Yên Thủy',
//            'type_en' => 'Huyện',
//            'location' => '20 25 42N, 105 37 59E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '159',
//            'name_en' => 'Lạc Thủy',
//            'type_en' => 'Huyện',
//            'location' => '20 29 12N, 105 44 06E',
//            'province_id' => '17'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '164',
//            'name_en' => 'Thái Nguyên',
//            'type_en' => 'Thành Phố',
//            'location' => '21 33 20N, 105 48 26E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '165',
//            'name_en' => 'Sông Công',
//            'type_en' => 'Thị Xã',
//            'location' => '21 29 14N, 105 48 47E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '167',
//            'name_en' => 'Định Hóa',
//            'type_en' => 'Huyện',
//            'location' => '21 53 50N, 105 38 01E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '168',
//            'name_en' => 'Phú Lương',
//            'type_en' => 'Huyện',
//            'location' => '21 45 57N, 105 43 22E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '169',
//            'name_en' => 'Đồng Hỷ',
//            'type_en' => 'Huyện',
//            'location' => '21 41 10N, 105 55 43E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '170',
//            'name_en' => 'Võ Nhai',
//            'type_en' => 'Huyện',
//            'location' => '21 47 14N, 106 02 29E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '171',
//            'name_en' => 'Đại Từ',
//            'type_en' => 'Huyện',
//            'location' => '21 36 17N, 105 37 28E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '172',
//            'name_en' => 'Phổ Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 27 08N, 105 45 19E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '173',
//            'name_en' => 'Phú Bình',
//            'type_en' => 'Huyện',
//            'location' => '21 29 36N, 105 57 42E',
//            'province_id' => '19'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '178',
//            'name_en' => 'Lạng Sơn',
//            'type_en' => 'Thành Phố',
//            'location' => '21 51 19N, 106 44 50E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '180',
//            'name_en' => 'Tràng Định',
//            'type_en' => 'Huyện',
//            'location' => '22 18 09N, 106 26 32E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '181',
//            'name_en' => 'Bình Gia',
//            'type_en' => 'Huyện',
//            'location' => '22 03 56N, 106 19 01E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '182',
//            'name_en' => 'Văn Lãng',
//            'type_en' => 'Huyện',
//            'location' => '22 01 59N, 106 34 17E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '183',
//            'name_en' => 'Cao Lộc',
//            'type_en' => 'Huyện',
//            'location' => '21 53 05N, 106 50 34E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '184',
//            'name_en' => 'Văn Quan',
//            'type_en' => 'Huyện',
//            'location' => '21 51 04N, 106 33 04E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '185',
//            'name_en' => 'Bắc Sơn',
//            'type_en' => 'Huyện',
//            'location' => '21 48 57N, 106 15 28E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '186',
//            'name_en' => 'Hữu Lũng',
//            'type_en' => 'Huyện',
//            'location' => '21 34 33N, 106 20 33E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '187',
//            'name_en' => 'Chi Lăng',
//            'type_en' => 'Huyện',
//            'location' => '21 40 05N, 106 37 24E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '188',
//            'name_en' => 'Lộc Bình',
//            'type_en' => 'Huyện',
//            'location' => '21 40 41N, 106 58 12E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '189',
//            'name_en' => 'Đình Lập',
//            'type_en' => 'Huyện',
//            'location' => '21 32 07N, 107 07 25E',
//            'province_id' => '20'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '193',
//            'name_en' => 'Hạ Long',
//            'type_en' => 'Thành Phố',
//            'location' => '20 52 24N, 107 05 23E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '194',
//            'name_en' => 'Móng Cái',
//            'type_en' => 'Thành Phố',
//            'location' => '21 26 31N, 107 55 09E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '195',
//            'name_en' => 'Cẩm Phả',
//            'type_en' => 'Thị Xã',
//            'location' => '21 03 42N, 107 17 22E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '196',
//            'name_en' => 'Uông Bí',
//            'type_en' => 'Thị Xã',
//            'location' => '21 04 33N, 106 45 07E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '198',
//            'name_en' => 'Bình Liêu',
//            'type_en' => 'Huyện',
//            'location' => '21 33 07N, 107 26 24E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '199',
//            'name_en' => 'Tiên Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 22 24N, 107 22 50E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '200',
//            'name_en' => 'Đầm Hà',
//            'type_en' => 'Huyện',
//            'location' => '21 21 23N, 107 34 32E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '201',
//            'name_en' => 'Hải Hà',
//            'type_en' => 'Huyện',
//            'location' => '21 25 50N, 107 41 26E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '202',
//            'name_en' => 'Ba Chẽ',
//            'type_en' => 'Huyện',
//            'location' => '21 15 40N, 107 09 52E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '203',
//            'name_en' => 'Vân Đồn',
//            'type_en' => 'Huyện',
//            'location' => '20 56 17N, 107 28 02E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '204',
//            'name_en' => 'Hoành Bồ',
//            'type_en' => 'Huyện',
//            'location' => '21 06 30N, 107 02 43E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '205',
//            'name_en' => 'Đông Triều',
//            'type_en' => 'Huyện',
//            'location' => '21 07 10N, 106 34 36E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '206',
//            'name_en' => 'Yên Hưng',
//            'type_en' => 'Huyện',
//            'location' => '20 55 40N, 106 51 05E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '207',
//            'name_en' => 'Cô Tô',
//            'type_en' => 'Huyện',
//            'location' => '21 05 01N, 107 49 10E',
//            'province_id' => '22'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '213',
//            'name_en' => 'Bắc Giang',
//            'type_en' => 'Thành Phố',
//            'location' => '21 17 36N, 106 11 18E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '215',
//            'name_en' => 'Yên Thế',
//            'type_en' => 'Huyện',
//            'location' => '21 31 29N, 106 09 27E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '216',
//            'name_en' => 'Tân Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 23 23N, 106 05 55E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '217',
//            'name_en' => 'Lạng Giang',
//            'type_en' => 'Huyện',
//            'location' => '21 21 58N, 106 15 21E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '218',
//            'name_en' => 'Lục Nam',
//            'type_en' => 'Huyện',
//            'location' => '21 18 16N, 106 29 24E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '219',
//            'name_en' => 'Lục Ngạn',
//            'type_en' => 'Huyện',
//            'location' => '21 26 15N, 106 39 09E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '220',
//            'name_en' => 'Sơn Động',
//            'type_en' => 'Huyện',
//            'location' => '21 19 42N, 106 51 09E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '221',
//            'name_en' => 'Yên Dũng',
//            'type_en' => 'Huyện',
//            'location' => '21 12 22N, 106 14 12E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '222',
//            'name_en' => 'Việt Yên',
//            'type_en' => 'Huyện',
//            'location' => '21 16 16N, 106 04 59E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '223',
//            'name_en' => 'Hiệp Hòa',
//            'type_en' => 'Huyện',
//            'location' => '21 15 51N, 105 57 30E',
//            'province_id' => '24'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '227',
//            'name_en' => 'Việt Trì',
//            'type_en' => 'Thành Phố',
//            'location' => '21 19 01N, 105 23 35E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '228',
//            'name_en' => 'Phú Thọ',
//            'type_en' => 'Thị Xã',
//            'location' => '21 24 54N, 105 13 46E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '230',
//            'name_en' => 'Đoan Hùng',
//            'type_en' => 'Huyện',
//            'location' => '21 36 56N, 105 08 42E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '231',
//            'name_en' => 'Hạ Hoà',
//            'type_en' => 'Huyện',
//            'location' => '21 35 13N, 105 00 22E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '232',
//            'name_en' => 'Thanh Ba',
//            'type_en' => 'Huyện',
//            'location' => '21 27 04N, 105 09 10E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '233',
//            'name_en' => 'Phù Ninh',
//            'type_en' => 'Huyện',
//            'location' => '21 26 59N, 105 18 13E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '234',
//            'name_en' => 'Yên Lập',
//            'type_en' => 'Huyện',
//            'location' => '21 22 21N, 105 01 25E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '235',
//            'name_en' => 'Cẩm Khê',
//            'type_en' => 'Huyện',
//            'location' => '21 23 04N, 105 05 25E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '236',
//            'name_en' => 'Tam Nông',
//            'type_en' => 'Huyện',
//            'location' => '21 18 24N, 105 14 59E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '237',
//            'name_en' => 'Lâm Thao',
//            'type_en' => 'Huyện',
//            'location' => '21 19 37N, 105 18 09E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '238',
//            'name_en' => 'Thanh Sơn',
//            'type_en' => 'Huyện',
//            'location' => '21 08 32N, 105 04 40E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '239',
//            'name_en' => 'Thanh Thuỷ',
//            'type_en' => 'Huyện',
//            'location' => '21 07 26N, 105 17 18E',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '240',
//            'name_en' => 'Tân Sơn',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '25'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '243',
//            'name_en' => 'Vĩnh Yên',
//            'type_en' => 'Thành Phố',
//            'location' => '21 18 26N, 105 35 33E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '244',
//            'name_en' => 'Phúc Yên',
//            'type_en' => 'Thị Xã',
//            'location' => '21 18 55N, 105 43 54E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '246',
//            'name_en' => 'Lập Thạch',
//            'type_en' => 'Huyện',
//            'location' => '21 24 45N, 105 25 39E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '247',
//            'name_en' => 'Tam Dương',
//            'type_en' => 'Huyện',
//            'location' => '21 21 40N, 105 33 36E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '248',
//            'name_en' => 'Tam Đảo',
//            'type_en' => 'Huyện',
//            'location' => '21 27 34N, 105 35 09E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '249',
//            'name_en' => 'Bình Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '21 19 48N, 105 39 43E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '250',
//            'name_en' => 'Mê Linh',
//            'type_en' => 'Huyện',
//            'location' => '21 10 53N, 105 42 05E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '251',
//            'name_en' => 'Yên Lạc',
//            'type_en' => 'Huyện',
//            'location' => '21 13 17N, 105 34 44E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '252',
//            'name_en' => 'Vĩnh Tường',
//            'type_en' => 'Huyện',
//            'location' => '21 14 58N, 105 29 37E',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '253',
//            'name_en' => 'Sông Lô',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '26'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '256',
//            'name_en' => 'Bắc Ninh',
//            'type_en' => 'Thành Phố',
//            'location' => '21 10 48N, 106 03 58E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '258',
//            'name_en' => 'Yên Phong',
//            'type_en' => 'Huyện',
//            'location' => '21 12 40N, 105 59 36E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '259',
//            'name_en' => 'Quế Võ',
//            'type_en' => 'Huyện',
//            'location' => '21 08 44N, 106 11 06E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '260',
//            'name_en' => 'Tiên Du',
//            'type_en' => 'Huyện',
//            'location' => '21 07 37N, 106 02 19E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '261',
//            'name_en' => 'Từ Sơn',
//            'type_en' => 'Thị Xã',
//            'location' => '21 07 12N, 105 57 26E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '262',
//            'name_en' => 'Thuận Thành',
//            'type_en' => 'Huyện',
//            'location' => '21 02 24N, 106 04 10E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '263',
//            'name_en' => 'Gia Bình',
//            'type_en' => 'Huyện',
//            'location' => '21 03 55N, 106 12 53E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '264',
//            'name_en' => 'Lương Tài',
//            'type_en' => 'Huyện',
//            'location' => '21 01 33N, 106 13 28E',
//            'province_id' => '27'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '268',
//            'name_en' => 'Hà Đông',
//            'type_en' => 'District',
//            'location' => '20 57 25N, 105 45 21E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '269',
//            'name_en' => 'Sơn Tây',
//            'type_en' => 'Thị Xã',
//            'location' => '21 05 51N, 105 28 27E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '271',
//            'name_en' => 'Ba Vì',
//            'type_en' => 'Huyện',
//            'location' => '21 09 40N, 105 22 43E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '272',
//            'name_en' => 'Phúc Thọ',
//            'type_en' => 'Huyện',
//            'location' => '21 06 32N, 105 34 52E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '273',
//            'name_en' => 'Đan Phượng',
//            'type_en' => 'Huyện',
//            'location' => '21 07 13N, 105 40 49E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '274',
//            'name_en' => 'Hoài Đức',
//            'type_en' => 'Huyện',
//            'location' => '21 01 25N, 105 42 03E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '275',
//            'name_en' => 'Quốc Oai',
//            'type_en' => 'Huyện',
//            'location' => '20 58 45N, 105 36 43E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '276',
//            'name_en' => 'Thạch Thất',
//            'type_en' => 'Huyện',
//            'location' => '21 02 17N, 105 33 05E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '277',
//            'name_en' => 'Chương Mỹ',
//            'type_en' => 'Huyện',
//            'location' => '20 52 46N, 105 39 01E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '278',
//            'name_en' => 'Thanh Oai',
//            'type_en' => 'Huyện',
//            'location' => '20 51 44N, 105 46 18E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '279',
//            'name_en' => 'Thường Tín',
//            'type_en' => 'Huyện',
//            'location' => '20 49 59N, 105 22 19E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '280',
//            'name_en' => 'Phú Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '20 43 37N, 105 53 43E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '281',
//            'name_en' => 'Ứng Hòa',
//            'type_en' => 'Huyện',
//            'location' => '20 42 41N, 105 47 58E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '282',
//            'name_en' => 'Mỹ Đức',
//            'type_en' => 'Huyện',
//            'location' => '20 41 53N, 105 43 31E',
//            'province_id' => '01'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '288',
//            'name_en' => 'Hải Dương',
//            'type_en' => 'Thành Phố',
//            'location' => '20 56 14N, 106 18 21E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '290',
//            'name_en' => 'Chí Linh',
//            'type_en' => 'Huyện',
//            'location' => '21 07 47N, 106 23 46E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '291',
//            'name_en' => 'Nam Sách',
//            'type_en' => 'Huyện',
//            'location' => '21 00 15N, 106 20 26E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '292',
//            'name_en' => 'Kinh Môn',
//            'type_en' => 'Huyện',
//            'location' => '21 00 04N, 106 30 23E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '293',
//            'name_en' => 'Kim Thành',
//            'type_en' => 'Huyện',
//            'location' => '20 55 40N, 106 30 33E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '294',
//            'name_en' => 'Thanh Hà',
//            'type_en' => 'Huyện',
//            'location' => '20 53 19N, 106 25 43E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '295',
//            'name_en' => 'Cẩm Giàng',
//            'type_en' => 'Huyện',
//            'location' => '20 57 05N, 106 12 29E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '296',
//            'name_en' => 'Bình Giang',
//            'type_en' => 'Huyện',
//            'location' => '20 52 36N, 106 11 24E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '297',
//            'name_en' => 'Gia Lộc',
//            'type_en' => 'Huyện',
//            'location' => '20 51 01N, 106 17 34E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '298',
//            'name_en' => 'Tứ Kỳ',
//            'type_en' => 'Huyện',
//            'location' => '20 49 05N, 106 24 05E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '299',
//            'name_en' => 'Ninh Giang',
//            'type_en' => 'Huyện',
//            'location' => '20 45 13N, 106 20 09E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '300',
//            'name_en' => 'Thanh Miện',
//            'type_en' => 'Huyện',
//            'location' => '20 46 02N, 106 12 26E',
//            'province_id' => '30'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '303',
//            'name_en' => 'Hồng Bàng',
//            'type_en' => 'District',
//            'location' => '20 52 37N, 106 38 32E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '304',
//            'name_en' => 'Ngô Quyền',
//            'type_en' => 'District',
//            'location' => '20 51 13N, 106 41 57E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '305',
//            'name_en' => 'Lê Chân',
//            'type_en' => 'District',
//            'location' => '20 50 12N, 106 40 30E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '306',
//            'name_en' => 'Hải An',
//            'type_en' => 'District',
//            'location' => '20 49 38N, 106 45 57E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '307',
//            'name_en' => 'Kiến An',
//            'type_en' => 'District',
//            'location' => '20 48 26N, 106 38 03E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '308',
//            'name_en' => 'Đồ Sơn',
//            'type_en' => 'District',
//            'location' => '20 42 41N, 106 44 54E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '309',
//            'name_en' => 'Kinh Dương',
//            'type_en' => 'District',
//            'location' => '',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '311',
//            'name_en' => 'Thuỷ Nguyên',
//            'type_en' => 'Huyện',
//            'location' => '20 56 36N, 106 39 38E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '312',
//            'name_en' => 'An Dương',
//            'type_en' => 'Huyện',
//            'location' => '20 53 06N, 106 35 36E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '313',
//            'name_en' => 'An Lão',
//            'type_en' => 'Huyện',
//            'location' => '20 47 54N, 106 33 19E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '314',
//            'name_en' => 'Kiến Thụy',
//            'type_en' => 'Huyện',
//            'location' => '20 45 13N, 106 41 47E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '315',
//            'name_en' => 'Tiên Lãng',
//            'type_en' => 'Huyện',
//            'location' => '20 42 23N, 106 36 03E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '316',
//            'name_en' => 'Vĩnh Bảo',
//            'type_en' => 'Huyện',
//            'location' => '20 40 56N, 106 29 57E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '317',
//            'name_en' => 'Cát Hải',
//            'type_en' => 'Huyện',
//            'location' => '20 47 09N, 106 58 07E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '318',
//            'name_en' => 'Bạch Long Vĩ',
//            'type_en' => 'Huyện',
//            'location' => '20 08 41N, 107 42 51E',
//            'province_id' => '31'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '323',
//            'name_en' => 'Hưng Yên',
//            'type_en' => 'Thành Phố',
//            'location' => '20 39 38N, 106 03 08E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '325',
//            'name_en' => 'Văn Lâm',
//            'type_en' => 'Huyện',
//            'location' => '20 58 31N, 106 02 51E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '326',
//            'name_en' => 'Văn Giang',
//            'type_en' => 'Huyện',
//            'location' => '20 55 51N, 105 57 14E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '327',
//            'name_en' => 'Yên Mỹ',
//            'type_en' => 'Huyện',
//            'location' => '20 53 45N, 106 01 21E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '328',
//            'name_en' => 'Mỹ Hào',
//            'type_en' => 'Huyện',
//            'location' => '20 55 35N, 106 05 34E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '329',
//            'name_en' => 'Ân Thi',
//            'type_en' => 'Huyện',
//            'location' => '20 48 49N, 106 05 30E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '330',
//            'name_en' => 'Khoái Châu',
//            'type_en' => 'Huyện',
//            'location' => '20 49 53N, 105 58 28E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '331',
//            'name_en' => 'Kim Động',
//            'type_en' => 'Huyện',
//            'location' => '20 44 47N, 106 01 47E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '332',
//            'name_en' => 'Tiên Lữ',
//            'type_en' => 'Huyện',
//            'location' => '20 40 05N, 106 07 59E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '333',
//            'name_en' => 'Phù Cừ',
//            'type_en' => 'Huyện',
//            'location' => '20 42 51N, 106 11 30E',
//            'province_id' => '33'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '336',
//            'name_en' => 'Thái Bình',
//            'type_en' => 'Thành Phố',
//            'location' => '20 26 45N, 106 19 56E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '338',
//            'name_en' => 'Quỳnh Phụ',
//            'type_en' => 'Huyện',
//            'location' => '20 38 57N, 106 21 16E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '339',
//            'name_en' => 'Hưng Hà',
//            'type_en' => 'Huyện',
//            'location' => '20 35 38N, 106 12 42E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '340',
//            'name_en' => 'Đông Hưng',
//            'type_en' => 'Huyện',
//            'location' => '20 32 50N, 106 20 15E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '341',
//            'name_en' => 'Thái Thụy',
//            'type_en' => 'Huyện',
//            'location' => '20 32 33N, 106 32 32E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '342',
//            'name_en' => 'Tiền Hải',
//            'type_en' => 'Huyện',
//            'location' => '20 21 05N, 106 32 45E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '343',
//            'name_en' => 'Kiến Xương',
//            'type_en' => 'Huyện',
//            'location' => '20 23 52N, 106 25 22E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '344',
//            'name_en' => 'Vũ Thư',
//            'type_en' => 'Huyện',
//            'location' => '20 25 29N, 106 16 43E',
//            'province_id' => '34'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '347',
//            'name_en' => 'Phủ Lý',
//            'type_en' => 'Thành Phố',
//            'location' => '20 32 19N, 105 54 55E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '349',
//            'name_en' => 'Duy Tiên',
//            'type_en' => 'Huyện',
//            'location' => '20 37 33N, 105 58 01E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '350',
//            'name_en' => 'Kim Bảng',
//            'type_en' => 'Huyện',
//            'location' => '20 34 19N, 105 50 41E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '351',
//            'name_en' => 'Thanh Liêm',
//            'type_en' => 'Huyện',
//            'location' => '20 27 31N, 105 55 09E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '352',
//            'name_en' => 'Bình Lục',
//            'type_en' => 'Huyện',
//            'location' => '20 29 23N, 106 02 52E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '353',
//            'name_en' => 'Lý Nhân',
//            'type_en' => 'Huyện',
//            'location' => '20 32 55N, 106 04 48E',
//            'province_id' => '35'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '356',
//            'name_en' => 'Nam Định',
//            'type_en' => 'Thành Phố',
//            'location' => '20 25 07N, 106 09 54E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '358',
//            'name_en' => 'Mỹ Lộc',
//            'type_en' => 'Huyện',
//            'location' => '20 27 21N, 106 07 56E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '359',
//            'name_en' => 'Vụ Bản',
//            'type_en' => 'Huyện',
//            'location' => '20 22 57N, 106 05 35E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '360',
//            'name_en' => 'Ý Yên',
//            'type_en' => 'Huyện',
//            'location' => '20 19 48N, 106 01 55E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '361',
//            'name_en' => 'Nghĩa Hưng',
//            'type_en' => 'Huyện',
//            'location' => '20 05 37N, 106 08 59E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '362',
//            'name_en' => 'Nam Trực',
//            'type_en' => 'Huyện',
//            'location' => '20 20 08N, 106 12 54E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '363',
//            'name_en' => 'Trực Ninh',
//            'type_en' => 'Huyện',
//            'location' => '20 14 42N, 106 12 45E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '364',
//            'name_en' => 'Xuân Trường',
//            'type_en' => 'Huyện',
//            'location' => '20 17 53N, 106 21 43E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '365',
//            'name_en' => 'Giao Thủy',
//            'type_en' => 'Huyện',
//            'location' => '20 14 45N, 106 28 39E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '366',
//            'name_en' => 'Hải Hậu',
//            'type_en' => 'Huyện',
//            'location' => '20 06 26N, 106 16 29E',
//            'province_id' => '36'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '369',
//            'name_en' => 'Ninh Bình',
//            'type_en' => 'Thành Phố',
//            'location' => '20 14 45N, 105 58 24E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '370',
//            'name_en' => 'Tam Điệp',
//            'type_en' => 'Thị Xã',
//            'location' => '20 09 42N, 103 52 43E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '372',
//            'name_en' => 'Nho Quan',
//            'type_en' => 'Huyện',
//            'location' => '20 18 46N, 105 42 48E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '373',
//            'name_en' => 'Gia Viễn',
//            'type_en' => 'Huyện',
//            'location' => '20 19 50N, 105 52 20E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '374',
//            'name_en' => 'Hoa Lư',
//            'type_en' => 'Huyện',
//            'location' => '20 15 04N, 105 55 52E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '375',
//            'name_en' => 'Yên Khánh',
//            'type_en' => 'Huyện',
//            'location' => '20 11 26N, 106 04 33E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '376',
//            'name_en' => 'Kim Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 02 07N, 106 05 27E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '377',
//            'name_en' => 'Yên Mô',
//            'type_en' => 'Huyện',
//            'location' => '20 07 45N, 105 59 45E',
//            'province_id' => '37'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '380',
//            'name_en' => 'Thanh Hóa',
//            'type_en' => 'Thành Phố',
//            'location' => '19 48 26N, 105 47 37E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '381',
//            'name_en' => 'Bỉm Sơn',
//            'type_en' => 'Thị Xã',
//            'location' => '20 05 21N, 105 51 48E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '382',
//            'name_en' => 'Sầm Sơn',
//            'type_en' => 'Thị Xã',
//            'location' => '19 45 11N, 105 54 03E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '384',
//            'name_en' => 'Mường Lát',
//            'type_en' => 'Huyện',
//            'location' => '20 30 42N, 104 37 27E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '385',
//            'name_en' => 'Quan Hóa',
//            'type_en' => 'Huyện',
//            'location' => '20 29 15N, 104 56 35E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '386',
//            'name_en' => 'Bá Thước',
//            'type_en' => 'Huyện',
//            'location' => '20 22 48N, 105 14 50E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '387',
//            'name_en' => 'Quan Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 15 17N, 104 51 58E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '388',
//            'name_en' => 'Lang Chánh',
//            'type_en' => 'Huyện',
//            'location' => '20 08 58N, 105 07 40E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '389',
//            'name_en' => 'Ngọc Lặc',
//            'type_en' => 'Huyện',
//            'location' => '20 04 08N, 105 22 39E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '390',
//            'name_en' => 'Cẩm Thủy',
//            'type_en' => 'Huyện',
//            'location' => '20 12 20N, 105 27 22E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '391',
//            'name_en' => 'Thạch Thành',
//            'type_en' => 'Huyện',
//            'location' => '21 12 41N, 105 36 38E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '392',
//            'name_en' => 'Hà Trung',
//            'type_en' => 'Huyện',
//            'location' => '20 03 20N, 105 51 20E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '393',
//            'name_en' => 'Vĩnh Lộc',
//            'type_en' => 'Huyện',
//            'location' => '20 02 29N, 105 39 28E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '394',
//            'name_en' => 'Yên Định',
//            'type_en' => 'Huyện',
//            'location' => '20 00 31N, 105 37 44E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '395',
//            'name_en' => 'Thọ Xuân',
//            'type_en' => 'Huyện',
//            'location' => '19 55 39N, 105 29 14E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '396',
//            'name_en' => 'Thường Xuân',
//            'type_en' => 'Huyện',
//            'location' => '19 54 55N, 105 10 46E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '397',
//            'name_en' => 'Triệu Sơn',
//            'type_en' => 'Huyện',
//            'location' => '19 48 11N, 105 34 03E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '398',
//            'name_en' => 'Thiệu Hoá',
//            'type_en' => 'Huyện',
//            'location' => '19 53 56N, 105 40 57E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '399',
//            'name_en' => 'Hoằng Hóa',
//            'type_en' => 'Huyện',
//            'location' => '19 51 59N, 105 51 34E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '400',
//            'name_en' => 'Hậu Lộc',
//            'type_en' => 'Huyện',
//            'location' => '19 56 02N, 105 53 19E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '401',
//            'name_en' => 'Nga Sơn',
//            'type_en' => 'Huyện',
//            'location' => '20 00 16N, 105 59 26E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '402',
//            'name_en' => 'Như Xuân',
//            'type_en' => 'Huyện',
//            'location' => '19 5 55N, 105 20 22E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '403',
//            'name_en' => 'Như Thanh',
//            'type_en' => 'Huyện',
//            'location' => '19 35 19N, 105 33 09E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '404',
//            'name_en' => 'Nông Cống',
//            'type_en' => 'Huyện',
//            'location' => '19 36 58N, 105 40 54E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '405',
//            'name_en' => 'Đông Sơn',
//            'type_en' => 'Huyện',
//            'location' => '19 47 44N, 105 42 19E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '406',
//            'name_en' => 'Quảng Xương',
//            'type_en' => 'Huyện',
//            'location' => '19 40 53N, 105 48 01E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '407',
//            'name_en' => 'Tĩnh Gia',
//            'type_en' => 'Huyện',
//            'location' => '19 27 13N, 105 43 38E',
//            'province_id' => '38'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '412',
//            'name_en' => 'Vinh',
//            'type_en' => 'Thành Phố',
//            'location' => '18 41 06N, 105 42 05E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '413',
//            'name_en' => 'Cửa Lò',
//            'type_en' => 'Thị Xã',
//            'location' => '18 47 26N, 105 43 31E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '414',
//            'name_en' => 'Thái Hoà',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '415',
//            'name_en' => 'Quế Phong',
//            'type_en' => 'Huyện',
//            'location' => '19 42 25N, 104 54 21E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '416',
//            'name_en' => 'Quỳ Châu',
//            'type_en' => 'Huyện',
//            'location' => '19 32 16N, 105 03 18E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '417',
//            'name_en' => 'Kỳ Sơn',
//            'type_en' => 'Huyện',
//            'location' => '19 24 36N, 104 09 45E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '418',
//            'name_en' => 'Tương Dương',
//            'type_en' => 'Huyện',
//            'location' => '19 19 15N, 104 35 41E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '419',
//            'name_en' => 'Nghĩa Đàn',
//            'type_en' => 'Huyện',
//            'location' => '19 21 19N, 105 26 33E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '420',
//            'name_en' => 'Quỳ Hợp',
//            'type_en' => 'Huyện',
//            'location' => '19 19 24N, 105 09 12E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '421',
//            'name_en' => 'Quỳnh Lưu',
//            'type_en' => 'Huyện',
//            'location' => '19 14 01N, 105 37 00E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '422',
//            'name_en' => 'Con Cuông',
//            'type_en' => 'Huyện',
//            'location' => '19 03 50N, 107 47 15E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '423',
//            'name_en' => 'Tân Kỳ',
//            'type_en' => 'Huyện',
//            'location' => '19 06 11N, 105 14 14E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '424',
//            'name_en' => 'Anh Sơn',
//            'type_en' => 'Huyện',
//            'location' => '18 58 04N, 105 04 30E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '425',
//            'name_en' => 'Diễn Châu',
//            'type_en' => 'Huyện',
//            'location' => '19 01 20N, 105 34 13E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '426',
//            'name_en' => 'Yên Thành',
//            'type_en' => 'Huyện',
//            'location' => '19 01 25N, 105 26 17E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '427',
//            'name_en' => 'Đô Lương',
//            'type_en' => 'Huyện',
//            'location' => '18 55 00N, 105 21 03E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '428',
//            'name_en' => 'Thanh Chương',
//            'type_en' => 'Huyện',
//            'location' => '18 44 11N, 105 12 59E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '429',
//            'name_en' => 'Nghi Lộc',
//            'type_en' => 'Huyện',
//            'location' => '18 47 41N, 105 31 30E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '430',
//            'name_en' => 'Nam Đàn',
//            'type_en' => 'Huyện',
//            'location' => '18 40 28N, 105 30 32E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '431',
//            'name_en' => 'Hưng Nguyên',
//            'type_en' => 'Huyện',
//            'location' => '18 41 13N, 105 37 41E',
//            'province_id' => '40'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '436',
//            'name_en' => 'Hà Tĩnh',
//            'type_en' => 'Thành Phố',
//            'location' => '18 21 20N, 105 54 00E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '437',
//            'name_en' => 'Hồng Lĩnh',
//            'type_en' => 'Thị Xã',
//            'location' => '18 32 05N, 105 42 40E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '439',
//            'name_en' => 'Hương Sơn',
//            'type_en' => 'Huyện',
//            'location' => '18 26 47N, 105 19 36E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '440',
//            'name_en' => 'Đức Thọ',
//            'type_en' => 'Huyện',
//            'location' => '18 29 23N, 105 36 39E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '441',
//            'name_en' => 'Vũ Quang',
//            'type_en' => 'Huyện',
//            'location' => '18 19 30N, 105 26 38E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '442',
//            'name_en' => 'Nghi Xuân',
//            'type_en' => 'Huyện',
//            'location' => '18 38 46N, 105 46 17E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '443',
//            'name_en' => 'Can Lộc',
//            'type_en' => 'Huyện',
//            'location' => '18 26 39N, 105 46 13E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '444',
//            'name_en' => 'Hương Khê',
//            'type_en' => 'Huyện',
//            'location' => '18 11 36N, 105 41 24E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '445',
//            'name_en' => 'Thạch Hà',
//            'type_en' => 'Huyện',
//            'location' => '18 19 29N, 105 52 43E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '446',
//            'name_en' => 'Cẩm Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '18 11 32N, 106 00 04E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '447',
//            'name_en' => 'Kỳ Anh',
//            'type_en' => 'Huyện',
//            'location' => '18 05 15N, 106 15 49E',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '448',
//            'name_en' => 'Lộc Hà',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '42'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '450',
//            'name_en' => 'Đồng Hới',
//            'type_en' => 'Thành Phố',
//            'location' => '17 26 53N, 106 35 15E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '452',
//            'name_en' => 'Minh Hóa',
//            'type_en' => 'Huyện',
//            'location' => '17 44 03N, 105 51 45E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '453',
//            'name_en' => 'Tuyên Hóa',
//            'type_en' => 'Huyện',
//            'location' => '17 54 04N, 105 58 17E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '454',
//            'name_en' => 'Quảng Trạch',
//            'type_en' => 'Huyện',
//            'location' => '17 50 04N, 106 22 24E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '455',
//            'name_en' => 'Bố Trạch',
//            'type_en' => 'Huyện',
//            'location' => '17 29 13N, 106 06 54E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '456',
//            'name_en' => 'Quảng Ninh',
//            'type_en' => 'Huyện',
//            'location' => '17 15 15N, 106 32 31E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '457',
//            'name_en' => 'Lệ Thủy',
//            'type_en' => 'Huyện',
//            'location' => '17 07 35N, 106 41 47E',
//            'province_id' => '44'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '461',
//            'name_en' => 'Đông Hà',
//            'type_en' => 'Thành Phố',
//            'location' => '16 48 12N, 107 05 12E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '462',
//            'name_en' => 'Quảng Trị',
//            'type_en' => 'Thị Xã',
//            'location' => '16 44 37N, 107 11 20E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '464',
//            'name_en' => 'Vĩnh Linh',
//            'type_en' => 'Huyện',
//            'location' => '17 01 35N, 106 53 49E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '465',
//            'name_en' => 'Hướng Hóa',
//            'type_en' => 'Huyện',
//            'location' => '16 42 19N, 106 40 14E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '466',
//            'name_en' => 'Gio Linh',
//            'type_en' => 'Huyện',
//            'location' => '16 54 49N, 106 56 16E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '467',
//            'name_en' => 'Đa Krông',
//            'type_en' => 'Huyện',
//            'location' => '16 33 58N, 106 55 49E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '468',
//            'name_en' => 'Cam Lộ',
//            'type_en' => 'Huyện',
//            'location' => '16 47 09N, 106 57 52E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '469',
//            'name_en' => 'Triệu Phong',
//            'type_en' => 'Huyện',
//            'location' => '16 46 32N, 107 09 12E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '470',
//            'name_en' => 'Hải Lăng',
//            'type_en' => 'Huyện',
//            'location' => '16 41 07N, 107 13 34E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '471',
//            'name_en' => 'Cồn Cỏ',
//            'type_en' => 'Huyện',
//            'location' => '19 09 39N, 107 19 58E',
//            'province_id' => '45'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '474',
//            'name_en' => 'Huế',
//            'type_en' => 'Thành Phố',
//            'location' => '16 27 16N, 107 34 29E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '476',
//            'name_en' => 'Phong Điền',
//            'type_en' => 'Huyện',
//            'location' => '16 32 42N, 106 16 37E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '477',
//            'name_en' => 'Quảng Điền',
//            'type_en' => 'Huyện',
//            'location' => '16 35 21N, 107 29 31E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '478',
//            'name_en' => 'Phú Vang',
//            'type_en' => 'Huyện',
//            'location' => '16 27 20N, 107 42 28E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '479',
//            'name_en' => 'Hương Thủy',
//            'type_en' => 'Huyện',
//            'location' => '16 19 27N, 107 37 26E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '480',
//            'name_en' => 'Hương Trà',
//            'type_en' => 'Huyện',
//            'location' => '16 25 49N, 107 28 37E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '481',
//            'name_en' => 'A Lưới',
//            'type_en' => 'Huyện',
//            'location' => '16 13 59N, 107 16 12E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '482',
//            'name_en' => 'Phú Lộc',
//            'type_en' => 'Huyện',
//            'location' => '16 17 16N, 107 55 25E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '483',
//            'name_en' => 'Nam Đông',
//            'type_en' => 'Huyện',
//            'location' => '16 07 11N, 107 41 25E',
//            'province_id' => '46'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '490',
//            'name_en' => 'Liên Chiểu',
//            'type_en' => 'District',
//            'location' => '16 07 26N, 108 07 04E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '491',
//            'name_en' => 'Thanh Khê',
//            'type_en' => 'District',
//            'location' => '16 03 28N, 108 11 00E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '492',
//            'name_en' => 'Hải Châu',
//            'type_en' => 'District',
//            'location' => '16 03 38N, 108 11 46E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '493',
//            'name_en' => 'Sơn Trà',
//            'type_en' => 'District',
//            'location' => '16 06 13N, 108 16 26E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '494',
//            'name_en' => 'Ngũ Hành Sơn',
//            'type_en' => 'District',
//            'location' => '16 00 30N, 108 15 09E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '495',
//            'name_en' => 'Cẩm Lệ',
//            'type_en' => 'District',
//            'location' => '',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '497',
//            'name_en' => 'Hoà Vang',
//            'type_en' => 'Huyện',
//            'location' => '16 03 59N, 108 01 57E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '498',
//            'name_en' => 'Hoàng Sa',
//            'type_en' => 'Huyện',
//            'location' => '16 21 36N, 111 57 01E',
//            'province_id' => '48'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '502',
//            'name_en' => 'Tam Kỳ',
//            'type_en' => 'Thành Phố',
//            'location' => '15 34 37N, 108 29 52E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '503',
//            'name_en' => 'Hội An',
//            'type_en' => 'Thành Phố',
//            'location' => '15 53 20N, 108 20 42E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '504',
//            'name_en' => 'Tây Giang',
//            'type_en' => 'Huyện',
//            'location' => '15 53 46N, 107 25 52E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '505',
//            'name_en' => 'Đông Giang',
//            'type_en' => 'Huyện',
//            'location' => '15 54 44N, 107 47 06E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '506',
//            'name_en' => 'Đại Lộc',
//            'type_en' => 'Huyện',
//            'location' => '15 50 10N, 107 58 27E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '507',
//            'name_en' => 'Điện Bàn',
//            'type_en' => 'Huyện',
//            'location' => '15 54 15N, 108 13 38E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '508',
//            'name_en' => 'Duy Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '15 47 58N, 108 13 27E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '509',
//            'name_en' => 'Quế Sơn',
//            'type_en' => 'Huyện',
//            'location' => '15 41 03N, 108 05 34E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '510',
//            'name_en' => 'Nam Giang',
//            'type_en' => 'Huyện',
//            'location' => '15 36 37N, 107 33 52E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '511',
//            'name_en' => 'Phước Sơn',
//            'type_en' => 'Huyện',
//            'location' => '15 23 17N, 107 50 22E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '512',
//            'name_en' => 'Hiệp Đức',
//            'type_en' => 'Huyện',
//            'location' => '15 31 09N, 108 05 56E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '513',
//            'name_en' => 'Thăng Bình',
//            'type_en' => 'Huyện',
//            'location' => '15 42 29N, 108 22 04E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '514',
//            'name_en' => 'Tiên Phước',
//            'type_en' => 'Huyện',
//            'location' => '15 29 30N, 108 15 28E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '515',
//            'name_en' => 'Bắc Trà My',
//            'type_en' => 'Huyện',
//            'location' => '15 08 00N, 108 05 32E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '516',
//            'name_en' => 'Nam Trà My',
//            'type_en' => 'Huyện',
//            'location' => '15 16 40N, 108 12 15E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '517',
//            'name_en' => 'Núi Thành',
//            'type_en' => 'Huyện',
//            'location' => '15 26 53N, 108 34 49E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '518',
//            'name_en' => 'Phú Ninh',
//            'type_en' => 'Huyện',
//            'location' => '15 30 43N, 108 24 43E',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '519',
//            'name_en' => 'Nông Sơn',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '49'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '522',
//            'name_en' => 'Quảng Ngãi',
//            'type_en' => 'Thành Phố',
//            'location' => '15 07 17N, 108 48 24E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '524',
//            'name_en' => 'Bình Sơn',
//            'type_en' => 'Huyện',
//            'location' => '15 18 45N, 108 45 35E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '525',
//            'name_en' => 'Trà Bồng',
//            'type_en' => 'Huyện',
//            'location' => '15 13 30N, 108 29 57E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '526',
//            'name_en' => 'Tây Trà',
//            'type_en' => 'Huyện',
//            'location' => '15 11 13N, 108 22 23E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '527',
//            'name_en' => 'Sơn Tịnh',
//            'type_en' => 'Huyện',
//            'location' => '15 11 49N, 108 45 03E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '528',
//            'name_en' => 'Tư Nghĩa',
//            'type_en' => 'Huyện',
//            'location' => '15 05 25N, 108 45 23E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '529',
//            'name_en' => 'Sơn Hà',
//            'type_en' => 'Huyện',
//            'location' => '14 58 35N, 108 29 09E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '530',
//            'name_en' => 'Sơn Tây',
//            'type_en' => 'Huyện',
//            'location' => '14 58 11N, 108 21 22E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '531',
//            'name_en' => 'Minh Long',
//            'type_en' => 'Huyện',
//            'location' => '14 56 49N, 108 40 19E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '532',
//            'name_en' => 'Nghĩa Hành',
//            'type_en' => 'Huyện',
//            'location' => '14 58 06N, 108 46 05E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '533',
//            'name_en' => 'Mộ Đức',
//            'type_en' => 'Huyện',
//            'location' => '11 59 13N, 108 52 21E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '534',
//            'name_en' => 'Đức Phổ',
//            'type_en' => 'Huyện',
//            'location' => '14 44 59N, 108 56 58E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '535',
//            'name_en' => 'Ba Tơ',
//            'type_en' => 'Huyện',
//            'location' => '14 42 52N, 108 43 44E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '536',
//            'name_en' => 'Lý Sơn',
//            'type_en' => 'Huyện',
//            'location' => '15 22 50N, 109 06 56E',
//            'province_id' => '51'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '540',
//            'name_en' => 'Qui Nhơn',
//            'type_en' => 'Thành Phố',
//            'location' => '13 47 15N, 109 12 48E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '542',
//            'name_en' => 'An Lão',
//            'type_en' => 'Huyện',
//            'location' => '14 32 10N, 108 47 52E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '543',
//            'name_en' => 'Hoài Nhơn',
//            'type_en' => 'Huyện',
//            'location' => '14 30 56N, 109 01 56E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '544',
//            'name_en' => 'Hoài Ân',
//            'type_en' => 'Huyện',
//            'location' => '14 20 51N, 108 54 04E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '545',
//            'name_en' => 'Phù Mỹ',
//            'type_en' => 'Huyện',
//            'location' => '14 14 41N, 109 05 43E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '546',
//            'name_en' => 'Vĩnh Thạnh',
//            'type_en' => 'Huyện',
//            'location' => '14 14 26N, 108 44 08E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '547',
//            'name_en' => 'Tây Sơn',
//            'type_en' => 'Huyện',
//            'location' => '13 56 47N, 108 53 06E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '548',
//            'name_en' => 'Phù Cát',
//            'type_en' => 'Huyện',
//            'location' => '14 03 48N, 109 03 57E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '549',
//            'name_en' => 'An Nhơn',
//            'type_en' => 'Huyện',
//            'location' => '13 51 28N, 109 04 02E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '550',
//            'name_en' => 'Tuy Phước',
//            'type_en' => 'Huyện',
//            'location' => '13 46 30N, 109 05 38E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '551',
//            'name_en' => 'Vân Canh',
//            'type_en' => 'Huyện',
//            'location' => '13 40 35N, 108 57 52E',
//            'province_id' => '52'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '555',
//            'name_en' => 'Tuy Hòa',
//            'type_en' => 'Thành Phố',
//            'location' => '13 05 42N, 109 15 50E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '557',
//            'name_en' => 'Sông Cầu',
//            'type_en' => 'Thị Xã',
//            'location' => '13 31 40N, 109 12 39E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '558',
//            'name_en' => 'Đồng Xuân',
//            'type_en' => 'Huyện',
//            'location' => '13 24 59N, 108 56 46E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '559',
//            'name_en' => 'Tuy An',
//            'type_en' => 'Huyện',
//            'location' => '13 15 19N, 109 12 21E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '560',
//            'name_en' => 'Sơn Hòa',
//            'type_en' => 'Huyện',
//            'location' => '13 12 16N, 108 57 17E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '561',
//            'name_en' => 'Sông Hinh',
//            'type_en' => 'Huyện',
//            'location' => '12 54 19N, 108 53 38E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '562',
//            'name_en' => 'Tây Hoà',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '563',
//            'name_en' => 'Phú Hoà',
//            'type_en' => 'Huyện',
//            'location' => '13 04 07N, 109 11 24E',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '564',
//            'name_en' => 'Đông Hoà',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '54'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '568',
//            'name_en' => 'Nha Trang',
//            'type_en' => 'Thành Phố',
//            'location' => '12 15 40N, 109 10 40E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '569',
//            'name_en' => 'Cam Ranh',
//            'type_en' => 'Thị Xã',
//            'location' => '11 59 05N, 108 08 17E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '570',
//            'name_en' => 'Cam Lâm',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '571',
//            'name_en' => 'Vạn Ninh',
//            'type_en' => 'Huyện',
//            'location' => '12 43 10N, 109 11 18E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '572',
//            'name_en' => 'Ninh Hòa',
//            'type_en' => 'Huyện',
//            'location' => '12 32 54N, 109 06 11E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '573',
//            'name_en' => 'Khánh Vĩnh',
//            'type_en' => 'Huyện',
//            'location' => '12 17 50N, 108 51 56E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '574',
//            'name_en' => 'Diên Khánh',
//            'type_en' => 'Huyện',
//            'location' => '12 13 19N, 109 02 16E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '575',
//            'name_en' => 'Khánh Sơn',
//            'type_en' => 'Huyện',
//            'location' => '12 02 17N, 108 53 47E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '576',
//            'name_en' => 'Trường Sa',
//            'type_en' => 'Huyện',
//            'location' => '9 07 27N, 114 15 00E',
//            'province_id' => '56'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '582',
//            'name_en' => 'Phan Rang-Tháp Chàm',
//            'type_en' => 'Thành Phố',
//            'location' => '11 36 11N, 108 58 34E',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '584',
//            'name_en' => 'Bác Ái',
//            'type_en' => 'Huyện',
//            'location' => '11 54 45N, 108 51 29E',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '585',
//            'name_en' => 'Ninh Sơn',
//            'type_en' => 'Huyện',
//            'location' => '11 42 36N, 108 44 55E',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '586',
//            'name_en' => 'Ninh Hải',
//            'type_en' => 'Huyện',
//            'location' => '11 42 46N, 109 05 41E',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '587',
//            'name_en' => 'Ninh Phước',
//            'type_en' => 'Huyện',
//            'location' => '11 28 56N, 108 50 34E',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '588',
//            'name_en' => 'Thuận Bắc',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '589',
//            'name_en' => 'Thuận Nam',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '58'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '593',
//            'name_en' => 'Phan Thiết',
//            'type_en' => 'Thành Phố',
//            'location' => '10 54 16N, 108 03 44E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '594',
//            'name_en' => 'La Gi',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '595',
//            'name_en' => 'Tuy Phong',
//            'type_en' => 'Huyện',
//            'location' => '11 20 26N, 108 41 15E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '596',
//            'name_en' => 'Bắc Bình',
//            'type_en' => 'Huyện',
//            'location' => '11 15 52N, 108 21 33E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '597',
//            'name_en' => 'Hàm Thuận Bắc',
//            'type_en' => 'Huyện',
//            'location' => '11 09 18N, 108 03 07E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '598',
//            'name_en' => 'Hàm Thuận Nam',
//            'type_en' => 'Huyện',
//            'location' => '10 56 20N, 107 54 38E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '599',
//            'name_en' => 'Tánh Linh',
//            'type_en' => 'Huyện',
//            'location' => '11 08 26N, 107 41 22E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '600',
//            'name_en' => 'Đức Linh',
//            'type_en' => 'Huyện',
//            'location' => '11 11 43N, 107 31 34E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '601',
//            'name_en' => 'Hàm Tân',
//            'type_en' => 'Huyện',
//            'location' => '10 44 41N, 107 41 33E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '602',
//            'name_en' => 'Phú Quí',
//            'type_en' => 'Huyện',
//            'location' => '10 33 13N, 108 57 46E',
//            'province_id' => '60'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '608',
//            'name_en' => 'Kon Tum',
//            'type_en' => 'Thành Phố',
//            'location' => '14 20 32N, 107 58 04E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '610',
//            'name_en' => 'Đắk Glei',
//            'type_en' => 'Huyện',
//            'location' => '15 08 13N, 107 44 03E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '611',
//            'name_en' => 'Ngọc Hồi',
//            'type_en' => 'Huyện',
//            'location' => '14 44 23N, 107 38 49E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '612',
//            'name_en' => 'Đắk Tô',
//            'type_en' => 'Huyện',
//            'location' => '14 46 49N, 107 55 36E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '613',
//            'name_en' => 'Kon Plông',
//            'type_en' => 'Huyện',
//            'location' => '14 48 13N, 108 20 05E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '614',
//            'name_en' => 'Kon Rẫy',
//            'type_en' => 'Huyện',
//            'location' => '14 32 56N, 108 13 09E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '615',
//            'name_en' => 'Đắk Hà',
//            'type_en' => 'Huyện',
//            'location' => '14 36 50N, 107 59 55E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '616',
//            'name_en' => 'Sa Thầy',
//            'type_en' => 'Huyện',
//            'location' => '14 16 02N, 107 36 30E',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '617',
//            'name_en' => 'Tu Mơ Rông',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '62'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '622',
//            'name_en' => 'Pleiku',
//            'type_en' => 'Thành Phố',
//            'location' => '13 57 42N, 107 58 03E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '623',
//            'name_en' => 'An Khê',
//            'type_en' => 'Thị Xã',
//            'location' => '14 01 24N, 108 41 29E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '624',
//            'name_en' => 'Ayun Pa',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '625',
//            'name_en' => 'Kbang',
//            'type_en' => 'Huyện',
//            'location' => '14 18 08N, 108 29 17E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '626',
//            'name_en' => 'Đăk Đoa',
//            'type_en' => 'Huyện',
//            'location' => '14 07 02N, 108 09 36E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '627',
//            'name_en' => 'Chư Păh',
//            'type_en' => 'Huyện',
//            'location' => '14 13 30N, 107 56 33E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '628',
//            'name_en' => 'Ia Grai',
//            'type_en' => 'Huyện',
//            'location' => '13 59 25N, 107 43 16E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '629',
//            'name_en' => 'Mang Yang',
//            'type_en' => 'Huyện',
//            'location' => '13 57 26N, 108 18 37E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '630',
//            'name_en' => 'Kông Chro',
//            'type_en' => 'Huyện',
//            'location' => '13 45 47N, 108 36 04E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '631',
//            'name_en' => 'Đức Cơ',
//            'type_en' => 'Huyện',
//            'location' => '13 46 16N, 107 38 26E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '632',
//            'name_en' => 'Chư Prông',
//            'type_en' => 'Huyện',
//            'location' => '13 35 39N, 107 47 36E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '633',
//            'name_en' => 'Chư Sê',
//            'type_en' => 'Huyện',
//            'location' => '13 37 04N, 108 06 56E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '634',
//            'name_en' => 'Đăk Pơ',
//            'type_en' => 'Huyện',
//            'location' => '13 55 47N, 108 36 16E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '635',
//            'name_en' => 'Ia Pa',
//            'type_en' => 'Huyện',
//            'location' => '13 31 37N, 108 30 34E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '637',
//            'name_en' => 'Krông Pa',
//            'type_en' => 'Huyện',
//            'location' => '13 14 13N, 108 39 12E',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '638',
//            'name_en' => 'Phú Thiện',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '639',
//            'name_en' => 'Chư Pưh',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '64'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '643',
//            'name_en' => 'Buôn Ma Thuột',
//            'type_en' => 'Thành Phố',
//            'location' => '12 39 43N, 108 10 40E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '644',
//            'name_en' => 'Buôn Hồ',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '645',
//            'name_en' => 'Ea H\'leo',
//            'type_en' => 'Huyện',
//            'location' => '13 13 52N, 108 12 30E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '646',
//            'name_en' => 'Ea Súp',
//            'type_en' => 'Huyện',
//            'location' => '13 10 59N, 107 46 49E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '647',
//            'name_en' => 'Buôn Đôn',
//            'type_en' => 'Huyện',
//            'location' => '12 52 45N, 107 45 20E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '648',
//            'name_en' => 'Cư M\'gar',
//            'type_en' => 'Huyện',
//            'location' => '12 53 47N, 108 04 16E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '649',
//            'name_en' => 'Krông Búk',
//            'type_en' => 'Huyện',
//            'location' => '12 56 27N, 108 13 54E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '650',
//            'name_en' => 'Krông Năng',
//            'type_en' => 'Huyện',
//            'location' => '12 59 41N, 108 23 42E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '651',
//            'name_en' => 'Ea Kar',
//            'type_en' => 'Huyện',
//            'location' => '12 48 17N, 108 32 42E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '652',
//            'name_en' => 'M\'đrắk',
//            'type_en' => 'Huyện',
//            'location' => '12 42 14N, 108 47 09E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '653',
//            'name_en' => 'Krông Bông',
//            'type_en' => 'Huyện',
//            'location' => '12 27 08N, 108 27 01E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '654',
//            'name_en' => 'Krông Pắc',
//            'type_en' => 'Huyện',
//            'location' => '12 41 20N, 108 18 42E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '655',
//            'name_en' => 'Krông A Na',
//            'type_en' => 'Huyện',
//            'location' => '12 31 51N, 108 05 03E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '656',
//            'name_en' => 'Lắk',
//            'type_en' => 'Huyện',
//            'location' => '12 19 20N, 108 12 17E',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '657',
//            'name_en' => 'Cư Kuin',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '66'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '660',
//            'name_en' => 'Gia Nghĩa',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '661',
//            'name_en' => 'Đắk Glong',
//            'type_en' => 'Huyện',
//            'location' => '12 01 53N, 107 50 37E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '662',
//            'name_en' => 'Cư Jút',
//            'type_en' => 'Huyện',
//            'location' => '12 40 56N, 107 44 44E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '663',
//            'name_en' => 'Đắk Mil',
//            'type_en' => 'Huyện',
//            'location' => '12 31 08N, 107 42 24E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '664',
//            'name_en' => 'Krông Nô',
//            'type_en' => 'Huyện',
//            'location' => '12 22 16N, 107 53 49E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '665',
//            'name_en' => 'Đắk Song',
//            'type_en' => 'Huyện',
//            'location' => '12 14 04N, 107 36 30E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '666',
//            'name_en' => 'Đắk R\'lấp',
//            'type_en' => 'Huyện',
//            'location' => '12 02 30N, 107 25 59E',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '667',
//            'name_en' => 'Tuy Đức',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '67'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '672',
//            'name_en' => 'Đà Lạt',
//            'type_en' => 'Thành Phố',
//            'location' => '11 54 33N, 108 27 08E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '673',
//            'name_en' => 'Bảo Lộc',
//            'type_en' => 'Thị Xã',
//            'location' => '11 32 48N, 107 47 37E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '674',
//            'name_en' => 'Đam Rông',
//            'type_en' => 'Huyện',
//            'location' => '12 02 35N, 108 10 26E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '675',
//            'name_en' => 'Lạc Dương',
//            'type_en' => 'Huyện',
//            'location' => '12 08 30N, 108 27 48E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '676',
//            'name_en' => 'Lâm Hà',
//            'type_en' => 'Huyện',
//            'location' => '11 55 26N, 108 11 31E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '677',
//            'name_en' => 'Đơn Dương',
//            'type_en' => 'Huyện',
//            'location' => '11 48 26N, 108 32 48E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '678',
//            'name_en' => 'Đức Trọng',
//            'type_en' => 'Huyện',
//            'location' => '11 41 50N, 108 18 58E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '679',
//            'name_en' => 'Di Linh',
//            'type_en' => 'Huyện',
//            'location' => '11 31 10N, 108 05 23E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '680',
//            'name_en' => 'Bảo Lâm',
//            'type_en' => 'Huyện',
//            'location' => '11 38 31N, 107 43 25E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '681',
//            'name_en' => 'Đạ Huoai',
//            'type_en' => 'Huyện',
//            'location' => '11 27 11N, 107 38 08E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '682',
//            'name_en' => 'Đạ Tẻh',
//            'type_en' => 'Huyện',
//            'location' => '11 33 46N, 107 32 00E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '683',
//            'name_en' => 'Cát Tiên',
//            'type_en' => 'Huyện',
//            'location' => '11 39 38N, 107 23 27E',
//            'province_id' => '68'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '688',
//            'name_en' => 'Phước Long',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '689',
//            'name_en' => 'Đồng Xoài',
//            'type_en' => 'Thị Xã',
//            'location' => '11 31 01N, 106 50 21E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '690',
//            'name_en' => 'Bình Long',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '691',
//            'name_en' => 'Bù Gia Mập',
//            'type_en' => 'Huyện',
//            'location' => '11 56 57N, 106 59 21E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '692',
//            'name_en' => 'Lộc Ninh',
//            'type_en' => 'Huyện',
//            'location' => '11 49 28N, 106 35 11E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '693',
//            'name_en' => 'Bù Đốp',
//            'type_en' => 'Huyện',
//            'location' => '11 59 08N, 106 49 54E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '694',
//            'name_en' => 'Hớn Quản',
//            'type_en' => 'Huyện',
//            'location' => '11 37 37N, 106 36 02E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '695',
//            'name_en' => 'Đồng Phù',
//            'type_en' => 'Huyện',
//            'location' => '11 28 45N, 106 57 07E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '696',
//            'name_en' => 'Bù Đăng',
//            'type_en' => 'Huyện',
//            'location' => '11 46 09N, 107 14 14E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '697',
//            'name_en' => 'Chơn Thành',
//            'type_en' => 'Huyện',
//            'location' => '11 28 45N, 106 39 26E',
//            'province_id' => '70'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '703',
//            'name_en' => 'Tây Ninh',
//            'type_en' => 'Thị Xã',
//            'location' => '11 21 59N, 106 07 47E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '705',
//            'name_en' => 'Tân Biên',
//            'type_en' => 'Huyện',
//            'location' => '11 35 14N, 105 57 53E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '706',
//            'name_en' => 'Tân Châu',
//            'type_en' => 'Huyện',
//            'location' => '11 34 49N, 106 17 48E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '707',
//            'name_en' => 'Dương Minh Châu',
//            'type_en' => 'Huyện',
//            'location' => '11 22 04N, 106 16 58E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '708',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '11 19 02N, 106 00 15E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '709',
//            'name_en' => 'Hòa Thành',
//            'type_en' => 'Huyện',
//            'location' => '11 15 31N, 106 08 44E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '710',
//            'name_en' => 'Gò Dầu',
//            'type_en' => 'Huyện',
//            'location' => '11 09 39N, 106 14 42E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '711',
//            'name_en' => 'Bến Cầu',
//            'type_en' => 'Huyện',
//            'location' => '11 07 50N, 106 08 25E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '712',
//            'name_en' => 'Trảng Bàng',
//            'type_en' => 'Huyện',
//            'location' => '11 06 18N, 106 23 12E',
//            'province_id' => '72'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '718',
//            'name_en' => 'Thủ Dầu Một',
//            'type_en' => 'Thị Xã',
//            'location' => '11 00 01N, 106 38 56E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '720',
//            'name_en' => 'Dầu Tiếng',
//            'type_en' => 'Huyện',
//            'location' => '11 19 07N, 106 26 59E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '721',
//            'name_en' => 'Bến Cát',
//            'type_en' => 'Huyện',
//            'location' => '11 12 42N, 106 36 28E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '722',
//            'name_en' => 'Phú Giáo',
//            'type_en' => 'Huyện',
//            'location' => '11 20 21N, 106 47 48E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '723',
//            'name_en' => 'Tân Uyên',
//            'type_en' => 'Huyện',
//            'location' => '11 06 31N, 106 49 02E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '724',
//            'name_en' => 'Dĩ An',
//            'type_en' => 'Huyện',
//            'location' => '10 55 03N, 106 47 09E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '725',
//            'name_en' => 'Thuận An',
//            'type_en' => 'Huyện',
//            'location' => '10 55 58N, 106 41 59E',
//            'province_id' => '74'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '731',
//            'name_en' => 'Biên Hòa',
//            'type_en' => 'Thành Phố',
//            'location' => '10 56 31N, 106 50 50E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '732',
//            'name_en' => 'Long Khánh',
//            'type_en' => 'Thị Xã',
//            'location' => '10 56 24N, 107 14 29E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '734',
//            'name_en' => 'Tân Phú',
//            'type_en' => 'Huyện',
//            'location' => '11 22 51N, 107 21 35E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '735',
//            'name_en' => 'Vĩnh Cửu',
//            'type_en' => 'Huyện',
//            'location' => '11 14 31N, 107 00 06E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '736',
//            'name_en' => 'Định Quán',
//            'type_en' => 'Huyện',
//            'location' => '11 12 41N, 107 17 03E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '737',
//            'name_en' => 'Trảng Bom',
//            'type_en' => 'Huyện',
//            'location' => '10 58 39N, 107 00 52E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '738',
//            'name_en' => 'Thống Nhất',
//            'type_en' => 'Huyện',
//            'location' => '10 58 29N, 107 09 26E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '739',
//            'name_en' => 'Cẩm Mỹ',
//            'type_en' => 'Huyện',
//            'location' => '10 47 05N, 107 14 36E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '740',
//            'name_en' => 'Long Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 47 38N, 106 59 42E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '741',
//            'name_en' => 'Xuân Lộc',
//            'type_en' => 'Huyện',
//            'location' => '10 55 39N, 107 24 21E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '742',
//            'name_en' => 'Nhơn Trạch',
//            'type_en' => 'Huyện',
//            'location' => '10 39 18N, 106 53 18E',
//            'province_id' => '75'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '747',
//            'name_en' => 'Vũng Tầu',
//            'type_en' => 'Thành Phố',
//            'location' => '10 24 08N, 107 07 05E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '748',
//            'name_en' => 'Bà Rịa',
//            'type_en' => 'Thị Xã',
//            'location' => '10 30 33N, 107 10 47E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '750',
//            'name_en' => 'Châu Đức',
//            'type_en' => 'Huyện',
//            'location' => '10 39 23N, 107 15 08E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '751',
//            'name_en' => 'Xuyên Mộc',
//            'type_en' => 'Huyện',
//            'location' => '10 37 46N, 107 29 39E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '752',
//            'name_en' => 'Long Điền',
//            'type_en' => 'Huyện',
//            'location' => '10 26 47N, 107 12 53E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '753',
//            'name_en' => 'Đất Đỏ',
//            'type_en' => 'Huyện',
//            'location' => '10 28 40N, 107 18 27E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '754',
//            'name_en' => 'Tân Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 34 50N, 107 05 06E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '755',
//            'name_en' => 'Côn Đảo',
//            'type_en' => 'Huyện',
//            'location' => '8 42 25N, 106 36 05E',
//            'province_id' => '77'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '794',
//            'name_en' => 'Tân An',
//            'type_en' => 'Thành Phố',
//            'location' => '10 31 36N, 106 24 06E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '796',
//            'name_en' => 'Tân Hưng',
//            'type_en' => 'Huyện',
//            'location' => '10 49 05N, 105 39 26E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '797',
//            'name_en' => 'Vĩnh Hưng',
//            'type_en' => 'Huyện',
//            'location' => '10 52 54N, 105 45 58E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '798',
//            'name_en' => 'Mộc Hóa',
//            'type_en' => 'Huyện',
//            'location' => '10 47 09N, 105 57 56E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '799',
//            'name_en' => 'Tân Thạnh',
//            'type_en' => 'Huyện',
//            'location' => '10 37 44N, 105 57 07E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '800',
//            'name_en' => 'Thạnh Hóa',
//            'type_en' => 'Huyện',
//            'location' => '10 41 37N, 106 11 08E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '801',
//            'name_en' => 'Đức Huệ',
//            'type_en' => 'Huyện',
//            'location' => '10 51 57N, 106 15 48E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '802',
//            'name_en' => 'Đức Hòa',
//            'type_en' => 'Huyện',
//            'location' => '10 53 04N, 106 23 58E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '803',
//            'name_en' => 'Bến Lức',
//            'type_en' => 'Huyện',
//            'location' => '10 41 40N, 106 26 28E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '804',
//            'name_en' => 'Thủ Thừa',
//            'type_en' => 'Huyện',
//            'location' => '10 39 41N, 106 20 12E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '805',
//            'name_en' => 'Tân Trụ',
//            'type_en' => 'Huyện',
//            'location' => '10 31 47N, 106 30 06E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '806',
//            'name_en' => 'Cần Đước',
//            'type_en' => 'Huyện',
//            'location' => '10 32 21N, 106 36 33E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '807',
//            'name_en' => 'Cần Giuộc',
//            'type_en' => 'Huyện',
//            'location' => '10 34 43N, 106 38 35E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '808',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 27 52N, 106 30 00E',
//            'province_id' => '80'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '815',
//            'name_en' => 'Mỹ Tho',
//            'type_en' => 'Thành Phố',
//            'location' => '10 22 14N, 106 21 52E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '816',
//            'name_en' => 'Gò Công',
//            'type_en' => 'Thị Xã',
//            'location' => '10 21 55N, 106 40 24E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '818',
//            'name_en' => 'Tân Phước',
//            'type_en' => 'Huyện',
//            'location' => '10 30 36N, 106 13 02E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '819',
//            'name_en' => 'Cái Bè',
//            'type_en' => 'Huyện',
//            'location' => '10 24 21N, 105 56 01E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '820',
//            'name_en' => 'Cai Lậy',
//            'type_en' => 'Huyện',
//            'location' => '10 24 20N, 106 06 05E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '821',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '20 25 21N, 106 16 57E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '822',
//            'name_en' => 'Chợ Gạo',
//            'type_en' => 'Huyện',
//            'location' => '10 23 45N, 106 26 53E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '823',
//            'name_en' => 'Gò Công Tây',
//            'type_en' => 'Huyện',
//            'location' => '10 19 55N, 106 35 02E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '824',
//            'name_en' => 'Gò Công Đông',
//            'type_en' => 'Huyện',
//            'location' => '10 20 42N, 106 42 54E',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '825',
//            'name_en' => 'Tân Phú Đông',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '82'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '829',
//            'name_en' => 'Bến Tre',
//            'type_en' => 'Thành Phố',
//            'location' => '10 14 17N, 106 22 26E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '831',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 17 24N, 106 17 45E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '832',
//            'name_en' => 'Chợ Lách',
//            'type_en' => 'Huyện',
//            'location' => '10 13 26N, 106 09 08E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '833',
//            'name_en' => 'Mỏ Cày Nam',
//            'type_en' => 'Huyện',
//            'location' => '10 06 56N, 106 19 40E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '834',
//            'name_en' => 'Giồng Trôm',
//            'type_en' => 'Huyện',
//            'location' => '10 08 46N, 106 28 12E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '835',
//            'name_en' => 'Bình Đại',
//            'type_en' => 'Huyện',
//            'location' => '10 09 56N, 106 37 46E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '836',
//            'name_en' => 'Ba Tri',
//            'type_en' => 'Huyện',
//            'location' => '10 04 08N, 106 35 10E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '837',
//            'name_en' => 'Thạnh Phú',
//            'type_en' => 'Huyện',
//            'location' => '9 55 53N, 106 32 45E',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '838',
//            'name_en' => 'Mỏ Cày Bắc',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '83'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '842',
//            'name_en' => 'Trà Vinh',
//            'type_en' => 'Thị Xã',
//            'location' => '9 57 09N, 106 20 39E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '844',
//            'name_en' => 'Càng Long',
//            'type_en' => 'Huyện',
//            'location' => '9 58 18N, 106 12 52E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '845',
//            'name_en' => 'Cầu Kè',
//            'type_en' => 'Huyện',
//            'location' => '9 51 23N, 106 03 33E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '846',
//            'name_en' => 'Tiểu Cần',
//            'type_en' => 'Huyện',
//            'location' => '9 48 37N, 106 12 06E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '847',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '9 52 57N, 106 24 12E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '848',
//            'name_en' => 'Cầu Ngang',
//            'type_en' => 'Huyện',
//            'location' => '9 47 14N, 106 29 19E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '849',
//            'name_en' => 'Trà Cú',
//            'type_en' => 'Huyện',
//            'location' => '9 42 06N, 106 16 24E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '850',
//            'name_en' => 'Duyên Hải',
//            'type_en' => 'Huyện',
//            'location' => '9 39 58N, 106 26 23E',
//            'province_id' => '84'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '855',
//            'name_en' => 'Vĩnh Long',
//            'type_en' => 'Thành Phố',
//            'location' => '10 15 09N, 105 56 08E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '857',
//            'name_en' => 'Long Hồ',
//            'type_en' => 'Huyện',
//            'location' => '10 13 58N, 105 55 47E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '858',
//            'name_en' => 'Mang Thít',
//            'type_en' => 'Huyện',
//            'location' => '10 10 58N, 106 05 13E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '859',
//            'name_en' => 'Vũng Liêm',
//            'type_en' => 'Huyện',
//            'location' => '10 03 32N, 106 10 35E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '860',
//            'name_en' => 'Tam Bình',
//            'type_en' => 'Huyện',
//            'location' => '10 03 58N, 105 58 03E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '861',
//            'name_en' => 'Bình Minh',
//            'type_en' => 'Huyện',
//            'location' => '10 05 45N, 105 47 21E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '862',
//            'name_en' => 'Trà Ôn',
//            'type_en' => 'Huyện',
//            'location' => '9 59 20N, 105 57 56E',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '863',
//            'name_en' => 'Bình Tân',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '86'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '866',
//            'name_en' => 'Cao Lãnh',
//            'type_en' => 'Thành Phố',
//            'location' => '10 27 38N, 105 37 21E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '867',
//            'name_en' => 'Sa Đéc',
//            'type_en' => 'Thị Xã',
//            'location' => '10 19 22N, 105 44 31E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '868',
//            'name_en' => 'Hồng Ngự',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '869',
//            'name_en' => 'Tân Hồng',
//            'type_en' => 'Huyện',
//            'location' => '10 52 48N, 105 29 21E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '870',
//            'name_en' => 'Hồng Ngự',
//            'type_en' => 'Huyện',
//            'location' => '10 48 13N, 105 19 00E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '871',
//            'name_en' => 'Tam Nông',
//            'type_en' => 'Huyện',
//            'location' => '10 44 06N, 105 30 58E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '872',
//            'name_en' => 'Tháp Mười',
//            'type_en' => 'Huyện',
//            'location' => '10 33 36N, 105 47 13E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '873',
//            'name_en' => 'Cao Lãnh',
//            'type_en' => 'Huyện',
//            'location' => '10 29 03N, 105 41 40E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '874',
//            'name_en' => 'Thanh Bình',
//            'type_en' => 'Huyện',
//            'location' => '10 36 38N, 105 28 51E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '875',
//            'name_en' => 'Lấp Vò',
//            'type_en' => 'Huyện',
//            'location' => '10 21 27N, 105 36 06E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '876',
//            'name_en' => 'Lai Vung',
//            'type_en' => 'Huyện',
//            'location' => '10 14 43N, 105 38 40E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '877',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 13 27N, 105 48 38E',
//            'province_id' => '87'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '883',
//            'name_en' => 'Long Xuyên',
//            'type_en' => 'Thành Phố',
//            'location' => '10 22 22N, 105 25 33E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '884',
//            'name_en' => 'Châu Đốc',
//            'type_en' => 'Thị Xã',
//            'location' => '10 41 20N, 105 05 15E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '886',
//            'name_en' => 'An Phú',
//            'type_en' => 'Huyện',
//            'location' => '10 50 12N, 105 05 33E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '887',
//            'name_en' => 'Tân Châu',
//            'type_en' => 'Thị Xã',
//            'location' => '10 49 11N, 105 11 18E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '888',
//            'name_en' => 'Phú Tân',
//            'type_en' => 'Huyện',
//            'location' => '10 40 26N, 105 14 40E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '889',
//            'name_en' => 'Châu Phú',
//            'type_en' => 'Huyện',
//            'location' => '10 34 12N, 105 12 13E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '890',
//            'name_en' => 'Tịnh Biên',
//            'type_en' => 'Huyện',
//            'location' => '10 33 30N, 105 00 17E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '891',
//            'name_en' => 'Tri Tôn',
//            'type_en' => 'Huyện',
//            'location' => '10 24 41N, 104 56 58E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '892',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '10 25 39N, 105 15 31E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '893',
//            'name_en' => 'Chợ Mới',
//            'type_en' => 'Huyện',
//            'location' => '10 27 23N, 105 26 57E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '894',
//            'name_en' => 'Thoại Sơn',
//            'type_en' => 'Huyện',
//            'location' => '10 16 45N, 105 15 59E',
//            'province_id' => '89'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '899',
//            'name_en' => 'Rạch Giá',
//            'type_en' => 'Thành Phố',
//            'location' => '10 01 35N, 105 06 20E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '900',
//            'name_en' => 'Hà Tiên',
//            'type_en' => 'Thị Xã',
//            'location' => '10 22 54N, 104 30 10E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '902',
//            'name_en' => 'Kiên Lương',
//            'type_en' => 'Huyện',
//            'location' => '10 20 21N, 104 39 46E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '903',
//            'name_en' => 'Hòn Đất',
//            'type_en' => 'Huyện',
//            'location' => '10 14 20N, 104 55 57E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '904',
//            'name_en' => 'Tân Hiệp',
//            'type_en' => 'Huyện',
//            'location' => '10 05 18N, 105 14 04E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '905',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '9 57 37N, 105 10 16E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '906',
//            'name_en' => 'Giồng Giềng',
//            'type_en' => 'Huyện',
//            'location' => '9 56 05N, 105 22 06E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '907',
//            'name_en' => 'Gò Quao',
//            'type_en' => 'Huyện',
//            'location' => '9 43 17N, 105 17 06E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '908',
//            'name_en' => 'An Biên',
//            'type_en' => 'Huyện',
//            'location' => '9 48 37N, 105 03 18E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '909',
//            'name_en' => 'An Minh',
//            'type_en' => 'Huyện',
//            'location' => '9 40 24N, 104 59 05E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '910',
//            'name_en' => 'Vĩnh Thuận',
//            'type_en' => 'Huyện',
//            'location' => '9 33 25N, 105 11 30E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '911',
//            'name_en' => 'Phú Quốc',
//            'type_en' => 'Huyện',
//            'location' => '10 13 44N, 103 57 25E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '912',
//            'name_en' => 'Kiên Hải',
//            'type_en' => 'Huyện',
//            'location' => '9 48 31N, 104 37 48E',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '913',
//            'name_en' => 'U Minh Thượng',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '914',
//            'name_en' => 'Giang Thành',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '91'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '916',
//            'name_en' => 'Ninh Kiều',
//            'type_en' => 'District',
//            'location' => '10 01 58N, 105 45 34E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '917',
//            'name_en' => 'Ô Môn',
//            'type_en' => 'District',
//            'location' => '10 07 28N, 105 37 51E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '918',
//            'name_en' => 'Bình Thuỷ',
//            'type_en' => 'District',
//            'location' => '10 03 42N, 105 43 17E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '919',
//            'name_en' => 'Cái Răng',
//            'type_en' => 'District',
//            'location' => '9 59 57N, 105 46 56E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '923',
//            'name_en' => 'Thốt Nốt',
//            'type_en' => 'District',
//            'location' => '10 14 23N, 105 32 02E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '924',
//            'name_en' => 'Vĩnh Thạnh',
//            'type_en' => 'Huyện',
//            'location' => '10 11 35N, 105 22 45E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '925',
//            'name_en' => 'Cờ Đỏ',
//            'type_en' => 'Huyện',
//            'location' => '10 02 48N, 105 29 46E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '926',
//            'name_en' => 'Phong Điền',
//            'type_en' => 'Huyện',
//            'location' => '9 59 57N, 105 39 35E',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '927',
//            'name_en' => 'Thới Lai',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '92'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '930',
//            'name_en' => 'Vị Thanh',
//            'type_en' => 'Thị Xã',
//            'location' => '9 45 15N, 105 24 50E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '931',
//            'name_en' => 'Ngã Bảy',
//            'type_en' => 'Thị Xã',
//            'location' => '',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '932',
//            'name_en' => 'Châu Thành A',
//            'type_en' => 'Huyện',
//            'location' => '9 55 50N, 105 38 31E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '933',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '9 55 22N, 105 48 37E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '934',
//            'name_en' => 'Phụng Hiệp',
//            'type_en' => 'Huyện',
//            'location' => '9 47 20N, 105 43 29E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '935',
//            'name_en' => 'Vị Thuỷ',
//            'type_en' => 'Huyện',
//            'location' => '9 48 05N, 105 32 13E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '936',
//            'name_en' => 'Long Mỹ',
//            'type_en' => 'Huyện',
//            'location' => '9 40 47N, 105 30 53E',
//            'province_id' => '93'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '941',
//            'name_en' => 'Sóc Trăng',
//            'type_en' => 'Thành Phố',
//            'location' => '9 36 39N, 105 59 00E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '942',
//            'name_en' => 'Châu Thành',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '943',
//            'name_en' => 'Kế Sách',
//            'type_en' => 'Huyện',
//            'location' => '9 49 30N, 105 57 25E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '944',
//            'name_en' => 'Mỹ Tú',
//            'type_en' => 'Huyện',
//            'location' => '9 38 21N, 105 49 52E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '945',
//            'name_en' => 'Cù Lao Dung',
//            'type_en' => 'Huyện',
//            'location' => '9 37 36N, 106 12 13E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '946',
//            'name_en' => 'Long Phú',
//            'type_en' => 'Huyện',
//            'location' => '9 34 38N, 106 06 07E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '947',
//            'name_en' => 'Mỹ Xuyên',
//            'type_en' => 'Huyện',
//            'location' => '9 28 16N, 105 55 51E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '948',
//            'name_en' => 'Ngã Năm',
//            'type_en' => 'Huyện',
//            'location' => '9 31 38N, 105 37 22E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '949',
//            'name_en' => 'Thạnh Trị',
//            'type_en' => 'Huyện',
//            'location' => '9 28 05N, 105 43 02E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '950',
//            'name_en' => 'Vĩnh Châu',
//            'type_en' => 'Huyện',
//            'location' => '9 20 50N, 105 59 58E',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '951',
//            'name_en' => 'Trần Đề',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '94'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '954',
//            'name_en' => 'Bạc Liêu',
//            'type_en' => 'Thị Xã',
//            'location' => '9 16 05N, 105 45 08E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '956',
//            'name_en' => 'Hồng Dân',
//            'type_en' => 'Huyện',
//            'location' => '9 30 37N, 105 24 25E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '957',
//            'name_en' => 'Phước Long',
//            'type_en' => 'Huyện',
//            'location' => '9 23 13N, 105 24 41E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '958',
//            'name_en' => 'Vĩnh Lợi',
//            'type_en' => 'Huyện',
//            'location' => '9 16 51N, 105 40 54E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '959',
//            'name_en' => 'Giá Rai',
//            'type_en' => 'Huyện',
//            'location' => '9 15 51N, 105 23 18E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '960',
//            'name_en' => 'Đông Hải',
//            'type_en' => 'Huyện',
//            'location' => '9 08 11N, 105 24 42E',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '961',
//            'name_en' => 'Hoà Bình',
//            'type_en' => 'Huyện',
//            'location' => '',
//            'province_id' => '95'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '964',
//            'name_en' => 'Cà Mau',
//            'type_en' => 'Thành Phố',
//            'location' => '9 10 33N, 105 11 11E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '966',
//            'name_en' => 'U Minh',
//            'type_en' => 'Huyện',
//            'location' => '9 22 30N, 104 57 00E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '967',
//            'name_en' => 'Thới Bình',
//            'type_en' => 'Huyện',
//            'location' => '9 22 50N, 105 07 35E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '968',
//            'name_en' => 'Trần Văn Thời',
//            'type_en' => 'Huyện',
//            'location' => '9 07 36N, 104 57 27E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '969',
//            'name_en' => 'Cái Nước',
//            'type_en' => 'Huyện',
//            'location' => '9 00 31N, 105 03 23E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '970',
//            'name_en' => 'Đầm Dơi',
//            'type_en' => 'Huyện',
//            'location' => '8 57 48N, 105 13 56E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '971',
//            'name_en' => 'Năm Căn',
//            'type_en' => 'Huyện',
//            'location' => '8 46 59N, 104 58 20E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '972',
//            'name_en' => 'Phú Tân',
//            'type_en' => 'Huyện',
//            'location' => '8 52 47N, 104 53 35E',
//            'province_id' => '96'
//        ]);
//        DB::table('districts')->insert([
//            'id' => '973',
//            'name_en' => 'Ngọc Hiển',
//            'type_en' => 'Huyện',
//            'location' => '8 40 47N, 104 57 58E',
//            'province_id' => '96'
//        ]);
	}
}