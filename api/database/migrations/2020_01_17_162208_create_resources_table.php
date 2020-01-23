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
            $table->bigIncrements('resource_id');
            $table->text('resource_name');
            $table->text('resource_friendly_name');
            $table->text('resource_slug');
            $table->text('categories');
            $table->text('theme');
            $table->string('resource_icon', 40)->nullable();
            $table->smallInteger('resource_menu_position')->nullable();
            $table->longText('resource_single_template')->nullable();
            $table->longText('resource_index_template')->nullable();
            $table->dateTime('resource_created_at');
            $table->dateTime('resource_updated_at');
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
