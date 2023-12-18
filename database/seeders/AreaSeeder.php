<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'النزهة',
                'city_id' => '1',
            ],
            [
                'name' => 'السلام',
                'city_id' => '1',
            ],
            [
                'name' => 'عبود',
                'city_id' => '1',
            ],
            [
                'name' => 'سكروز',
                'city_id' => '2',
            ],
            [
                'name' => 'هندسة',
                'city_id' => '2',
            ],
            [
                'name' => 'عمرو',
                'city_id' => '2',
            ],
            [
                'name' => 'شارع شيكاغو',
                'city_id' => '3',
            ],
            [
                'name' => 'كفر عبدو',
                'city_id' => '3',
            ],
            [
                'name' => 'ساحل',
                'city_id' => '3',
            ],
            [
                'name' => 'نهر',
                'city_id' => '4',
            ],
            [
                'name' => 'عمر افندي',
                'city_id' => '4',
            ],
            [
                'name' => 'ساحل',
                'city_id' => '4',
            ],
            [
                'name' => 'شارع 100',
                'city_id' => '5',
            ],
            [
                'name' => 'المحجوب',
                'city_id' => '5',
            ],
            [
                'name' => 'الاولى',
                'city_id' => '5',
            ],
        ];
        DB::table('areas')->insert($data);
    }
}
