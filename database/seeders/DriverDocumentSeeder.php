<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverDocumentSeeder extends Seeder
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
                'driver_id' => 5,                   // Driver ID for the first record.
                'agency_number' => 'assets/uploads/slider.png',         // Sample agency number.
                'bike_license' => 'assets/uploads/slider.png',          // Sample bike license.
                'id_card' => 'assets/uploads/slider.png',            // Sample ID card number.
                'house_card' => 'assets/uploads/slider.png',            // Sample house card number.
                'bike_image' => 'assets/uploads/slider.png',        // Sample bike image file name.
                'status' => 1,                      // Assuming '1' represents an active status.
            ],
            [
                'driver_id' => 6,                   // Driver ID for the second record.
                'agency_number' => 'assets/uploads/slider.png',         // Sample agency number.
                'bike_license' => 'assets/uploads/slider.png',          // Sample bike license.
                'id_card' => 'assets/uploads/slider.png',            // Sample ID card number.
                'house_card' => 'assets/uploads/slider.png',            // Sample house card number.
                'bike_image' => 'assets/uploads/slider.png',        // Sample bike image file name.
                'status' => 1,                      // Assuming '1' represents an active status.
            ],
            [
                'driver_id' => 7,                   // Driver ID for the third record.
                'agency_number' => 'assets/uploads/slider.png',         // Sample agency number.
                'bike_license' => 'assets/uploads/slider.png',          // Sample bike license.
                'id_card' => 'assets/uploads/slider.png',            // Sample ID card number.
                'house_card' => 'assets/uploads/slider.png',            // Sample house card number.
                'bike_image' => 'assets/uploads/slider.png',        // Sample bike image file name.
                'status' => 0,                      // Assuming '0' represents an inactive status.
            ],
        ];

        DB::table('driver_documents')->insert($data);
    }
}
