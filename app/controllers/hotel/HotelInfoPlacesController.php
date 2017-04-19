<?php
class HotelInfoPlacesController extends \BaseController {
	
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
        $info = InfoPlace::where('hotel_id', $hotel->id)->orderBy('infoOrder', 'ASC')->get();
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		return View::make('hotel.pages.info_places')->with(array('infoPlace'=>$info, 'lang'=>$lang));
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

        return View::make('hotel.pages.alta_infoPlace')->withHotel($hotel)
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
            $infoPlace = new InfoPlace;
            $infoPlace->hotel_id = $hotel->id;
            $infoPlace->state = 0;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $infoPlace->picture = $picture;
            }else{
                $infoPlace->picture = url().'/assets/img/no-image.png';

            }

            if($infoPlace->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/services/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    Img::resize($in , null, 100 , 100 , false , $out , true , false ,100 );
                }

                foreach($lang_active->get() as $lang_)
                {
                   $infoPlaceLang = new InfoPlaceLang;
                   $infoPlaceLang->name = Input::get($lang_->language->language);
                   $infoPlaceLang->description = Input::get('descrption_'.$lang_->language->language);
                   $infoPlaceLang->info_place_id = $infoPlace->id;
                   $infoPlaceLang->language_id = $lang_->language->id;
                   $infoPlaceLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $infoPlaceLang = new InfoPlaceLang;
                        $infoPlaceLang->name = Input::get($lang->language);
                        $infoPlaceLang->description = Input::get('descrption_'.$lang->language);
                        $infoPlaceLang->info_place_id = $infoPlace->id;
                        $infoPlaceLang->language_id = $lang->id;
                        $infoPlaceLang->save();
                    }
                }

                return Redirect::to('hotel/info-places')->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $infoPlace = InfoPlace::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($infoPlace)
        {
            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_infoPlace')->withInfo($infoPlace)
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
            $infoPlace = InfoPlace::where('id', $id)->where('hotel_id', $hotel->id)->first();

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $infoPlace->picture = $picture;
            }

            if($infoPlace->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/services/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/services/PIC'.$picname;
                    Img::resize($in , null, 100 , 100 , false , $out , true , false ,100 );
                }

                foreach($lang_active->get() as $lang_)
                {

                    $infoPlaceLang = InfoPlaceLang::where('info_place_id', $infoPlace->id)->where('language_id', $lang_->language_id)->first();
                    if(!$infoPlaceLang)
                        $infoPlaceLang = new InfoPlaceLang;

                    $infoPlaceLang->name = Input::get($lang_->language->language);
                    $infoPlaceLang->description = Input::get('descrption_'.$lang_->language->language);
                    $infoPlaceLang->info_place_id = $infoPlace->id;
                    $infoPlaceLang->language_id = $lang_->language->id;
                    $infoPlaceLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $infoPlaceLang = InfoPlaceLang::where('info_place_id', $infoPlace->id)->where('language_id', $lang->id)->first();
                        if(!$infoPlaceLang)
                            $infoPlaceLang = new InfoPlaceLang;
                        $infoPlaceLang->name = Input::get($lang->language);
                        $infoPlaceLang->description = Input::get('descrption_'.$lang->language);
                        $infoPlaceLang->info_place_id = $infoPlace->id;
                        $infoPlaceLang->language_id = $lang->id;
                        $infoPlaceLang->save();
                    }
                }

                return Redirect::to('hotel/info-places')->withFlash_message(trans('main.Guardado Exitosamente'));
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
       $infoPlace = InfoPlace::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($infoPlace){
          $names_services = InfoPlaceLang::where('info_place_id', $infoPlace->id)->get();
          foreach ($names_services as $infoPlaceLang) {
              $infoPlaceLang->delete();
          }
          $infoPlace->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}