<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'ahmed1',
                'image' => '1.jpg',
                'gmail' => 'ahmed1@admin.com',
                'password' => Hash::make('123456'),
                'google_id' => 1234,
                'city_id' => 3,
                'is_admin' => 0,
                'points' => 0,
                'limit' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/'
            ],
            [
                'name' => 'john',
                'image' => '2.jpg',
                'gmail' => 'john@admin.com',
                'password' => Hash::make('password123'),
                'google_id' => 5678,
                'city_id' => 1,
                'is_admin' => 0,
                'points' => 100,
                'limit' => 5,
                'msg_limit' => 3,
                'youtube_link' => 'https://youtube.com/john'
            ],
            [
                'name' => 'sara',
                'image' => '3.jpg',
                'gmail' => 'sara@admin.com',
                'password' => Hash::make('sara_pass'),
                'google_id' => 9876,
                'city_id' => 2,
                'is_admin' => 0,
                'points' => 50,
                'limit' => 3,
                'msg_limit' => 2,
                'youtube_link' => 'https://youtube.com/sara'
            ],
            [
                'name' => 'mohamed',
                'image' => '4.jpg',
                'gmail' => 'mohamed@admin.com',
                'password' => Hash::make('mohamed_pass'),
                'google_id' => 4321,
                'city_id' => 3,
                'is_admin' => 0,
                'points' => 75,
                'limit' => 2,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/mohamed'
            ],
            [
                'name' => 'alice',
                'image' => '5.jpg',
                'gmail' => 'alice@admin.com',
                'password' => Hash::make('alice_pass'),
                'google_id' => 5670,
                'city_id' => 1,
                'is_admin' => 0,
                'points' => 20,
                'limit' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/alice'
            ],
            [
                'name' => 'emma',
                'image' => '6.jpg',
                'gmail' => 'emma@admin.com',
                'password' => Hash::make('emma_pass'),
                'google_id' => 7890,
                'city_id' => 2,
                'is_admin' => 0,
                'points' => 30,
                'limit' => 2,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/emma'
            ],
            [
                'name' => 'peter',
                'image' => '7.jpg',
                'gmail' => 'peter@admin.com',
                'password' => Hash::make('peter_pass'),
                'google_id' => 3456,
                'city_id' => 1,
                'is_admin' => 0,
                'points' => 15,
                'limit' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/peter'
            ],
            [
                'name' => 'linda',
                'image' => '8.jpg',
                'gmail' => 'linda@admin.com',
                'password' => Hash::make('linda_pass'),
                'google_id' => 2345,
                'city_id' => 3,
                'is_admin' => 0,
                'points' => 40,
                'limit' => 3,
                'msg_limit' => 2,
                'youtube_link' => 'https://youtube.com/linda'
            ],
            [
                'name' => 'kevin',
                'image' => '9.jpg',
                'gmail' => 'kevin@admin.com',
                'password' => Hash::make('kevin_pass'),
                'google_id' => 6789,
                'city_id' => 2,
                'is_admin' => 0,
                'points' => 60,
                'limit' => 2,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/kevin'
            ],
            [
                'name' => 'olivia',
                'image' => '10.jpg',
                'gmail' => 'olivia@admin.com',
                'password' => Hash::make('olivia_pass'),
                'google_id' => 4567,
                'city_id' => 1,
                'is_admin' => 0,
                'points' => 25,
                'limit' => 1,
                'msg_limit' => 1,
                'youtube_link' => 'https://youtube.com/olivia'
            ],
        ];
        DB::table('users')->insert($data);
    }
}
