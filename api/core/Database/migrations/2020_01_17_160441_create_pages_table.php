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
            $table->bigIncrements('id');
            $table->text('slug');
            $table->integer('status')->default(0);
            $table->integer('author_id');
            $table->string('template');
            $table->boolean('cacheable');
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('crawlable')->default(true);
            $table->text('og_image');
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
        Schema::dropIfExists('pages');
    }
}
