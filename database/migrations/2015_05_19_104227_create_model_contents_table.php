<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('model_contents', function(Blueprint $table)
		{
            $table->engine = 'MyISAM';

			$table->increments('id');
            $table->string('title')->nullable();
            $table->string('model_type');
            $table->string('type')->nullable();
            $table->string('lang', 20);
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(0);
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
		Schema::drop('model_contents');
	}

}
