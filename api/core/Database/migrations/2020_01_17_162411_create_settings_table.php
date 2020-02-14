<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('value')->nullable();
        });

        $initialConfig = [
            ['name' => 'site_url', 'value' => null],
            ['name' => 'site_name', 'value' => null],
            ['name' => 'site_description', 'value' => null],
            ['name' => 'theme_active', 'value' => 'DefaultTheme'],
            ['name' => 'theme_config', 'value' => null]
        ];

        DB::table('settings')->insert($initialConfig);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
