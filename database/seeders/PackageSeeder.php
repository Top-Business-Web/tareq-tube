<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
                'name' => 'شهر',
                'price' => 369,
                'days' => 30,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'شهرين',
                'price' => 599,
                'days' => 60,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'اسبوع',
                'price' => 119,
                'days' => 7,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'اسبوعين',
                'price' => 219,
                'days' => 14,
                'created_at' => Carbon::now()
            ],
        ];

        DB::table('packages')->insert($data);
    }
}
