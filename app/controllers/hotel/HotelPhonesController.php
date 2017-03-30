<?php
class HotelPhonesController extends \BaseController {
	
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	*/
	public function index()
	{
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $phones = Phone::where('hotel_id', $hotel->id)->orderBy('order', 'ASC')->get();
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		return View::make('hotel.pages.phones')->with(array('phones'=>$phones, 'lang'=>$lang));
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
    */
    public function create()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $langs = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

        $type = TypePhone::lists('type','id');

        $country = Country::find($hotel->country->id);
        $prefix = $country->name."(".$country->prefix.")";

        return View::make('hotel.pages.alta_phone')->withHotel($hotel)
                                                       ->withLangs($langs->get())
                                                       ->withType($type)
                                                       ->withPrefix($prefix);
    }

    public function store()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $lang_active = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id);

        if($lang_active->get()->isEmpty())
            $langs = Language::where('state', 1)->get();
        else
            $langs = Language::whereNotIn('id', $lang_active->lists('language_id'))->where('state', 1)->get();

        $data = array(
            "number"          =>  Input::get("number"),
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "number"   =>  'required|min:1|max:255|unique:phones',
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $phone = new Phone;
            $phone->hotel_id = $hotel->id;
            $phone->number = Input::get('number');
            if($phone->save()){
                foreach($lang_active->get() as $lang_)
                {
                    if(Input::has($lang_->language->language))
                    {
                        $name_phone = new NamePhone;
                        $name_phone->name = Input::get($lang_->language->language);
                        $name_phone->phone_id = $phone->id;
                        $name_phone->language_id = $lang_->language->id;
                        $name_phone->save();
                    }
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $name_phone = new NamePhone;
                        $name_phone->name = Input::get($lang->language);
                        $name_phone->phone_id = $phone->id;
                        $name_phone->language_id = $lang->id;
                        $name_phone->save();
                    }
                }

                return Redirect::to('hotel/phones')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
    */
    public function edit($id)
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();

        $phone = Phone::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($phone)
        {
            $langs = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');
            $type = TypePhone::lists('type','id');
            
            $country = Country::find($hotel->country->id);
            $prefix = $country->name."(".$country->prefix.")";

            return View::make('hotel.pages.edit_phone')->withPhone($phone)
                                                           ->withHotel($hotel)
                                                           ->withLangActive($langs->get())
                                                           ->withType($type)
                                                           ->withPrefix($prefix);
        }else{
            return View::make('404');
        }
    }

    public function update($id)
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $lang_active = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id);

        if($lang_active->get()->isEmpty())
            $langs = Language::where('state', 1)->get();
        else
            $langs = Language::whereNotIn('id', $lang_active->lists('language_id'))->where('state', 1)->get();

        $data = array(
            "number"          =>  Input::get("number"),
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "number"   =>  'required|min:1|max:255',
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $phone = Phone::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $phone->hotel_id = $hotel->id;
            $phone->number = Input::get('number');

            if($phone->save()){
                foreach($lang_active->get() as $lang_)
                {
                    if(Input::has($lang_->language->language))
                    {
                        $name_phone = NamePhone::where('phone_id', $phone->id)->where('language_id', $lang_->language_id)->first();
                        if(!$name_phone)
                            $name_phone = new NamePhone;

                        $name_phone->name = Input::get($lang_->language->language);
                        $name_phone->phone_id = $phone->id;
                        $name_phone->language_id = $lang_->language->id;
                        $name_phone->save();
                    }
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $name_phone = NamePhone::where('phone_id', $phone->id)->where('language_id', $lang->id)->first();
                        if(!$name_phone)
                            $name_phone = new NamePhone;

                        $name_phone->name = Input::get($lang->language);
                        $name_phone->phone_id = $phone->id;
                        $name_phone->language_id = $lang->id;
                        $name_phone->save();
                    }
                }

                return Redirect::to('hotel/phones')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $phone = Phone::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($phone){
          $names_phones = NamePhone::where('phone_id', $phone->id)->get();
          foreach ($names_phones as $name_phone) {
              $name_phone->delete();
          }
          $phone->delete();
          
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withErrors(trans('main.Error'));
        } 
    }
}