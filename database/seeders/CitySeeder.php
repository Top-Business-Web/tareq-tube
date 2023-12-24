<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'name' => $this->generateCityName(),
            ];
        }

        DB::table('cities')->insert($data);
    }

    private function generateCityName()
    {
        $cities = ['Cairo', 'Giza', 'Alexandria', 'Luxor', 'Aswan', 'Sharm El Sheikh', 'Hurghada', 'Mansoura', 'Tanta', 'Ismailia', 'Port Said', 'Suez', 'Minya', 'Assiut', 'Sohag', 'Beni Suef', 'Zagazig', 'Fayoum', 'Damietta', 'Qena', 'Banha', 'Kafr El Sheikh', 'Damanhur', 'El Mahalla El Kubra', 'Asyut', 'New Cairo', '6th of October City', 'Makadi Bay', 'Ras Sedr'];

        return $cities[array_rand($cities)];
    }
}
