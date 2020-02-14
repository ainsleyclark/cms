<?php

namespace Core\Database\seeds;

use Illuminate\Database\Seeder;

class CoreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Core\Database\Seeds\RolesSeeder::class);
        $this->call(Core\Database\Seeds\SettingsSeeder::class);
    }
}
