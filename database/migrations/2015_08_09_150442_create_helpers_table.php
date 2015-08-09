<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpers', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('helper_group_id')->nullable();
            $table->text('intro')->nullable();
            $table->text('description')->nullable();

            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('helper_group_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('helpers');
    }
}
