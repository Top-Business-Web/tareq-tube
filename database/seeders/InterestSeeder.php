<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestSeeder extends Seeder
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
                'name' => 'Technology',
            ],
            [
                'name' => 'Programming',
            ],
            [
                'name' => 'Web Development',
            ],
            [
                'name' => 'Data Science',
            ],
            [
                'name' => 'Artificial Intelligence',
            ],
            [
                'name' => 'Machine Learning',
            ],
            [
                'name' => 'Cybersecurity',
            ],
            [
                'name' => 'Mobile Development',
            ],
            [
                'name' => 'Gaming',
            ],
            [
                'name' => 'Design',
            ],
            [
                'name' => 'Photography',
            ],
            [
                'name' => 'Music',
            ],
            [
                'name' => 'Sports',
            ],
            [
                'name' => 'Fitness',
            ],
            [
                'name' => 'Cooking',
            ],
            [
                'name' => 'Travel',
            ],
            [
                'name' => 'Books',
            ],
            [
                'name' => 'Movies',
            ],
            [
                'name' => 'Finance',
            ],
            [
                'name' => 'Health',
            ],
        ];

        DB::table('intrest')->insert($data);
    }
}
