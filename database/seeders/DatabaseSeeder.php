<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(TripSeeder::class);
        $this->call(DriverDocumentSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
