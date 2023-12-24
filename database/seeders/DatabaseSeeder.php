<?php

namespace Database\Seeders;

use App\Models\ConfigCount;
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
        $this->call([
            CitySeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            PackageSeeder::class,
            InterestSeeder::class,
            PackageUserSeeder::class,
            SliderSeeder::class,
            MsgSeeder::class,
            NotificationSeeder::class,
            CouponSeeder::class,
            ConfigCountSeeder::class,
            TubeSeeder::class,
            UserActionSeeder::class,
        ]);
    }
}
