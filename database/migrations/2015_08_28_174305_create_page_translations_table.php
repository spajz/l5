<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('page_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('slug')->nullable();
            $table->text('intro')->nullable();
            $table->text('description')->nullable();

            $table->string('locale')->index();
            $table->unique(['page_id','locale']);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_translations');
    }
}
