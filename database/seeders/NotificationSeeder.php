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
                'user_id' => '1',
                'title' => 'new trip',
                'description' => 'Commodo laboris aliquip commodo ad deserunt et.',
                'seen' => '1',
            ],
            [
                'user_id' => '2',
                'title' => 'complete trip',
                'description' => 'Commodo laboris aliquip commodo ad deserunt et.',
                'seen' => '1',
            ],
            [
                'user_id' => '3',
                'title' => 'new cairo',
                'description' => 'Commodo laboris aliquip commodo ad deserunt et.',
                'seen' => '1',
            ],
            [
                'user_id' => '4',
                'title' => 'salam',
                'description' => 'Commodo laboris aliquip commodo ad deserunt et.',
                'seen' => '1',
            ],
        ];
        DB::table('notifications')->insert($data);
    }
}
