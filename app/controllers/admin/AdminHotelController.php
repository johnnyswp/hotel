<?php
use Carbon\Carbon; 
class AdminHotelController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $hotels = Hotel::all();
        $plans = Plan::orderBy('price', 'ASC')->get();
        $plansmss = PlanSms::orderBy('price', 'ASC')->get();
		return View::make('admin.hotel.index')->with('hotels',$hotels)->withPlans($plans)->withPlansmss($plansmss);
	}

	public function create()
	{
		$lang = Helpers::lang();
		$countrys = Country::orderBy('name', 'ASC')->get();
        $countries = array();
        foreach ($countrys as $country) {
            $countries[$country->id] = $country->name;
        }

		$plans = Plan::orderBy('price', 'ASC')->lists('name', 'id');

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

		return View::make('admin.hotel.create')
			->withPlans($plans)
			->withCountries($countries)
			->withLangs($langs)
			->withDivisas($divisas);
	}

	public function store()
	{
		$data = array(
		 	//data person
	           "plan_id"    =>  Input::get("plan_id"),            
	           "cad"        =>  Input::get("cad"),            
	           "price"      =>  Input::get("price"),   
	           "first_name" =>  Input::get("first_name"),            
	           "last_name"  =>  Input::get("last_name"),            
	           "email"      =>  Input::get("email"),   
	           "password"   =>  Input::get("password"),            
	           "username"   =>  Input::get("username"),            
	           "hotel_name" =>  Input::get("hotel_name"),   
	           "city"       =>  Input::get("city"),            
	           "lang"       =>  Input::get("lang"),            
	           "exchange_id"=>  Input::get("email"),   

	    );
	
		$rules = array(
	        'email'      => 'required|email|unique:users',
	        'username'   => 'required|unique:users',
	        'password'   => 'confirmed|min:4',
	        'cad'        => 'required',
	        'price'      => 'required',
	        'plan_id'    => 'required',
	        'first_name' => 'required',
	        'last_name'  => 'required',
	        'last_name'  => 'required',
	        'hotel_name' => 'required',
	        'city'       => 'required',
	        'lang'       => 'required',
	        'exchange_id'=> 'required',
	    );
        

        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{ 
            $input = Input::only('email', 'password', 'first_name', 'last_name', 'username', 'position', 'birthday', 'country_id', 'phone');
            $input['type_user'] = 3;
            
            // Find the group using the group name           
            $user = Sentry::register($input);
		    		    
		    $code_activation =  $user->getActivationCode();	
			
            $usersGroup = Sentry::findGroupByName('Hotels');

            $user->addGroup($usersGroup);
    	    /////////////REGISTER hOTEL//////////////
    	    $hotel = new Hotel;
    	    $hotel->name = Input::get('hotel_name');
    	    $hotel->city_id = Input::get('city');
    	    $hotel->user_id = $user->id;
    	    $hotel->address = Input::get('address_hotel');
    	    $hotel->web = Input::get('web');
    
    	    $hotel->inform_sms = 0;
    	    $hotel->inform_email = 1;
    	    $hotel->exchange_id = Input::get('exchange_id');
    	    $hotel->list_times_as = 0;
    	    $hotel->limit_time = Input::get('hours');
    
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
    
            $language = new LanguageHotel;
            $language->language_id = Input::get('lang');
            $language->hotel_id = $hotel->id;
            $language->main = 1;
            $language->state = 1;
            $language->save();

            $dtNow = Carbon::now();
            $dtCad = Carbon::parse(Input::get('cad'));
            $days  = $dtCad->diffInDays($dtNow);

            $payment = new Payment;
            $payment->user_id 	=	$user->id;
            $payment->plan_id	= 	Input::get('plan_id');
            $payment->paid		= 	1;
            $payment->time	    = 	$days;
            $payment->price		= 	Input::get('price');
            $payment->save();


            $payment = new Userpayment;
            $payment->user_id 	=	$user->id;
            $payment->plan_id	= 	Input::get('plan_id');
            $payment->time	    = 	$days;
            $payment->price		= 	Input::get('price');
            $payment->paid		= 	1;
            $payment->save();

    
    	    $subject = 'Activacion | easyroomservices.com';
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

            return Redirect::to('admin/hotels')->with('flash_message', 'Agregado con exito');
        }
	}

	public function show($id)
	{
		    $hotel = Hotel::find($id);
            $user_id =  $hotel->user_id;
            $user = User::find($user_id);
            if($user){
                $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                $payment = Payment::where('user_id', $user_id)->first();
                $plan = Plan::find($payment->plan_id);
                
                return Response::json(array(
                  'success'  => true,
                  'name'     => $user->getFullName(),
                  'email'    => $user->email,
                  'username' => $user->username,
                  'img'      => $hotel->logo,
                  'phone'    => $user->phone,
                  'lang'     => $lang->language->language,
                  'date'     => $user->date,
                  //////BUSSINE///////////////
                  'hotel'    => $hotel->name,
                  'phone1'   => $hotel->phone,
                  'plan'     => $plan->name,
                ));
            }else{
            	return Response::json(array(
                  'success'  => false
                ));
            }

	}
}  