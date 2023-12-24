<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
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
                'code' => 'ABC123',
                'points' => 50,
                'limit' => 1000,
            ],
            [
                'code' => 'XYZ456',
                'points' => 75,
                'limit' => 2000,
            ],
            [
                'code' => 'DEF789',
                'points' => 60,
                'limit' => 1500,
            ],
            [
                'code' => 'GHI012',
                'points' => 90,
                'limit' => 2500,
            ],
        ];

        DB::table('copons')->insert($data);
    }
}
