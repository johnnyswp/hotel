<?php

use basicAuth\Repo\UserRepositoryInterface;
use basicAuth\formValidation\RegistrationForm;
use Carbon\Carbon; 
class RegistrationController extends \BaseController {

	/**
	 * @var $user
	 */
	protected $user;

	/**
	 * @var RegistrationForm
	 */
	private $registrationForm;

	function __construct(UserRepositoryInterface $user, RegistrationForm $registrationForm)
	{
		$this->user = $user;
		$this->registrationForm = $registrationForm;
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($code)
	{
        $plan = Plan::where('code', $code)->first();
        if(!$plan)
            return View::make('404');

        $languages = Language::where('state', 1)->get();
        $langs = array(''=>trans('main.select a language'));
        foreach ($languages as $language) {
            $langs[$language->id] = $language->language;
        }
        
        $exchanges = Exchanges::where('state', 1)->get();
        $divisas = array(''=>trans('main.select a exchanges'));
        foreach ($exchanges as $exchange) {
            $divisas[$exchange->id] = $exchange->symbol." ".$exchange->name;
        }

        $countrys = Country::orderBy('name', 'ASC')->get();
        $countries = array(''=>trans('main.seleccione un pais'));
        foreach ($countrys as $country) {
           $countries[$country->id] = $country->name;
        }

		return View::make('frontend.registration.create')->with(array('countries'=>$countries, 'divisas'=>$divisas, 'langs'=>$langs, 'code'=>$plan->id));
	}
    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $plan = Plan::where('id', Input::get('code'))->first();
        if(!$plan)
            return Redirect::back()->withInput();

		$input = Input::only('email', 'password', 'password_confirmation', 'first_name', 'last_name', 'country_id', 'country', 'username', 'hotel_name', 'infoemail', 'city', 'address_hotel', 'lang', 'exchange_id', 'picture');

		$this->registrationForm->validate($input);
        
		$input = Input::only('email', 'password', 'first_name', 'last_name', 'username', 'position', 'birthday', 'country_id', 'phone');
        $input['type_user'] = 3;
		$user = $this->user->create($input);

		$code_activation =  $user->getActivationCode();

		// Find the group using the group name
    	$usersGroup = Sentry::findGroupByName('Hotels');

    	// Assign the group to the user
    	$user->addGroup($usersGroup);
    	/////////////REGISTER hOTEL//////////////
    	$hotel = new Hotel;
    	$hotel->name = Input::get('hotel_name');
    	$hotel->country_id = Input::get('country');
        $hotel->timezone = Input::get('timezone');
        $hotel->city = Input::get('city');
    	$hotel->user_id = $user->id;
    	$hotel->address = Input::get('address_hotel');
    	$hotel->infoemail = Input::get('infoemail');
        $hotel->web = Input::get('web');
        $hotel->theme = 1;

    	$hotel->inform_sms = 0;
    	$hotel->inform_email = 1;
    	$hotel->exchange_id = Input::get('exchange_id');
    	$hotel->list_times_as = 0;
    	$hotel->limit_time = '00:00:00';

        if(Input::file('logo')!=NULL)
        {
            //agrega imagen de logo
            $file_logo=Input::file('logo');
            $ext = Input::file('logo')->getClientOriginalExtension();
            $nameIMG=date('YmdHis');
            $logo= $user->id.$nameIMG.'.'.$ext;
            $logo= url().'/assets/pictures_hotels/PIC'.$logo;
            $file_logo->move("assets/pictures_hotels/",$logo); 
            $hotel->logo = $logo;
        }else{
            $hotel->logo = url('/assets/img/no-image.png');
        }

    	$hotel->save();

        $user->hotel_id = $hotel->id;
        $user->save();

        $language = new LanguageHotel;
        $language->language_id = Input::get('lang');
        $language->hotel_id = $hotel->id;
        $language->main = 1;
        $language->state = 1;
        $language->save();
                        
        $payment = new Payment;
        $payment->user_id   =   $user->id;
        $payment->plan_id   =   Input::get('code');
        $payment->paid      =   1;
        $payment->time      =   $plan->time_test;
        $payment->price     =   0;
        $payment->save();

        $payment = new Userpayment;
        $payment->user_id   =   $user->id;
        $payment->plan_id   =   Input::get('code');
        $payment->time      =   $plan->time_test;
        $payment->price     =   0;
        $payment->paid      =   1;
        $payment->save();

        $sector = new Sector;
        $sector->hotel_id = $hotel->id;
        $sector->name = "Default";
        $sector->save();

        $subject = trans('main.activation').' | easyroomservices.com';
        $name  = $user->first_name;
        $email = $user->email;

    	$data = array(
	       'id'   => $user->id,
	       'name' => $user->first_name." ".$user->last_name,
	       'code' => $code_activation
	    );

	    Mail::send('emails.activate',  $data, function($message) use ($name, $email, $subject)
	    {
	        $message->to($email, $name);
	        $message->subject($subject);
	    });


		return Redirect::to('register-finish')->withEmail($user->email);
	}

    public function finish()
    {
    	return View::make('frontend.registration.mgs_register');
    }

    public function activate($id, $code)
    {
        try
        {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Attempt to activate the user
            if ($user->attemptActivation($code))
            {
                // User activation passed
                return View::make('frontend.registration.mgs_activation')->with('flash_message',trans('main.His record was successfully prosecuted Now you sign in our app, thank you very much'));
            }
            else
            {
                // User activation failed
                return View::make('frontend.registration.mgs_activation')->withErrors(trans('main.Activation Error'));

            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
           
             return View::make('frontend.registration.mgs_activation')->withErrors(trans('main.User was not found'));
        }
        catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
        {
             return View::make('frontend.registration.mgs_activation')->withErrors(trans('main.User is already activated'));
        }
    }
}