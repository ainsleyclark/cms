<?php

namespace Core\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            'site_url' => null,
            'active_theme' => null,
            'site_name' => null,
            'site_description' => null,
        ]);
    }
}
