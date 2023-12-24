<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 20;

        for ($i = 1; $i <= $recordCount; $i++) {
            $type = ($i % 3 == 0) ? 'view' : (($i % 2 == 0) ? 'sub' : 'second');
            $count = rand(1, 100);

            // Adjust points based on the type
            switch ($type) {
                case 'second':
                    $point = $count * 5; // 100 seconds equal 500 points
                    break;
                case 'sub':
                    $point = $count * 100; // 1 sub equals 100 points
                    break;
                case 'view':
                    $point = $count * 5; // 100 views equal 500 points
                    break;
                default:
                    $point = 0;
            }

            $data[] = [
                'type' => $type,
                'count' => $count,
                'point' => $point,
            ];
        }

        // Insert the generated data into the database
        DB::table('config_count')->insert($data);
    }
}
