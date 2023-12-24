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
                'is_admin' => 1,
            ],
            [
                'name' => 'eldapour',
                'image' => '1.jpg',
                'gmail' => 'eldapour@admin.com',
                'password' => Hash::make('123456'),
                'is_admin' => 1,
            ],
            [
                'name' => 'ahmed',
                'image' => '1.jpg',
                'gmail' => 'ahmed@admin.com',
                'password' => Hash::make('123456'),
                'is_admin' => 1,
            ],
        ];

        DB::table('users')->insert($data);
    }
}
