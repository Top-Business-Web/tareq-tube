<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelPriceSeeder extends Seeder
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
                'type' => 'msg',
                'count' => 1,
                'price' => 10,
            ],
            [
                'type' => 'points ',
                'count' => 2,
                'price' => 20,
            ],
            [
                'type' => 'msg',
                'count' => 22,
                'price' => 250,
            ],
            [
                'type' => 'points',
                'count' => 9,
                'price' => 60,
            ],
            [
                'type' => 'msg',
                'count' => 20,
                'price' => 200,
            ],
            [
                'type' => 'points',
                'count' => 15,
                'price' => 100,
            ],
        ];

        DB::table('model_price')->insert($data);
    }
}
