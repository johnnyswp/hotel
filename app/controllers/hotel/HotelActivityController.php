<?php
class HotelActivityController extends \BaseController {
	
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
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();

        $activities = Activity::where('hotel_id', $hotel->id)->orderBy('activityOrder', 'ASC')->get();
        return View::make('hotel.pages.activity')->with(array('lang'=>$lang,
                                                              'activities'=>$activities,
                                                              'hotel'=>$hotel));
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
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        //verificamos el plsn

        $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');

        return View::make('hotel.pages.alta_activity')->withHotel($hotel)
                                                  ->withLangs($lang_active->get())
                                                  ->withWeekdays($weekdays);
    }

    public function store()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $langs = LanguageHotel::where('hotel_id', $hotel->id);
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $activity = Activity::where('hotel_id', $hotel->id)->count();
        if($plan->items <= $activity){
            return Redirect::to('hotel/menu')->withError(trans('main.Su plan ha llegado al limite de').$plan->items.' '.trans('main.items'));
        }

        $data = array(
            "since"         =>  Input::get("since"),
            "until"         =>  Input::get("until"),
            "picture"       =>  Input::file("picture")
        );
        if(Input::get('type')==1){
            $data['weekday'] = Input::get('weekday');
        }else{
            $data['day_aciviti'] = Input::get('day_aciviti');
        }


        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language] = Input::get('descrption_'.$lang_main->language->language);
        $data['public_'.$lang_main->language->language] = Input::get('public_'.$lang_main->language->language);
        $data['zone_'.$lang_main->language->language] = Input::get('zone_'.$lang_main->language->language);

        $rules = array(
            "until"         =>  'required|min:1|max:15',
            "since"         =>  'required|min:1|max:15',
            "picture"       =>  'mimes:jpeg,gif,png'
        );
        if(Input::get('type')==1){
            $rules['weekday'] = 'required';
        }else{
            $rules['day_aciviti'] = 'required';
        }

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';
        $rules['public_'.$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['zone_'.$lang_main->language->language]  = 'required|min:1|max:255';

        $messages = array();

        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $activity = new Activity;
            $activity->state = 0;
            $activity->hotel_id = $hotel->id;
            $activity->since = Input::get('since');
            $activity->until = Input::get('until');
            if(Input::get('type')==1){
                $activity->daysActivity = implode(',', Input::get('weekday'));
            }else{
                $activity->daysActivity = Input::get('day_aciviti');
            }
            

            if(Input::get('type')==1)
                $activity->type = 1;
            else
                $activity->type = 0;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture= $hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $activity->picture = $picture;
            }else{
                $activity->picture = url().'/assets/img/no-image.png';
            }

            if($activity->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,1000 );
                }

                foreach($langs->get() as $lang)
                {
                    if(Input::has($lang->language->language) or Input::has('descrption_'.$lang->language->language))
                    {
                        $activityLang = new ActivityLang;
                        $activityLang->name = Input::get($lang->language->language);
                        $activityLang->description = Input::get('descrption_'.$lang->language->language);
                        $activityLang->public = Input::get('public_'.$lang->language->language);
                        $activityLang->zone = Input::get('zone_'.$lang->language->language);
                        $activityLang->activity_id = $activity->id;
                        $activityLang->language_id = $lang->language->id;
                        $activityLang->save();
                    }
                }

                return Redirect::to('hotel/activity')->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $activity = Activity::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($activity)
        {
            $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');
            $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_activity')->withActivity($activity)
                                                           ->withHotel($hotel)
                                                           ->withLangs($lang_active->get())
                                                           ->withWeekdays($weekdays);
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
            "since"         =>  Input::get("since"),
            "until"         =>  Input::get("until"),
            "picture"       =>  Input::file("picture")
        );
        if(Input::get('type')==1){
            $data['weekday'] = Input::get('weekday');
        }else{
            $data['day_aciviti'] = Input::get('day_aciviti');
        }


        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language]= Input::get('descrption_'.$lang_main->language->language);
        $data['public_'.$lang_main->language->language] = Input::get('public_'.$lang_main->language->language);
        $data['zone_'.$lang_main->language->language] = Input::get('zone_'.$lang_main->language->language);

        $rules = array(
            "until"         =>  'required|min:1|max:15',
            "since"         =>  'required|min:1|max:15',
            "picture"       =>  'mimes:jpeg,gif,png'
        );
        if(Input::get('type')==1){
            $rules['weekday'] = 'required';
        }else{
            $rules['day_aciviti'] = 'required';
        }

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';
        $rules['public_'.$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['zone_'.$lang_main->language->language]  = 'required|min:1|max:255';
        
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $activity = Activity::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $activity->since = Input::get('since');
            $activity->until = Input::get('until');
            if(Input::get('type')==1){
                $activity->daysActivity = implode(',', Input::get('weekday'));
            }else{
                $activity->daysActivity = Input::get('day_aciviti');
            }
            
            if(Input::get('type')==1)
                $activity->type = 1;
            else
                $activity->type = 0;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $activity->picture = $picture;
            }

            if($activity->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,1000 ); 
                }

                foreach($lang_active->get() as $lang_)
                {
                    if(Input::has($lang_->language->language) or Input::has('descrption_'.$lang_->language->language))
                    {
                        $activityLang = ActivityLang::where('activity_id', $activity->id)->where('language_id', $lang_->language_id)->first();
                        if(!$activityLang)
                            $activityLang = new ActivityLang;

                        $activityLang->name = Input::get($lang_->language->language);
                        $activityLang->description = Input::get('descrption_'.$lang_->language->language);
                        $activityLang->activity_id = $activity->id;
                        $activityLang->public = Input::get('public_'.$lang_->language->language);
                        $activityLang->zone = Input::get('zone_'.$lang_->language->language);
                        $activityLang->activity_id = $activity->id;
                        $activityLang->language_id = $lang_->language->id;
                        $activityLang->save();
                    }
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language) or Input::has('descrption_'.$lang->language))
                    {
                        $activityLang = ActivityLang::where('activity_id', $activity->id)->where('language_id', $lang->id)->first();
                        if(!$activityLang)
                            $activityLang = new ActivityLang;
                        
                        $activityLang->name = Input::get($lang_->language->language);
                        $activityLang->description = Input::get('descrption_'.$lang_->language->language);
                        $activityLang->activity_id = $activity->id;
                        $activityLang->public = Input::get('public_'.$lang_->language->language);
                        $activityLang->zone = Input::get('zone_'.$lang_->language->language);
                        $activityLang->activity_id = $activity->id;
                        $activityLang->language_id = $lang_->language->id;
                        $activityLang->save();
                    }
                }
        
                return Redirect::to('hotel/activity')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $activity = Activity::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($activity){
          $activitiesLangs = ActivityLang::where('activity_id', $activity->id)->get();
          foreach ($activitiesLangs as $activityLang){
              $activityLang->delete();
          }
          $activity->delete();
          
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withErrors(trans('main.Error'));
        } 
    }
}