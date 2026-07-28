<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VendeurSeeder::class,
            SettingSeeder::class,
            HotspotSeeder::class,
            ForfaitSeeder::class,
            DemoVendeursSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
