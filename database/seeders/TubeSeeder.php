<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TubeSeeder extends Seeder
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
                'type' => 'view',
                'user_id' => '1',
                'points' => '25',
                'url' => 'https://www.google.com',
                'sub_count' => '22',
                'second_count' => '12',
                'view_count' => '15',
                'target' => '55',
                'status' => '0',
            ],
            [
                'type' => 'sub',
                'user_id' => '2',
                'points' => '30',
                'url' => 'https://www.example.com',
                'sub_count' => '18',
                'second_count' => '10',
                'view_count' => '20',
                'target' => '40',
                'status' => '1',
            ],
            [
                'type' => 'view',
                'user_id' => '3',
                'points' => '35',
                'url' => 'https://www.samplewebsite.com',
                'sub_count' => '25',
                'second_count' => '14',
                'view_count' => '18',
                'target' => '50',
                'status' => '1',
            ],
            [
                'type' => 'sub',
                'user_id' => '4',
                'points' => '22',
                'url' => 'https://www.testingwebsite.com',
                'sub_count' => '20',
                'second_count' => '11',
                'view_count' => '12',
                'target' => '45',
                'status' => '0',
            ],
            [
                'type' => 'view',
                'user_id' => '5',
                'points' => '28',
                'url' => 'https://www.newwebsite.com',
                'sub_count' => '30',
                'second_count' => '16',
                'view_count' => '22',
                'target' => '58',
                'status' => '1',
            ],
        ];

        DB::table('tubes')->insert($data);
    }
}
