<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->bigIncrements('option_id');
            $table->text('option_name');
            $table->text('option_value');
        });

        //Insert initial configuration
        $initialConfig = [
            'option_name' => 'active_theme',
            'option_value' => 'DefaultTheme'
        ];

        \Illuminate\Support\Facades\DB::table('options')->insert($initialConfig);
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
