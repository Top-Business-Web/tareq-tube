<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserActionSeeder extends Seeder
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
                'user_id' => 1,
                'tube_id' => 1,
                'type' => 'view',
                'status' => '0',
                'points' => 25,
            ],
            [
                'user_id' => 2,
                'tube_id' => 2,
                'type' => 'sub',
                'status' => '1',
                'points' => 30,
            ],
            [
                'user_id' => 3,
                'tube_id' => 3,
                'type' => 'view',
                'status' => '0',
                'points' => 44,
            ],
            [
                'user_id' => 4,
                'tube_id' => 4,
                'type' => 'sub',
                'status' => '1',
                'points' => 12,
            ],
        ];
        DB::table('user_actions')->insert($data);
    }
}
