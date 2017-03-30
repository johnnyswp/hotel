<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	
	    $cookie_lang = Cookie::get('language');
	    $browser_lang = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
	   	if(!empty($cookie_lang) AND in_array($cookie_lang, Config::get('app.languages')))
	    {
	        App::setLocale($cookie_lang);
	    }
	    else if(!empty($browser_lang) AND in_array($browser_lang, Config::get('app.languages')))
	    {
	        if($browser_lang != $cookie_lang)
	        {
	            Cookie::forever('language',$browser_lang);
	            Session::put('language', $browser_lang);
	        }
	        App::setLocale($browser_lang);
	    }
	    else
	    {
	        App::setLocale(Config::get('app.locale'));
	    }
});


App::after(function($request, $response)
{
	$lang = Session::get('language');
	if(!empty($lang))
	{
	    $response->withCookie(Cookie::forever('language',$lang));
	}
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Sentry::check()){ 
		return Redirect::guest('/');
	}else{
		$user = Sentry::getUser();    
		if($user->id==1){
		}else{
			$hotel = Hotel::find($user->hotel_id);
			date_default_timezone_set($hotel->timezone);
		}
	}
});

// Route::filter('auth', function()
// {
// 	if (Auth::guest()) return Redirect::guest('login');
// });

Route::filter('admin', function()
{
	$user = Sentry::getUser();
    $admin = Sentry::findGroupByName('Admins');

    if (!$user->inGroup($admin))
    {
    	return Redirect::to('/');
    }
});

Route::filter('hotels', function()
{
	$user = Sentry::getUser();
    $receptionists = Sentry::findGroupByName('Hotels');

    if (!$user->inGroup($receptionists))
    {
    	return Redirect::to('/');
    }
});

/*Route::filter('receptionists', function()
{
	$user = Sentry::getUser();
    $receptionists = Sentry::findGroupByName('Receptionists');

    if (!$user->inGroup($receptionists))
    {
    	return Redirect::to('login');
    }
});*/

/*Route::filter('chefs', function()
{
	$user = Sentry::getUser();
    $cocina = Sentry::findGroupByName('Chefs');

    if (!$user->inGroup($cocina))
    {
    	return Redirect::to('login');
    }
});*/


Route::filter('roomers', function()
{
	
	$token = Session::get('token_stay');
	 
    if ($token==null) {
    		return   View::make('404');
    }
    
    $stay = Stay::find(Session::get('token_stay'));
    $hotel = Hotel::find($stay->hotel_id);
   	date_default_timezone_set($hotel->timezone);
    
    if($stay->state =="check-out")
    {
    	Session::flush();
    	return   View::make('404');
    }else if($stay->closing_date < date('Y-m-d')){
    	Session::flush();
    	return   View::make('404');    
    }

});

 


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
0 = recep y cocina
1 = recep
2 = cocina
3 = admin Hotel
*/

Route::filter('guest', function()
{
	if (Sentry::check())
	{		
		$user         = Sentry::getUser();
		$admin        = Sentry::findGroupByName('Admins');
		$hotel       = Sentry::findGroupByName('Hotels');
		//$receptionist = Sentry::findGroupByName('Receptionists');
		//$company      = Sentry::findGroupByName('Chefs');

	    if ($user->inGroup($admin)) 
	    {
	    	return Redirect::intended('admin');
	    }
	    else 
	    {
	    	return Redirect::intended('/hotel');
	    }
	    #elseif ($user->inGroup($receptionist)) return Redirect::intended('/receptionist');
	    #elseif ($user->inGroup($company)) return Redirect::intended('/chefss');
	     

	}
});

// Route::filter('guest', function()
// {
// 	if (Auth::check()) return Redirect::to('/');
// });

Route::filter('redirectAdmin', function()
{
	if (Sentry::check())
	{
		$user = Sentry::getUser();
	    $admin = Sentry::findGroupByName('Admins');

	    if ($user->inGroup($admin)) return Redirect::intended('admin');
	}
});

Route::filter('redirectChefs', function()
{
	if (Sentry::check())
	{
		$user = Sentry::getUser();
	    $company = Sentry::findGroupByName('Chefs');

	    if ($user->inGroup($company)) return Redirect::intended('chefss');
	}
});



Route::filter('currentUser', function($route)
{

    if (!Sentry::check()) return Redirect::home();

    if (Sentry::getUser()->id != $route->parameter('profiles'))
    {
        return Redirect::home();
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
