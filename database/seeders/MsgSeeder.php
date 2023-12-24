<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsgSeeder extends Seeder
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
                'url' => 'https://www.facebook.com/',
                'user_id' => '1',
                'content' => 'hello',
                'city_id' => '1',
                'intrest_id' => '1',
            ],
            [
                'url' => 'https://www.instagram.com/',
                'user_id' => '2',
                'content' => 'hi',
                'city_id' => '2',
                'intrest_id' => '2',
            ],
            [
                'url' => 'https://www.twitter.com/',
                'user_id' => '3',
                'content' => 'how are you',
                'city_id' => '3',
                'intrest_id' => '3',
            ],
            [
                'url' => 'https://www.linkedin.com/',
                'user_id' => '4',
                'content' => 'what are you doing',
                'city_id' => '4',
                'intrest_id' => '4',
            ],
            [
                'url' => 'https://www.tiktok.com/',
                'user_id' => '5',
                'content' => 'aaaaaaaaaaaaaaa',
                'city_id' => '5',
                'intrest_id' => '5',
            ],
        ];
        DB::table('msg')->insert($data);
    }
}
