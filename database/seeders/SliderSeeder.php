<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'image' => $faker->imageUrl(), // Generates a random image URL
                'url' => $faker->url, // Generates a random URL
            ];
        }

        DB::table('sliders')->insert($data);
    }
}
