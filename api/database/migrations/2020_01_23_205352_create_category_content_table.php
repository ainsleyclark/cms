<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_content', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->string('category_name');
            $table->text('category_slug');
            $table->string('category_description')->nullable();
            $table->string('category_parent_id')->nullable();
            $table->integer('page_id');
            $table->dateTime('category_content_created_at');
            $table->dateTime('category_content_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_content');
    }
}
