<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersGroupsTable extends Migration {

	public function up()
	{
		Schema::create('users_groups', function(Blueprint $table) {
			$table->integer('user_id');
			$table->integer('group_id');
		});
	}

	public function down()
	{
		Schema::drop('users_groups');
	}
}