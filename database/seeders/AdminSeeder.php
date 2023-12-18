<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'abdullah',
                'email' => 'admin@abdullah.com',
                'password' => bcrypt('123456'),
                'image' => 'assets/uploads/avatar.png',
            ],
            [
                'name' => 'eldapour',
                'email' => 'admin@eldapour.com',
                'password' => bcrypt('123456'),
                'image' => 'assets/uploads/avatar.png',
            ],
            [
                'name' => 'eslam',
                'email' => 'admin@eslam.com',
                'password' => bcrypt('123456'),
                'image' => 'assets/uploads/avatar.png',
            ],
            [
                'name' => 'ahmed',
                'email' => 'admin@ahmed.com',
                'password' => bcrypt('123456'),
                'image' => 'assets/uploads/avatar.png',
            ],
        ];
        DB::table('admins')->insert($data);
    }
}
