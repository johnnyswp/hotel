<?php
class HotelServicesController extends \BaseController {
	
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
        $services = Service::where('hotel_id', $hotel->id)->orderBy('Serviceorder', 'ASC')->get();
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		return View::make('hotel.pages.services')->with(array('services'=>$services, 'lang'=>$lang));
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
        $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

        return View::make('hotel.pages.alta_services')->withHotel($hotel)
                                                       ->withLangs($lang_active->get());
    }

    public function store()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_active = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id);
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();

        if($lang_active->get()->isEmpty())
            $langs = Language::where('state', 1)->get();
        else
            $langs = Language::whereNotIn('id', $lang_active->lists('language_id'))->where('state', 1)->get();

        $data = array(
            "state"   =>  Input::get("state"),
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png'
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
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $service = new Service;
            $service->hotel_id = $hotel->id;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $service->picture = $picture;
            }else{
                $service->picture = url().'/assets/img/no-image.png';

            }

            if($service->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/services/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,100 );                 }

                foreach($lang_active->get() as $lang_)
                {
                   $serviceLang = new ServiceLang;
                   $serviceLang->name = Input::get($lang_->language->language);
                   $serviceLang->description = Input::get('descrption_'.$lang_->language->language);
                   $serviceLang->service_id = $service->id;
                   $serviceLang->language_id = $lang_->language->id;
                   $serviceLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $serviceLang = new ServiceLang;
                        $serviceLang->name = Input::get($lang->language);
                        $serviceLang->description = Input::get('descrption_'.$lang->language);
                        $serviceLang->service_id = $service->id;
                        $serviceLang->language_id = $lang->id;
                        $serviceLang->save();
                    }
                }

                return Redirect::to('hotel/services')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors("Error")->withInput();
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

        $service = Service::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($service)
        {
            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_services')->withService($service)
                                                           ->withHotel($hotel)
                                                           ->withLangActive($lang_active->get());
        }else{
            return View::make('404');
        }
    }

    public function update($id)
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_active = LanguageHotel::where('hotel_id', $hotel->id);
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();

        if($lang_active->get()->isEmpty())
            $langs = Language::where('state', 1)->get();
        else
            $langs = Language::whereNotIn('id', $lang_active->lists('language_id'))->where('state', 1)->get();

        $data = array(
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png'
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
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $service = Service::where('id', $id)->where('hotel_id', $hotel->id)->first();

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $service->picture = $picture;
            }

            if($service->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/services/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,100 ); 
                }

                foreach($lang_active->get() as $lang_)
                {

                    $serviceLang = ServiceLang::where('service_id', $service->id)->where('language_id', $lang_->language_id)->first();
                    if(!$serviceLang)
                        $serviceLang = new ServiceLang;

                    $serviceLang->name = Input::get($lang_->language->language);
                    $serviceLang->description = Input::get('descrption_'.$lang_->language->language);
                    $serviceLang->service_id = $service->id;
                    $serviceLang->language_id = $lang_->language->id;
                    $serviceLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $serviceLang = ServiceLang::where('service_id', $service->id)->where('language_id', $lang->id)->first();
                        if(!$serviceLang)
                            $serviceLang = new ServiceLang;
                        $serviceLang->name = Input::get($lang->language);
                        $serviceLang->description = Input::get('descrption_'.$lang->language);
                        $serviceLang->service_id = $service->id;
                        $serviceLang->language_id = $lang->id;
                        $serviceLang->save();
                    }
                }

                return Redirect::to('hotel/services')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors("Error")->withInput();
            }
        }
    }

    public function destroy($id)
    {
       if(Sentry::getUser()->type_user!=3){ return View::make('404');}

       if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $service = Service::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($service){
          $names_services = ServiceLang::where('service_id', $service->id)->get();
          foreach ($names_services as $serviceLang) {
              $serviceLang->delete();
          }
          $service->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}