<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->text('singular_name');
            $table->text('friendly_name');
            $table->string('slug')->unique();
            //$table->text('categories');
            $table->text('theme');
            $table->string('icon', 40)->nullable();
            $table->smallInteger('menu_position')->nullable();
            $table->longText('single_template')->nullable();
            $table->longText('index_template')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
