<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
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
                'name' => 'alhumsi',
                'image' => '1.jpg',
                'gmail' => 'abdullah@admin.com',
                'password' => Hash::make('123456'),
                'google_id' => 1234,
                'city_id' => 1,
                'is_admin' => 1,
                'intrest_id' => 1,
                'points' => 0,
                'limit' => 1,
                'lang_id' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/'
            ],
            [
                'name' => 'eldapour',
                'image' => '1.jpg',
                'gmail' => 'eldapour@admin.com',
                'password' => Hash::make('123456'),
                'google_id' => 1234,
                'city_id' => 1,
                'is_admin' => 1,
                'intrest_id' => 1,
                'points' => 0,
                'limit' => 1,
                'lang_id' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/'
            ],
            [
                'name' => 'ahmed',
                'image' => '1.jpg',
                'gmail' => 'ahmed@admin.com',
                'password' => Hash::make('123456'),
                'google_id' => '1234',
                'city_id' => '1',
                'is_admin' => '1',
                'intrest_id' => '1',
                'points' => '0',
                'limit' => '1',
                'lang_id' => '1',
                'msg_limit' => '1',
                'youtube_link' => 'https://youtube.com/'
            ],
        ];

        DB::table('users')->insert($data);
    }
}
