<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('content_values', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('content_id');
            $table->string('value_type')->nullable();
            $table->string('value_sub_type')->nullable();
            $table->text('value')->nullable();
            $table->integer('order')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('content_values');
	}

}
