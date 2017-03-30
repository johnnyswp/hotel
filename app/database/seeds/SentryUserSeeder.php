<?php

class SentryUserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 * @return void
	 * 
	 */
	public function run()
	{
		
		DB::table('users')->delete();

		Sentry::getUserProvider()->create(array(
	        'email'    => 'user@skywebplus.com',
	        'password' => '123',
	        'first_name' => 'Jonh',
	        'last_name' => 'Smith',
	        'username' => 'user10',
	        'activated' => 1,	        
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'hotel@skywebplus.com',
	        'password' => '123',
	        'first_name' => 'Raul',
	        'last_name' => 'Gonzalo',
	        'username' => 'hotel10',	        
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'recepcionista@skywebplus.com',
	        'password' => '123',
	        'first_name' => 'Sandra',
	        'last_name' => 'Lopez',
	        'username' => 'recepcionista10',	        
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'cocina@skywebplus.com',
	        'password' => '123',
	        'first_name' => 'Frank',
	        'last_name' => 'Castro',
	        'username' => 'cocina10',	        
	        'activated' => 1,
	    ));

		Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@skywebplus.com',
	        'password' => '123',
	        'first_name' => 'Rolando',
	        'last_name' => 'Arias',
	        'activated' => 1,
	        'username' => 'admin'
	    ));

	    
	}

}