<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
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
                'name' => '50 point',
                'price' => 225,
                'days' => 1,
            ],
            [
                'name' => '20 point',
                'price' => 444,
                'days' => 1,
            ],
            [
                'name' => '30 point',
                'price' => 255,
                'days' => 1,
            ],
            [
                'name' => '10 point',
                'price' => 150,
                'days' => 1,
            ],
            [
                'name' => '60 point',
                'price' => 200,
                'days' => 1,
            ],
            [
                'name' => '70 point',
                'price' => 221,
                'days' => 1,
            ],
        ];

        DB::table('packages')->insert($data);
    }
}
