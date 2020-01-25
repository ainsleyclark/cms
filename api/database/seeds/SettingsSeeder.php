<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initialConfig = [
            ['name' => 'site_url', 'value' => null],
            ['name' => 'site_name', 'value' => null],
            ['name' => 'site_description', 'value' => null],
            ['name' => 'theme_active', 'value' => 'DefaultTheme'],
            ['name' => 'theme_config', 'value' => null]
        ];

        DB::table('settings')->insert($initialConfig);
    }
}
