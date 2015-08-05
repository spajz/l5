<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function(Blueprint $table)
        {
            $table->increments('id');
//            $table->string('title')->nullable();
//            $table->string('sub_title')->nullable();
//            $table->string('slug')->nullable();
//            $table->text('intro')->nullable();
//            $table->text('description')->nullable();

            $table->integer('order')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

//            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('works');
    }
}
