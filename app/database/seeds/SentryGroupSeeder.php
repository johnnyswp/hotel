<?php

class SentryGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('groups')->delete();	 

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Roomers',
	        ));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Receptionists',
	        ));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Chefs',
	        ));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Hotels',
	        ));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'Admins',
	        ));
	}

}