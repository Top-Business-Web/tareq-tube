<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
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
                'logo' => 'assets/uploads/logo.png',
                'vat' => '15',
                'km' => '750',
                'trip_insurance' => 'Nulla deserunt nisi et excepteur proident nostrud dolor quis aliquip elit.',
                'rewards' => 'Ullamco consectetur fugiat deserunt consequat in et.',
                'about' => 'Eiusmod voluptate nisi ea quis mollit cillum eiusmod mollit quis mollit.',
                'support' => 'Magna et enim ullamco quis quis irure nisi quis duis irure ullamco pariatur.',
                'safety_roles' => 'Ad incididunt ut labore aliqua nulla amet.',
                'polices' => 'Magna Lorem non ex tempor qui voluptate est duis magna do.',
            ],
        ];
        DB::table('settings')->insert($data);
    }
}
