<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSeeder extends Seeder
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
                'type' => 'complete',
                'trip_type' =>'with',
                'from_address' => '123 Main Street, City',
                'from_long' => '-123.456789',
                'from_lat' => '12.345678',
                'to_address' => '456 Elm Street, Another City',
                'to_long' => '-78.901234',
                'to_lat' => '34.567890',
                'time_ride' => '2023-11-02 08:30:00',
                'time_arrive' => '2023-11-02 09:15:00',
                'distance' => '15',
                'time' => '45 minutes',
                'price' => '25',
                'name' => 'John Doe',
                'phone' => '555-555-5555',
                'user_id' => '1',
                'driver_id' => '5',
            ],
            [
                'type' => 'new',
                'trip_type' =>'with',
                'from_address' => '789 Oak Avenue, Townsville',
                'from_long' => '-123.789012',
                'from_lat' => '45.678901',
                'to_address' => '321 Pine Street, Cityville',
                'to_long' => '-78.123456',
                'to_lat' => '34.567890',
                'time_ride' => '2023-11-02 10:15:00',
                'time_arrive' => '2023-11-02 11:00:00',
                'distance' => '8',
                'time' => '45 minutes',
                'price' => '5',
                'name' => 'Alice Johnson',
                'phone' => '555-123-4567',
                'user_id' => '3',
                'driver_id' => '6',
            ],
            [
                'type' => 'new',
                'trip_type' =>'with',
                'from_address' => '456 Elm Street, Another City',
                'from_long' => '-78.901234',
                'from_lat' => '34.567890',
                'to_address' => '987 Maple Lane, Suburbia',
                'to_long' => '-67.123456',
                'to_lat' => '40.678901',
                'time_ride' => '2023-11-02 12:30:00',
                'time_arrive' => '2023-11-02 13:15:00',
                'distance' => '7',
                'time' => '45 minutes',
                'price' => '10',
                'name' => 'Bob Smith',
                'phone' => '555-987-6543',
                'user_id' => '2',
                'driver_id' => '7',
            ],
            [
                'type' => 'new',
                'trip_type' =>'with',
                'from_address' => '123 Main Street, City',
                'from_long' => '-123.456789',
                'from_lat' => '12.345678',
                'to_address' => '555 Willow Road, Countryside',
                'to_long' => '-89.012345',
                'to_lat' => '56.789012',
                'time_ride' => '2023-11-02 15:45:00',
                'time_arrive' => '2023-11-02 16:30:00',
                'distance' => '12',
                'time' => '45 minutes',
                'price' => '15',
                'name' => 'Eve Brown',
                'phone' => '555-789-1234',
                'user_id' => '1',
                'driver_id' => '8',
            ],
        ];
        DB::table('trips')->insert($data);
    }
}
