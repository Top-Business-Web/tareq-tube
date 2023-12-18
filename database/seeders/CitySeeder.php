<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
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
                'name' => 'القاهرة',
            ],
            [
                'name' => 'المنوفية',
            ],
            [
                'name' => 'الاسكندرية',
            ],
            [
                'name' => 'بور سعيد',
            ],
            [
                'name' => 'دمياط الجديدة',
            ],
        ];
        DB::table('cities')->insert($data);
    }
}
