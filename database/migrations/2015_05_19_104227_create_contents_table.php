<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('model_type');
            $table->integer('model_id')->default(0);
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
			$table->string('class')->nullable();

            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(0);
			$table->timestamps();

            $table->index(['model_type', 'model_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contents');
	}

}
