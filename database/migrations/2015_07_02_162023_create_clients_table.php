<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->integer('client_group_id');

            $table->integer('order')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('client_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
