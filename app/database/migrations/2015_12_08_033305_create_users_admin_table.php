<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersAdminTable extends Migration {

	public function up()
	{
		Schema::create('users_admin', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->integer('language_id');
			$table->integer('city_id');
			$table->string('last_name', 50);
			$table->string('password', 50);
			$table->string('first_name', 50);
			$table->string('email', 50);
			$table->string('phone', 45);
			$table->string('state', 45);
			$table->string('position', 45);
			$table->date('birthdate');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users_admin');
	}
}