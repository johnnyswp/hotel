<?php

class SentryUserGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_groups')->delete();

		$userUser          = Sentry::getUserProvider()->findByLogin('user@skywebplus.com');
		$hotelUser         = Sentry::getUserProvider()->findByLogin('hotel@skywebplus.com');
		$cocinaUser        = Sentry::getUserProvider()->findByLogin('cocina@skywebplus.com');
		$recepcionistaUser = Sentry::getUserProvider()->findByLogin('recepcionista@skywebplus.com');
		$adminUser         = Sentry::getUserProvider()->findByLogin('admin@skywebplus.com');

		$userGroup          = Sentry::getGroupProvider()->findByName('Roomers');
		$cocinaGroup        = Sentry::getGroupProvider()->findByName('Chefs');
		$recepcionistaGroup = Sentry::getGroupProvider()->findByName('Receptionists');
		$hotelGroup         = Sentry::getGroupProvider()->findByName('Hotels');
		$adminGroup         = Sentry::getGroupProvider()->findByName('Admins');

	    // Assign the groups to the users
	    $userUser->addGroup($userGroup);
	    $hotelUser->addGroup($hotelGroup);
	    $cocinaUser->addGroup($cocinaGroup);
	    $recepcionistaUser->addGroup($recepcionistaGroup);
	    $adminUser->addGroup($adminGroup);
	}

}