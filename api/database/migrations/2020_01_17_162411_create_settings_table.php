<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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

        //Insert initial configuration
        $initialConfig = [
            ['name' => 'theme_active', 'value' => 'DefaultTheme'],
            ['name' => 'theme_config', 'value' => null]
        ];

        \Illuminate\Support\Facades\DB::table('settings')->insert($initialConfig);
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
