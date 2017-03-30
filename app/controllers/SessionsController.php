<?php

use basicAuth\formValidation\LoginForm;

class SessionsController extends \BaseController {

	protected $loginForm;

	function __construct(LoginForm $loginForm)
	{
		$this->loginForm = $loginForm;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (!Sentry::check())
        {
          return View::make('frontend.sessions.create');
        }
        else
        {
           
        }
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->loginForm->validate($input = Input::only('email', 'password'));
		
		$email = Input::get('email');
        if(str_contains($email, '@'))
        {
            Cartalyst\Sentry\Users\Eloquent\User::setLoginAttributeName('email');
            $input = array(
                'email'    => Input::get('email'),
                'password' => Input::get('password')
            );
        }
        else
        {
            Cartalyst\Sentry\Users\Eloquent\User::setLoginAttributeName('username');
            $input = array(
                'username' => Input::get('email'),
                'password' => Input::get('password')
            );

        }

		try
		{
			Sentry::authenticate($input,true);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		   	 
		   	$mjs = array(
		    	'success'=>false,
		    	'mgs'=>trans('main.mgs_invalid_credential'),
		    	'url'=>''
		    );
	    	return Response::json($mjs);
		}
		catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{		   	
	   		$mjs = array(
		    	'success'=>false,
		    	'mgs'=>trans('main.user_not_activated'),
		    	'url'=>''
		    );
	    	return Response::json($mjs);
		}
		catch(\Cartalyst\Sentry\Throttling\UserSuspendedException $e) 
		{
			$mjs = array(
		    	'success'=>false,
		    	'mgs'=>trans('main.user_suspended'),
		    	'url'=>''
		    );
	    	return Response::json($mjs);
		}

		// Logged in successfully - redirect based on type of user
		$user = Sentry::getUser();
	    $admin = Sentry::findGroupByName('Admins');
	    $hotel = Sentry::findGroupByName('Hotels');
	    
	    if ($user->inGroup($admin)){
	    	 $mjs = array(
		    	'success'=>true,
		    	'mgs'=>trans('main.mgs_access'),
		    	'url'=>url().'/admin'
		    );
	    	 return Response::json($mjs);	    	
	    }
	    elseif ($user->inGroup($hotel)){ 
	    	if($user->type_user==2){
	    		$mjs = array(
		        	'success'=>true,
		        	'mgs'=>trans('main.mgs_access'),
		        	'url'=>url().'/chef'
		        );
	    	}else{
	    		$mjs = array(
		        	'success'=>true,
		        	'mgs'=>trans('main.mgs_access'),
		        	'url'=>url().'/hotel'
		        );
	    	}
	    	 
	    	 return Response::json($mjs);
	    }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id=null)
	{
		Sentry::logout();

		return Redirect::home();
	}

}