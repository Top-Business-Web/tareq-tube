<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
                'name' => 'abdullah',
                'email' => 'abdullah.alhumsi@gmail.com',
                'phone' => '01054564562',
                'img' => 'assets/uploads/avatar.png',
                'birth' => '2023-10-11',
                'password' => Hash::make('123456'),
                'type' => 'user',
                'status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'eldapour',
                'email' => 'abdullah.eldapour@gmail.com',
                'phone' => '01054564566',
                'img' => 'assets/uploads/avatar.png',
                'birth' => '2023-10-11',
                'password' => Hash::make('123456'),
                'type' => 'user',
                'status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'eslam',
                'email' => 'eslam.mohammed@gmail.com',
                'phone' => '01054564567',
                'img' => 'assets/uploads/avatar.png',
                'birth' => '2023-10-11',
                'password' => Hash::make('123456'),
                'type' => 'user',
                'status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ahmed',
                'email' => 'ahmed.alsabbagh@gmail.com',
                'phone' => '01054564564',
                'img' => 'assets/uploads/avatar.png',
                'birth' => '2023-10-11',
                'password' => Hash::make('123456'),
                'type' => 'user',
                'status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('users')->insert($data);
    }
}
