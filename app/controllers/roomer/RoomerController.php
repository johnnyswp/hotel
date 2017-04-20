<?php
use Carbon\Carbon;
$stay = Stay::find(Session::get('token_stay'));
if($stay){
	$hotel = Hotel::find($stay->hotel_id);
	date_default_timezone_set($hotel->timezone);  	
}


class RoomerController extends \BaseController {
	/**
	* 	Display a listing of the resource.
	*
	*	@return Response	 
	*	 
	**/
	public function __construct()
    {
        $this->beforeFilter('roomers', array('only' =>  array('getCatalog','getCatalog','getIndex','getCategory','getItem','anyOrder','anyOrderRoomer'))); 
    }

	public function postKey($type=true)
	{
		$key = Input::get('key');
		if($type){
			return  Crypt::encrypt($key);
		}else{
			return Crypt::decrypt($key);
		}
	}

	public function getLogin($link,$lang)
	{
        $lang = Language::where('sufijo',$lang)->first();
        if(!$lang){
             return   View::make('404');
        }
        $hotel = Hotel::where('link',$link)->first();
        if(!$hotel)
        {
        	return   View::make('404');
        }
        $phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$hotel)
				   	->where('name_phones.language_id','=',$lang)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		$template = $hotel->theme;
		return View::make("roomers.themes.$template.welcome-login")->withPhones($phones)->withHotel($hotel)->withLang($lang);
	}

	public function postCheckLogin()
	{
		$rules  = ['username' => 'required|min:3', 'token' => 'required|min:5',];		
		$inputs = ['token' => Input::get('token'), 'username' => Input::get('username')];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		else
		{
			$token_ = Input::get('token');
			
			$lang = Input::get('lang');
			
			$stay=Stay::where('hotel_id',Input::get('hotel'))->where('username',Input::get('username'))->orderBy('id', 'DESC')->first();
			if(!$stay){
				Session::flash('mgs', Language::find($lang)->txt_datos_invalidos);
				return Redirect::back();
			}

			$token = $stay->token;
			
			#Comprobar si el token existe o no
			if($token==$token_){
				#mandar a Catalogo
				#creando las sessiones
					Session::put('lang_id', $lang);
					Session::put('hotel_id', $stay->hotel_id);
					Session::put('token_stay', $stay->id);
				$hotel = Hotel::find($stay->hotel_id);
				  return Redirect::to('roomer/')
				->withHotel($hotel)
				->withStay($stay);
			}else{
				Session::flash('mgspass', Language::find($lang)->txt_token_invalido);
				return Redirect::back();
			}
		}
	}

	public function getLoginLink($link,$lang)
	{
		$lang = Language::where('sufijo',$lang)->first();
        if(!$lang){
				Session::flash('mgs', 'main.Language no valido');
	            return View::make('error'); 
        }
        $hotel = Hotel::where('link',$link)->first();
        if(!$hotel)
        {
        	return   View::make('404');
        }
		$rules  = ['username' => 'required|min:3','password' => 'required|min:5'];		
		$inputs = ['token' => Input::get('password'), 'username' => Input::get('username')];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			#return Redirect::back()->withErrors($validator)->withInput();
			return View::make('error')->withErrors($validator);
		}
		else
		{
			$token_ = Input::get('password');
			
			 
			$stay=Stay::where('hotel_id',$hotel->id)->where('username',Input::get('username'))->orderBy('id', 'DESC')->first();
			if(!$stay){
				Session::flash('mgs', Language::find($lang->id)->txt_datos_invalidos);
				#return Redirect::back();
				return View::make('error');
			}

			$token = $stay->token;
			
			#Comprobar si el token existe o no
			if($token==$token_){
				#mandar a Catalogo
				#creando las sessiones
					Session::put('lang_id', $lang->id);
					Session::put('hotel_id', $stay->hotel_id);
					Session::put('token_stay', $stay->id);
				$hotel = Hotel::find($stay->hotel_id);
				  return Redirect::to('roomer/seleccion')
				->withHotel($hotel)
				->withStay($stay);
			}else{
				Session::flash('mgspass', Language::find($lang)->txt_token_invalido);
				#return Redirect::back();
				return View::make('error');
			}
		}
	}


	public function getMake($tet)
	{
		$sesion_stay_id = Session::get('token_stay');
		
		list($token,$stay_id)=explode('-',$tet);

		$stay=Stay::where('id',$stay_id)->where('state','Pending')->first();
 		
 		if($stay){

	 		if ($sesion_stay_id!=null) 
	 		{
	 			if($sesion_stay_id==$stay->id)
	 			{
	 				return Redirect::to('roomer/'); 
	 			}
	 			else
	 			{
	 				$stay->id. " Ok ".Session::get('token_stay');
	 				Session::flush();
	 			}
	 		}
	 		else
	 		{
	 			if($stay->id!=$stay_id)
	 			{
	 				Session::flush();
	 			}
	 		}
		}
		else
		{
			return View::make('stay-out');
		}

		$lang = Input::get('lang');

		
		if($stay){
			/* Validar Fecha de caducidad y languaje */
			if(Carbon::now() >=Carbon::parse($stay->finished_token)){				
				return View::make('stay-out');
			}

			if($stay)
			{
				$stay_token =  hash('sha256',$stay->token);
				if($token==$stay_token){
					$hotel = Hotel::find($stay->hotel_id);
					$lang = Language::find($lang);
					$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
					
					$template = $hotel->theme;

					return View::make("roomers.themes.$template.welcome")
					->withHotel($hotel)
					->withLang($lang)
					->withMax(1)
					->withPhones($phones)
					->withStay($stay);
				}
				else
				{
					return View::make('stay-out');
				}
			}
			else
			{
				return View::make('stay-out');
			}
		}else{
			return View::make('stay-out');
		}
	}
	
	public function postCheckToken()
	{
		$rules = ['token'       => 'required|min:5', ];
		
		$inputs = ['token'        => Input::get('token') ];
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		else
		{
			$token_ = Input::get('token');
			
			$stay_id = Input::get('stay_id');

			$lang = Input::get('lang');
			
			$stay=Stay::find($stay_id);

			$token = $stay->token;
			
			#Comprobar si el token existe o no
			if($token==$token_){
				#mandar a Catalogo
				#creando las sessiones
					Session::put('lang_id', $lang);
					Session::put('hotel_id', $stay->hotel_id);
					Session::put('token_stay', $stay->id);
				$hotel = Hotel::find($stay->hotel_id);
				  return Redirect::to('roomer/seleccion')
				->withHotel($hotel)
				->withStay($stay);
			}else{
				Session::flash('mgs', trans('main.Token Invalido'));
				return Redirect::back();
			}
		}
	}

	public function postTypePedido()
	{
		$type = Input::get('type');
	}

	public function getIndex()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);

		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		$lang = Language::find($lang_id);
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);			
		 
		 
		//Dia del cheking
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.home")
			->withHotel($hotel)
			->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withLang($lang)
			->withMax($max)
			->withStay($stay);
	}

	public function getSeleccion()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);

		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		$lang = Language::find($lang_id);
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);			
		 
		 
		//Dia del cheking
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.home_firts")
			->withHotel($hotel)
			->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withLang($lang)
			->withMax($max)
			->withStay($stay);
	}

	public function getServicios()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$services = Service::where('hotel_id',$stay->hotel_id)->orderBy('Serviceorder','ASC')->get();
	 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.info_servicios")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withServices($services);			
	}	

	public function getServiciosList($id)
	{

		$service_id =$id;
	 
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$business = Business::where('hotel_id',$stay->hotel_id)->where('service_id',$service_id)->orderBy('businessOrder','ASC')->get();
		 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.list_servicios")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withBusiness($business);			
	}

	public function getServicioItem($id)
	{

		$service_id =$id;
	 
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$business = Business::find($service_id);
	 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.item_servicios")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withBusiness($business);			
	}

	public function getProductoItem($id)
	{

		$service_id =$id;
	 
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$business = Menu::where('business_id',$service_id)->orderBy('menuOrder','ASC')->get();
		 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.item_producto")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withProductos($business);			
	}

	public function getActividades()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		 
		#Actividades Repetibles
		$day=Input::get('day');
		
		
		$hoy = Carbon::today();		
		if ($day > 0)
		{
		 $type="more";
		}else{
			$type="less";
		}

		$myday=$day+1;
	 
		if($day=="0"){
		   	$num = 		$hoy->dayOfWeek;
			$fechita = 	$hoy->format("d-m-Y");
			   
		}else{
			 if($type=="more"){
				$ahoy = $hoy->addDays($day);
				$num = $ahoy->dayOfWeek;	
				$fechita = 	$ahoy->format("d-m-Y");							 
			 }else{
				$ahoy = $hoy->subDays($day);
				$num = $ahoy->dayOfWeek;
				$fechita = 	$ahoy->format("d-m-Y");							 
			 }
		}

		$like = '%'.$num.'%';		
		
		$actRep = DB::table('activity')
            ->where('type', '=', 1)
            ->where('hotel_id', '=',$hotel->id)
            ->where('state', '=',1)
            ->where('daysActivity', 'like', $like)
			->lists('id');
        
		#Actividades NO Repetibles		
		$actNoRep = DB::table('activity')
            ->where('type', '=',0)
            ->where('hotel_id', '=',$hotel->id)
            ->where('state', '=',1)      
            ->where('daysActivity', '=',$fechita)			      
			->lists('id');
		
		

		$allArray=array_merge($actRep,$actNoRep);

		$AllActivities = 	DB::table('activity')
                    ->whereIn('id',$allArray)->orderBy(DB::raw('HOUR(since)'))->get();

		#dd($fechita,$num,$allArray,$rauls);

		$vacio = false;
		if(!$AllActivities){
			$vacio = true;
		}
		$today = Carbon::today();
		
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 
		$services = Service::where('hotel_id',$stay->hotel_id)->orderBy('Serviceorder','ASC')->get();
	 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.list_actividades")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withMyday($myday)
			#->withMyday2($myday2)
			->withVacio($vacio)
			->withActividades($AllActivities);			
	}


	public function getInfoList()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$services = InfoPlace::where('hotel_id',$stay->hotel_id)->orderBy('infoOrder','ASC')->get();
	 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.list_info")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withInfos($services);			
	}	

	public function getInfolistItem($id)
	{

		$service_id =$id;
	 
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);
		$lang = Language::find($lang_id);
		 
		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$today = Carbon::today();
		$stay_token = Carbon::parse($stay->closing_date);		 
	 
		if($stay_token == $today){			
			$max = "true";
		}else{
			$max = 1;	
		}
		 

		$business = InfoPlace::find($service_id);
	 
		$template = $hotel->theme; 
		
		return View::make("roomers.themes.$template.item_info")
			->withHotel($hotel)
			 ->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withMax($max) 
			->withStay($stay)
			->withLang($lang)
			->withBusiness($business);			
	}

	public function getCatalog()
	{
		$stay = Stay::find(Session::get('token_stay'));

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');
		
		$hotel = Hotel::find($stay->hotel_id);

		$categories = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->get();
		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		$lang = Language::find($lang_id);
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		
		$template = $hotel->theme;

		return View::make("roomers.themes.$template.catalog")
			->withHotel($hotel)
			->withExchange($exchange)
			->withCategories($categories)
			->withPhones($phones)
			->withLang($lang)
			->withMax(0)			
			->withStay($stay);
	}

	public function getCategory($category_id)
	{
		$key = Input::get('dt');
		if($key){
			 $datetime = Crypt::decrypt($key);
			 $time = Carbon::parse($datetime)->toDateString();
			 $aa = Carbon::parse($datetime)->toTimeString();
			 $day = Carbon::parse($datetime)->dayOfWeek;
			   
		}else{
			$dt = Carbon::now();
			$day=$dt->dayOfWeek; 
			$hr = $dt->toTimeString();			
			$aa=date("H:i:s", time());
		}

		$stay = Stay::find(Session::get('token_stay'));
		
		$hotel = Hotel::find($stay->hotel_id);

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');		
		
		$category = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('category_menu.id','=',$category_id)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->first();
		
		  
		$items = DB::table('items_name')
				   	->Join('name_items_menu', 'name_items_menu.item_id', '=', 'items_name.id')
				   	->Join('category_menu', 'category_menu.id', '=', 'items_name.category_id')
				   	->where('items_name.hotel_id','=',$stay->hotel_id)
				   	->where('items_name.state', 1)
				   	->where('category_menu.state','=',1)
				   	->where('category_menu.id','=',$category_id)
				   	->where('name_items_menu.language_id','=',$lang_id)
				   	->select('items_name.id as item_id',
					   		'name_items_menu.name as item_name',
					   		'name_items_menu.description as item_description',
					   		'items_name.picture as item_picture',
					   		'items_name.delivery_time as item_time',
					   		'items_name.price as item_price',
					   		'items_name.type_of_schedule as is_avaible',
					   		'items_name.delivery_time as item_time')
 					->orderBy('items_name.order','ASC')
				   	->get();
		$elemets = array();
		$x = 0;
	   	 
	    
		 
			foreach($items as $item) {
				if($item->is_avaible=='1')
				{
					$avalible = Available::where('item_id', $item->item_id)
		            	                  ->where('weekday',$day)				   	
							  	          ->where('desde_1','<=',$aa)
						  		          ->where('hasta_1','>=',$aa)
				                	      ->first();
					$avalible2 = Available::where('item_id', $item->item_id)
		            	                  ->where('weekday',$day)				   	
							  	          ->where('desde_2','<=',$aa)
						  		          ->where('hasta_2','>=',$aa)
				                	      ->first();
				}
				else
				{
					$avalible = Schedule::where('hotel_id', $stay->hotel_id)
		            	                  ->where('weekday',$day)				   	
							  	          ->where('desde_1','<=',$aa)
						  		          ->where('hasta_1','>=',$aa)
				                	      ->first();
					$avalible2 = Schedule::where('hotel_id', $stay->hotel_id)
		            	                  ->where('weekday',$day)				   	
							  	          ->where('desde_2','<=',$aa)
						  		          ->where('hasta_2','>=',$aa)
				                	      ->first();
				}
				if($avalible or $avalible2){
		            $elemets[$x] = $item->item_id;
		            $x++;
				}
			}
	      
	    /*$g=array();
	    foreach ($elemets as $val) {
	     	array_push($g, $val->item_id);
	    }*/
	    $items_elements =  array();
	    $re=0;	  
	    foreach($items as $item) {
	    	$new = array();
	    	$new['item_id'] = $item->item_id;
	    	$new['item_name'] = $item->item_name;
	    	$new['item_description'] = $item->item_description;
	    	$new['item_picture'] = $item->item_picture;
	    	$new['item_time'] = $item->item_time;
	    	$new['item_price'] = $item->item_price;
	    	$new['item_time'] = $item->item_time;


	    	if(in_array($item->item_id,$elemets)){
	    		 $new['item_available'] =  true;
	    	}else{
	    		$new['item_available'] =  false;	    		
	    	}
	    	$items_elements[$re] = (object) $new;

	    	$re++;
	    }
	    
	    
		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();	

		$lang = Language::find($lang_id);

		$exchange = Exchanges::find($hotel->exchange_id)->symbol;
		
		$template = $hotel->theme;

		return View::make("roomers.themes.$template.category")
			->withHotel($hotel)
			->withCategory($category)
			->withItems($items_elements)
			->withPhones($phones)
			->withLang($lang)
			->withMax(0)			
			->withExchange($exchange)
			->withStay($stay);
	}

	public function getItem($item_id)
	{
		$stay = Stay::find(Session::get('token_stay'));
		$item_available= Input::get('a');
		$hotel = Hotel::find($stay->hotel_id);

		#$lang_id = LanguageHotel::find(Session::get('lang_id'))->language_id;
		$lang_id = Session::get('lang_id');	

		/*$category = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('category_menu.id','=',$category_id)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->first();*/

		$item = DB::table('items_name')
				   	->Join('name_items_menu', 'name_items_menu.item_id', '=', 'items_name.id')
				   	->Join('category_menu', 'category_menu.id', '=', 'items_name.category_id')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')				   	
				   	->where('items_name.hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('name_items_menu.item_id','=',$item_id)
				   	->where('name_items_menu.language_id','=',$lang_id)
				   	->select('items_name.id as item_id',
					   		'name_items_menu.name as item_name',
					   		'name_items_menu.description as item_description',
					   		'items_name.picture as item_picture',
					   		'items_name.delivery_time as item_time',
					   		'items_name.price as item_price',
					   		'items_name.category_id as category_id',
					   		'items_name.delivery_time as item_time')
 					->orderBy('items_name.order','ASC')
				   	->first();
		
		$category = DB::table('category_menu')
				   	->Join('names_category_menu', 'names_category_menu.category_menu_id', '=', 'category_menu.id')
				   	->where('hotel_id','=',$stay->hotel_id)
				   	->where('category_menu.state','=',1)
				   	->where('category_menu.id','=',$item->category_id)
				   	->where('language_id','=',$lang_id)
				   	->select('category_menu.id as category_id',
					   		'names_category_menu.name as category_name',
					   		'category_menu.picture as category_picture')
 					->orderBy('category_menu.order','ASC')
				   	->first();

		$phones =  DB::table('phones')
				   	->Join('name_phones', 'name_phones.phone_id', '=', 'phones.id')
				   	->where('phones.hotel_id','=',$stay->hotel_id)
				   	->where('name_phones.language_id','=',$lang_id)
				   	->where('phones.state','=',1)
				   	->select('name_phones.id as phones_id',
					   		'name_phones.name as phones_name',
					   		'phones.number as phones_number')
 					->orderBy('phones.order','ASC')
				   	->get();
		$lang = Language::find($lang_id);

		$exchange = Exchanges::find($hotel->exchange_id)->symbol;

		$template = $hotel->theme;

		return View::make("roomers.themes.$template.item")
			->withHotel($hotel)
			->withCategory($category)
			->withItem($item)
			->withPhones($phones)
			->withLang($lang)
			->withMax(0)		
			->withItem_available($item_available)	
			->withExchange($exchange)
			->withStay($stay);
	}

	public function getDelete()
	{
		Session::flush();
		return Redirect::to('roomers');
	}

	public function anyDeleteorder($id)
	{
		$o = Order::find($id);
		$o->state="cancel";
		$o->save();
	}
	public function getLang($id)
	{
		Session::forget('lang_id');
		Session::put('lang_id', $id);
		return Redirect::to(URL::previous());
	}

	public function postLang()
	{
		$id = Input::get('lang');
		Session::forget('lang_id');
		Session::put('lang_id', $id);
		return Redirect::to(URL::previous());
	}
	public function anyStayOut()
	{
		Session::flush();		
		return View::make('stay-out');
	}
	
	public function anyOrder()
	{
		$stay_ = Stay::find(Input::get('stay_id'));
    	$hotell = Hotel::find($stay_->hotel_id);
   		date_default_timezone_set($hotell->timezone);
		
		$j = Input::get('stay_id');
		$now= Carbon::now();

		#ver si la estadia esta activa
		$stay = Stay::find($j);
		$finesh = Carbon::parse($stay->finished_token);
		if($finesh < $now){
			return Response::json(['out'=>'ok']);
		}
		if($stay->state=="check-out")
		{
			return Response::json(['out'=>'ok']);

		}
		$id = Input::get('items');
		$today = Input::get('today');
		$orders = json_decode($id);
		
		$hotel_id = $stay->hotel_id;

		$r=array();
		
		 
		$timeUP = Carbon::parse(Input::get('timeH').":00");
		
		if($timeUP > $now){

		}else{
			foreach ($orders as $elem) {
				#Agregando Item
				$item = Item::find($elem->id);
				$type=$item->type_of_schedule;
				if($type==1){
					#Entonces Item tiene activado el horario standar
					$horarios = Available::where('item_id',$item->id)->orderBy('weekday')->get(['weekday','desde_1','hasta_1','desde_2','hasta_2']);			
					foreach ($horarios as $h) {
						$time = Carbon::now();
						$hora= $time->format('h:s');
						$dayN = $time->dayOfWeek;

						if($dayN==$h->weekday){	
							$d1 = Carbon::parse($today." ".$h->desde_1);
							$f1 = Carbon::parse($today." ".$h->hasta_1);

							$d2 = Carbon::parse($today." ".$h->desde_2);
							$f2 = Carbon::parse($today." ".$h->hasta_2);
	 
							if($time > $d1 && $time < $f1){
								 
							}else if ($time > $d2 && $time < $f2){
								
							}else{
								$r[]=$elem->id;
							}						
						}
					}
				}else{
					#tiene activado el horario de hotel
					$horarios = Schedule::where('hotel_id',$hotel_id)->orderBy('weekday')->get(['weekday','desde_1','hasta_1','desde_2','hasta_2']);
					foreach ($horarios as $h) {
						$time = Carbon::now();
						$hora= $time->format('h:s');
						$dayN = $time->dayOfWeek;

						if($dayN==$h->weekday){	
							$d1 = Carbon::parse($today." ".$h->desde_1);
							$f1 = Carbon::parse($today." ".$h->hasta_1);

							$d2 = Carbon::parse($today." ".$h->desde_2);
							$f2 = Carbon::parse($today." ".$h->hasta_2);
	 
							if($time > $d1 && $time < $f1){
								 
							}else if ($time > $d2 && $time < $f2){
								
							}else{
								$r[]=$elem->id;
							}						
						}
					}
				}
			}
			if(count($r) > 0){
				return Response::json($r);
			}	
		}
		 
 		
		 
		#Registrando  Orden
		$order = new Order;
		$order->stay_id = Input::get('stay_id');
		$order->hour_order = Helpers::datetime_mysql(Input::get('timeUp').":00");
		$order->state = "programmed";
		$order->preparation_time = Input::get('preparation_time');
		$order->delivery_time = Helpers::datetime_mysql(Input::get('time').":00");
		$order->save();		
		#Registrando Detalles de la Orden
		foreach ($orders as $elem) {
			#Agregando Item
			$item = new ItemOrder;
			$item->order_id = $order->id;
			$item->quantity = $elem->count;
			$item->price = $elem->price;
			$item->name_item_menu_id = $elem->id;
			$item->save();
		}

		return Response::json(['success'=>true]);
	}

	public function anyOrderRoomer($id,$lang_id)
	{
		$order = Order::find($id);
		$lang_id= Session::get('lang_id');
		$stay = Stay::find($order->stay_id);

		$hotel = Hotel::find($stay->hotel_id);

		$room = Room::find($stay->room_id)->number_room;

		$exchange = Exchanges::find($hotel->exchange_id);
		 
		$items =  DB::table('orders')
				   	->Join('items_order', 'items_order.order_id', '=', 'orders.id')
				   	->Join('items_name', 'items_name.id', '=', 'items_order.name_item_menu_id')
				   	->Join('name_items_menu', 'name_items_menu.item_id', '=', 'items_name.id')
				   	->where('items_order.order_id','=',$order->id)
				   	->where('name_items_menu.language_id','=',$lang_id)
				   	->select('name_items_menu.name as name',
					   		'items_order.id as id',
					   		'items_order.quantity as quantity',
					   		'items_name.picture as picture',
					   		'orders.preparation_time as time',
					   		'items_order.price as price')
 					->orderBy('items_order.id','ASC')
				   	->get();
		 
		$txt_items="";

		$total_price=0;

		$total_count =0;

		foreach ($items as $key) {

			if($txt_items=="")
			{
			 	$txt_items='{"id":'.$key->id.', "name":"'.$key->name.'", "picture":"'.$key->picture.'",  "cantidad":'.$key->quantity.', "precio":"'.$exchange->symbol.' '.$key->price.'"}';
			}
			else
			{	
			$txt_items = $txt_items.','.'{"id":'.$key->id.', "name":"'.$key->name.'", "picture":"'.$key->picture.'", "cantidad":'.$key->quantity.', "precio":"'.$exchange->symbol.' '.$key->price.'"}';
			}
			$total_price = $total_price+($key->price*$key->quantity);
			$total_count = $total_count+$key->quantity;
		}

		$txt_order = '{"id": '.$order->id.', "habitacion": '.$room.', "entrega": "'.$order->delivery_time.'", "estado":"'.$order->state.'", "total":"'.$exchange->symbol.''.$total_price.'","tiempo":"'.$key->time.'",  "items":['.$txt_items.']}';
			return $txt_order;
		/*
			{
			  "id": 3,
			  "habitacion": 5,
			  "entrega": "7-2-12 20:15",
			  "estado":"preparando",
			  "total":"$60",
			  "tiempo":"50m",
			  "items":[
			    {
			      "id":1,
			      "name":"Sopa de Res",
			      "cantidad":2,
			      "precio":"$5"
			    },
			    {
			     "id":1,
			      "name":"Sopa de Res",
			      "cantidad":2,
			      "precio":"$5"
			    },
			    {
			     "id":1,
			      "name":"Sopa de Res",
			      "cantidad":2,
			      "precio":"$5"
			    }
			  ]
			}
			
			{"id": 3, "habitacion": 5, "entrega": "7-2-12 20:15", "estado":"preparando", "total":"$60", "tiempo":"50m", "items":[{"id":1, "name":"Sopa de Res", "cantidad":2, "precio":"$5"}, {"id":1, "name":"Sopa de Res", "cantidad":2, "precio":"$5"}, {"id":1, "name":"Sopa de Res", "cantidad":2, "precio":"$5"} ] }
		*/
	}

	public function anyStayDateMax()
	{
		$stay_id=Input::get('stay_id');
		$dates=Input::get('date');
		#Retorna Array(true,mgs);
		$array = array();
		$stay = Stay::find($stay_id);
		$stay_token = Carbon::parse($stay->closing_date);
		$date= Carbon::parse($dates);
		list($hour,$min,$seg)=explode(':',$stay->end);
		if($min=='00') $min = 0;
		$today = Carbon::today();
		
		if($stay_token->isToday())
		{
			$hoy = true;
		}else
		{
			$hoy= false;
		}
		//Dia del cheking
		if($stay_token == $date){
			$array['tipo'] = "date_checkin_today";
			$array['hoy'] = $hoy;
			$array['hour'] = (int) $hour ;
			$array['min'] = (int) $min ;
		}else if($date  == $today )
		{
			$array['tipo'] = 'date_today';
			$array['hoy'] = true;
			$array['hour'] =(int) $hour ;
			$array['min'] =(int) $min ;
		}
		else if($date  > $stay_token )
		{
			$array['tipo'] = 'date_mayor';
		}
		else if($date  < $stay_token )
		{
			$array['tipo'] = 'date_menor';
		}else{
			$array['tipo'] = 'date_normal';			
		}
		return Response::json($array);
	}

	public function StayDateMaxCheckout()
	{
		$stay_id=Input::get('stay_id');
		$today = Carbon::today();
		$array = array();
		$stay = Stay::find($stay_id);
		$stay_token = Carbon::parse($stay->closing_date);			
		 
		//Dia del cheking
		if($stay_token == $today){
			$array['success'] = true;
			$array['max'] = true;
		}else{
				$array['success'] = true;
			$array['max'] = 1;	
		}
		return Response::json($array);
	}

	public function anyItemName($id)
	{
			$data = DB::table('name_items_menu')
				   	->where('name_items_menu.item_id','=',$id)
				   	->select('name_items_menu.name as name','name_items_menu.language_id as lang')
				   	->get();	
			$json = array();
			foreach ($data as $d) {
					$json[$d->lang]=$d->name;
				}	
			return Response::json($json);
	}

	public function anyItemHorario($item_id,$hotel_id)
	{
		#Validar si el item tiene horario standar o de hotel
		$item = Item::find($item_id);
		$type=$item->type_of_schedule;
		if($type==1){
			#Entonces Item tiene activado el horario standar
			$horarios = Available::where('item_id',$item->id)->orderBy('weekday')->get(['weekday','desde_1','hasta_1','desde_2','hasta_2']);			
			return Response::json($horarios);

		}else{
			#tiene activado el horario de hotel
			$horarios = Schedule::where('hotel_id',$hotel_id)->orderBy('weekday')->get(['weekday','desde_1','hasta_1','desde_2','hasta_2']);
			return Response::json($horarios);			
		}
	}

}
