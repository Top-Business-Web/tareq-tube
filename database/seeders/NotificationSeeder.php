<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
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
                'title' => 'good morning',
                'description' => 'Laborum minim laborum sit tempor ex aliquip nulla nulla veniam officia.',
                'user_id' => 1,
            ],
            [
                'title' => 'good job',
                'description' => 'Laborum minim laborum sit tempor ex aliquip nulla nulla veniam officia.',
                'user_id' => 2,
            ],
            [
                'title' => 'new offer',
                'description' => 'Laborum minim laborum sit tempor ex aliquip nulla nulla veniam officia.',
                'user_id' => 3,
            ],
            [
                'title' => 'sales 70%',
                'description' => 'Laborum minim laborum sit tempor ex aliquip nulla nulla veniam officia.',
                'user_id' => 4,
            ],
            [
                'title' => 'sales 50%',
                'description' => 'Laborum minim laborum sit tempor ex aliquip nulla nulla veniam officia.',
                'user_id' => 5,
            ],
        ];

        DB::table('notifications')->insert($data);
    }
}
