<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageUserSeeder extends Seeder
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
                'package_id' => 1,
                'user_id' => 3,
                'from' => '2023-02-04',
                'to' => '2023-02-08',
            ],
            [
                'package_id' => 2,
                'user_id' => 7,
                'from' => '2023-02-09',
                'to' => '2023-02-14',
            ],
            [
                'package_id' => 3,
                'user_id' => 1,
                'from' => '2023-02-15',
                'to' => '2023-02-20',
            ],
            [
                'package_id' => 4,
                'user_id' => 4,
                'from' => '2023-02-21',
                'to' => '2023-02-26',
            ],
            [
                'package_id' => 5,
                'user_id' => 5,
                'from' => '2023-02-27',
                'to' => '2023-03-04',
            ],
            [
                'package_id' => 6,
                'user_id' => 6,
                'from' => '2023-03-05',
                'to' => '2023-03-10',
            ],
        ];
        DB::table('package_user')->insert($data);
    }
}
