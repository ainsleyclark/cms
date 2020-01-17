<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('page_id');
            $table->text('page_slug');
            $table->integer('page_status')->default(0);
            $table->text('page_author');
            $table->string('page_template');
            $table->boolean('page_cacheable');
            $table->dateTime('page_created_at');
            $table->dateTime('page_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
