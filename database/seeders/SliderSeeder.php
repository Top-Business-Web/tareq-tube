<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
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
                'image' => 'assets/uploads/driver.jpeg',
                'link' => 'https://www.google.com',
                'status' => '0',
            ],
            [
                'image' => 'assets/uploads/driver.jpeg',
                'link' => 'https://www.youtube.com',
                'status' => '0',
            ],
            [
                'image' => 'assets/uploads/driver.jpeg',
                'link' => 'https://www.facebook.com',
                'status' => '0',
            ],
            [
                'image' => 'assets/uploads/driver.jpeg',
                'link' => 'https://www.instagram.com',
                'status' => '0',
            ],
        ];
        DB::table('sliders')->insert($data);
    }
}
