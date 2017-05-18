<?php
class HotelController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		$user = User::find(Sentry::getUser()->id);
        return Redirect::to('receptionist/stays');
	}

	public function anyEdit(){
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

		$user = Sentry::getUser();
		$hotel = Hotel::where('user_id', $user->id)->first();

		$countrys = Country::orderBy('name', 'ASC')->get();
        $countries = array(''=>trans('main.seleccione un pais'));
        foreach ($countrys as $country) {
           $countries[$country->id] = $country->name;
        }

		$languages = LanguageHotel::where('hotel_id', $hotel->id)->get();
        $langs = array();
        foreach ($languages as $lang) {
            $l = Language::find($lang->language_id);
            if(Language::state($lang->id))
               $langs[$l->id] = $l->language;
        }
		$langmain = LanguageHotel::where('hotel_id', $hotel->id)->where('main', 1)->first();

        $exchanges = Exchanges::where('state', 1)->get();
        $divisas = array();
		foreach ($exchanges as $exchange) {
			$divisas[$exchange->id] = $exchange->symbol." ".$exchange->name;
		}

		return View::make('hotel.pages.edit_hotel')->withHotel($hotel)
		                                           ->withCountries($countries)
		                                           ->withLangs($langs)
                                                   ->withLangmain($langmain)
		                                           ->withExchanges($divisas);
	}

	public function anyUpdate()
	{
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

		$data = array(
            "name"          =>  Input::get("name"),
            "state"         =>  Input::get("state"),
            "country_id"    =>  Input::get("country_id"),
            "city"          =>  Input::get("city"),
            "address"       =>  Input::get("address"),
            "infoemail"     =>  Input::get("infoemail"),
            "web"           =>  Input::get("web"),
            "theme"         =>  Input::get("theme"),
            "language_id"   =>  Input::get("language_id"),
            "exchange_id"   =>  Input::get("exchange_id"),
            "type_login"    =>  Input::get("type_login"),
            "list_times_as" =>  Input::get("list_times_as"),
            "limit_time"    =>  Input::get("limit_time"),
            "logo"          =>  Input::file("logo")
        );
    
        $rules = array(
            "name"        =>  'required|min:1|max:25',
            "country_id"  =>  'required|min:1max:10',
            "city"        =>  'required|min:1max:10',
            "address"     =>  'required|min:1|max:25',
            "infoemail"   => 'required|email',
            "web"         =>  'min:1|max:50',
            "theme"       =>  'required|min:1|max:50',
            "type_login"       =>  'required|min:1|max:50',
            "language_id" =>  'required|min:1|max:100',
            "exchange_id" =>  'required|min:1|max:100',
            "logo"        =>  'mimes:jpeg,gif,png'
        );

        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $user = Sentry::getUser();
		    $hotel = Hotel::where('user_id', $user->id)->first();
    	    $hotel->name       = Input::get('name');
    	    $hotel->country_id = Input::get('country_id');
            $hotel->city       = Input::get('city');
    	    $hotel->address    = Input::get('address');
    	    $hotel->infoemail        = Input::get('infoemail');
            $hotel->web        = Input::get('web');
            $hotel->theme      = Input::get('theme');
            $hotel->type_login      = Input::get('type_login');

            $lang = LanguageHotel::where('hotel_id', $hotel->id)->where('main', 1)->first();
            if($lang)
            {
                $lang->main = 0;
                $lang->save();
            }

            $language = LanguageHotel::where('language_id', Input::get('language_id'))->where('hotel_id', $hotel->id)->first();
            if(!$language)
                $language = new LanguageHotel;

            $language->language_id = Input::get('language_id');
            $language->hotel_id = $hotel->id;
            $language->main = 1;
            $language->state = 1;
            $language->save();

    	    $hotel->inform_sms    = 0;
    	    $hotel->inform_email  = 1;
    	    $hotel->exchange_id   = Input::get('exchange_id');
    	    $hotel->list_times_as = 0;
    	    $hotel->limit_time    = Input::get('limit_time');

    	    if(Input::file('logo')!=NULL)
            {
                //agrega imagen de logo
                $file_logo=Input::file('logo');
                $ext = Input::file('logo')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $logo=$hotel->id.$nameIMG.'.'.$ext;
                $logo= url().'/assets/pictures_hotels/PIC'.$logo;
                $hotel->logo = $logo;
            }

            if($hotel->save()){
            	if(Input::file('logo')!=NULL)
                {
                    $file_logo->move("assets/pictures_hotels/",$logo); 
                } 

    	        return Redirect::back()->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
            	return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
	}

	public function anyProfile(){
		$user = Sentry::getUser();
		$countries = Country::lists('name', 'id');
		return View::make('hotel.pages.edit_admin')->withUser($user)->withCountries($countries);
	}

	public function anyProfileSave()
	{
        $data = array(
            "first_name"     =>  Input::get("first_name"),
            "last_name"      =>  Input::get("last_name"),
            "email"          =>  Input::get("email"),
            "phone"          =>  Input::get("phone"),
            "picture"        =>  Input::file("picture")
        );
    
        $rules = array(
            "first_name"     =>  'required|min:1|max:255',
            "last_name"      =>  'required|min:1|max:100',
            "email"          =>  'required|min:1',
            "phone"          =>  'required|min:1|max:100',
            "picture"        =>  'mimes:jpeg,gif,png'
        );

        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }
        else
        { 
            $user = Sentry::getUser();
            $user->first_name = Input::get('first_name');
            $user->last_name  = Input::get('last_name');
            $user->position   = Input::get("position");
            $user->email      = Input::get("email");
            $user->birthday   = Input::get("birthday");
            $user->country_id = Input::get("country_id");
            $user->phone      = Input::get("phone");


            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de logo
                $file_logo=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $logo=$user->id.$nameIMG.'.'.$ext;
                $logo= url().'/assets/pictures/PIC'.$logo;
                $user->picture = $logo;
            }

            if($user->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_logo->move("assets/pictures/",$logo); 
                } 

                return Redirect::back()->withFlash_message(trans('main.Guardado Exitosamente'));
            }
            else
            {
              return Redirect::back()->withErrors(trans('main.Error'))->withInput();      
            }
         
        }
    }
    
    public function anyCategoryPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = Category_menu::find($item);
            $category->order = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyServicePosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $service = Service::find($item);
            $service->Serviceorder = $position;
            $service->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyInfoPlacesPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $info = InfoPlace::find($item);
            $info->infoOrder = $position;
            $info->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyActivityPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $activity = Activity::find($item);
            $activity->activityOrder = $position;
            $activity->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyItemPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = Item::find($item);
            $category->order = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyBusinessPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = Business::find($item);
            $category->businessOrder = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyBusinessMenuPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $menu = Menu::find($item);
            $menu->menuOrder = $position;
            $menu->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyPhonePosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = Phone::find($item);
            $category->order = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyCatPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = Category::find($item);
            $category->categoryOrder = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyCategoryInfoPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $category = CategoryInfo::find($item);
            $category->categoryOrder = $position;
            $category->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyPromotionPosition()   
    {
        $array = Input::get('listItem');
        foreach ($array as $position => $item)
        {
            $promo = Promotion::find($item);
            $promo->order = $position;
            $promo->save();  
        }

        return Response::json(array(
              'success'  => true
        ));
    }

    public function anyLanguage()   
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $langs_actives = LanguageHotel::where('hotel_id', $hotel->id)->get();

        $langs = array(''=>trans('main.Seleccione un lenguaje'));
        foreach (Language::where('state', 1)->whereNotIn('id', LanguageHotel::where('hotel_id', $hotel->id)->lists('language_id'))->get() as $lang) {
            $langs[$lang->id] = $lang->language;
        }

        return View::make('hotel.pages.select_language')->with(array('langs'=>$langs, 'lang_main'=>$lang_main,'langs_actives'=>$langs_actives));
    }

    public function anyLanguageState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $lang = LanguageHotel::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($lang->state==1){
               $lang->state = 0;
               $message = trans('main.your language this disabled');
            }else{
                if(LanguageHotel::langstate(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este lenguaje algunas categorias, elementos del menu o telefonos que estan activos no tienen el nombre o descripcion en este lenguaje')
                    ));
                }

                $lang->state = 1;
                $message = trans('main.your language this enabled');
            }

            if($lang->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyLanguageCreate()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

        if(Request::ajax()){
            $data = array(
               "lang"      =>  Input::get("lang"),
            );
          
            $rules = array(
               "lang"      =>  'required|min:1',
            );

            $messages = array();

            $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores   
            if ($validation->fails())
            {
              return Response::json(array(
                  'success' => false,
                  'errors' => $validation->getMessageBag()->toArray()
              ));
            }else{
                $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
                $lang = new LanguageHotel;
                $lang->language_id = Input::get('lang');
                $lang->hotel_id = $hotel->id;
                $lang->state = 0;
                $lang->main = 0;

                if($lang->save())
                {
                    return Response::json(array(
                       'success'       =>  true
                    ));
                }else{
                    return Response::json(array(
                       'success'       =>  false,
                       'error' => trans('main.Error')
                    ));
                }
                
            } 
        }   
    }

    public function anyLanguageDelete($id)
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang = LanguageHotel::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($lang){
            $categories = Category_menu::where('hotel_id', $hotel->id)->lists('id');
            $catnames = Name_category_menu::whereIn('category_menu_id',$categories)->get();
            foreach ($catnames as $catname) {
                if($lang->language_id == $catname->language_id){
                    $catname->delete();
                }
            }

            $items = Item::where('hotel_id', $hotel->id)->lists('id');
            $nameItems = NameItem::whereIn('item_id',$items)->get();
            foreach ($nameItems as $nameItem) {
                if($lang->language_id == $nameItem->language_id){
                    $nameItem->delete();
                }
            }

            $phones = Phone::where('hotel_id', $hotel->id)->lists('id');
            $NamePhones = NamePhone::whereIn('phone_id',$phones)->get();
            foreach ($NamePhones as $NamePhone) {
                if($lang->language_id == $NamePhone->language_id){
                    $NamePhone->delete();
                }
            }

            $lang->delete();
            return Redirect::back()->withFlash_message(trans('main.eliminado con exito'));
        }
        return Redirect::back()->withErrors(trans('main.error en el lenguaje'));
    }

    public function anyPhoneState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $phone = Phone::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($phone->state==1){
               $phone->state = 0;
               $message = trans('main.your phone this disabled');
            }else{
                if(Phone::phoneState(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este telefono ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $phone->state = 1;
                $message = trans('main.your phone this enabled');
            }

            if($phone->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyPromotionState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $promotion = Promotion::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($promotion->state==1){
               $promotion->state = 0;
               $message = trans('main.your promotion this disabled');
            }else{
                if(Promotion::stado(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar esta promocion ya que no tiene nombre en algunos lenguajes activos')
                    ));
                }

                $promotion->state = 1;
                $message = trans('main.your promotion this enabled');
            }

            if($promotion->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyCategoryState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $category = Category_menu::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($category->state==1){
               $category->state = 0;
               $message = trans('main.your category this disabled');
            }else{
                if(Category_menu::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este categoria ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $category->state = 1;
                $message = trans('main.your category this enabled');
            }

            if($category->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyServiceState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $service = Service::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($service->state==1){
               $service->state = 0;
               $message = trans('main.your service this disabled');
            }else{
                if(Service::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este servicio ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $service->state = 1;
                $message = trans('main.your service this enabled');
            }

            if($service->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyCategoryInfoState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $category = CategoryInfo::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($category->state==1){
               $category->state = 0;
               $message = trans('main.your category this disabled');
            }else{
                if(CategoryInfo::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este servicio ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $category->state = 1;
                $message = trans('main.your category this enabled');
            }

            if($category->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyInfoPlacesState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $info = InfoPlace::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($info->state==1){
               $info->state = 0;
               $message = trans('main.your InfoPlace this disabled');
            }else{
                if(InfoPlace::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este servicio ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $info->state = 1;
                $message = trans('main.your InfoPlace this enabled');
            }

            if($info->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyActivityState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $activity = Activity::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($activity->state==1){
               $activity->state = 0;
               $message = trans('main.your activity this disabled');
            }else{
                if(Activity::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar esta actvidad ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $activity->state = 1;
                $message = trans('main.your service this enabled');
            }

            if($activity->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyItemState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $item = Item::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($item->state==1){
               $item->state = 0;
               $message = trans('main.your item this disabled');
            }else{
                if(Item::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este item ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $item->state = 1;
                $message = trans('main.your item this enabled');
            }

            if($item->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyBusinessState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $business = Business::where('id', Input::get('id'))->first();

            if($business->state==1){
               $business->state = 0;
               $message = trans('main.your business this disabled');
            }else{
                if(Business::state(Input::get('id'))!=true)
                {
                    return Response::json(array(
                          'success'  => false, 'message'=>trans('main.No puede activar este item ya que no tiene en algunos lenguajes activos')
                    ));
                }

                $business->state = 1;
                $message = trans('main.your item this enabled');
            }

            if($business->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyBusinessMenuState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $menu = Menu::where('id', Input::get('id'))->first();

            if($menu->state==1){
               $menu->state = 0;
               $message = trans('main.your menu this disabled');
            }else{

                $menu->state = 1;
                $message = trans('main.your item this enabled');
            }

            if($menu->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyCatState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $category = Category::where('id', Input::get('id'))->first();

            if($category->state==1){
               $category->state = 0;
               $message = trans('main.your category this disabled');
            }else{

                $category->state = 1;
                $message = trans('main.your item this enabled');
            }

            if($category->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyRoomState()
    {
        if(Request::ajax()){
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $room = Room::where('id', Input::get('id'))->where('hotel_id', $hotel->id)->first();

            if($room->state==1){
               $room->state = 0;
               $message = trans('main.your room this disabled');
            }else{
                $room->state = 1;
                $message = trans('main.your room this enabled');
            }

            if($room->save()){
               return Response::json(array('success' => true, 'message'=>$message)); 
            }else{
              return Response::json(array(
                    'success'  => false
              ));
            } 
        }
    }

    public function anyStatistics()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $items= Item::where('hotel_id', $hotel->id)->where('state', 1)->lists('id');
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();        
        $products = ItemOrder::whereIn('name_item_menu_id', $items);
        if(Input::has('since') and Input::has('until')){
              $products = $products->where('created_at', '>=', Input::get('since'))->where('created_at', '<=', Input::get('until'));
        }
        return View::make('hotel.pages.ranking_productos')->with(array(
            'products'=>$products, 
            'lang'=>$lang,
            'hotel'=>$hotel
            ));
    }

    public function anySchedule()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');
        return View::make('hotel.pages.schedule')->withWeekdays($weekdays)->withHotel($hotel);
    }
    public function anyScheduleSave()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       
        $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        foreach($weekdays as $weekday => $value)
        {
            if(Input::get('desde_1_'.$value) or Input::get('hasta_1_'.$value) or Input::get('desde_2_'.$value) or Input::get('hasta_2_'.$value))
            {
                $schedule = Schedule::where('weekday', $weekday)->where('hotel_id', $hotel->id)->first();
                if(!$schedule)
                    $schedule = new Schedule;
                $schedule->hotel_id = $hotel->id;
                $schedule->weekday = $weekday;
                $schedule->desde_1 = Input::get('desde_1_'.$value);
                $schedule->hasta_1 = Input::get('hasta_1_'.$value);
                $schedule->desde_2 = Input::get('desde_2_'.$value);
                $schedule->hasta_2 = Input::get('hasta_2_'.$value);
                $schedule->save();
            }
        }

        return Redirect::back()->withFlash_message(trans('main.Guardado Exitosamente'));
    }

    public function anyItems(){
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
         
        $array = array(); 
        $x = 0;
        $items = Item::where('hotel_id', $hotel->id)->get();
        foreach ($items as $item) {
            $name = NameItem::where('item_id', $item->id)->where('language_id', $lang_main->language_id)->first();
            $array[$x]['value'] = $item->id;
            $array[$x]['text'] = $name->name;
            $x++;
        }
        return Response::json($array);
    }
}