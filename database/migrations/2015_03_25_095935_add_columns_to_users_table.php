<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->string('first_name')->nullable()->after('password');
            $table->string('last_name')->nullable()->after('first_name');
            $table->integer('group_id')->after('last_name');
            $table->tinyInteger('status')->default(0)->after('group_id');
            $table->tinyInteger('active')->default(0)->after('status');
            $table->string('hash_activate')->nullable()->after('active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('group_id');
		});
	}

}
