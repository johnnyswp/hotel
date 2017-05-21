<?php
class HotelBusinessController extends \BaseController {
	
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
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $services = array(''=>trans('main.Seleccione una categoria'));
        $servicesAll = Service::where('hotel_id', $hotel->id)->orderBy('Serviceorder', 'ASC');
        foreach($servicesAll->get() as $service)
        {
            $serviceLang = ServiceLang::where('service_id', $service->id)->where('language_id', $lang_main->language_id)->first();
            $services[$service->id] = $serviceLang->name;
        }

        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        if(Input::has('service')){
            $first_service = Input::get('service');
        }else{
            $first_service = Service::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('Serviceorder', 'ASC')->first();
            if($first_service)
                $first_service = $first_service->id;
            else
                $first_service ='';
        }

        $business = Business::where('service_id', $first_service)->orderBy('businessOrder', 'ASC')->get();
        return View::make('hotel.pages.business')->with(array('services'=>$services,
                                                                    'lang'=>$lang,
                                                                    'business'=>$business,
                                                                    'hotel'=>$hotel,
                                                                    'first_service'=>$first_service));
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
        $services = array(''=>trans('main.seleccione un service'));
        $servicesAll = Service::where('hotel_id', $hotel->id)->orderBy('Serviceorder', 'ASC')->get();
        foreach($servicesAll as $service)
        {
            $serviceLang = ServiceLang::where('service_id', $service->id)->where('language_id', $lang_main->language_id)->first();
            $services[$service->id] = $serviceLang->name;
        }

        return View::make('hotel.pages.alta_business')->withHotel($hotel)
                                                  ->withLangs($lang_active->get())
                                                  ->withServices($services);
    }

    public function store()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $langs = LanguageHotel::where('hotel_id', $hotel->id);
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $item = Business::where('hotel_id', $hotel->id)->count();
        if($plan->items <= $item){
            return Redirect::to('hotel/business')->withError(trans('main.Su plan ha llegado al limite de').$plan->items.' '.trans('main.items'));
        }

        $data = array(
            "service_id"   =>  Input::get("service_id"),
            "picture"      =>  Input::file("picture"),
            "phone"        =>  Input::get("phone")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language] = Input::get('descrption_'.$lang_main->language->language);
        $data['horario_'.$lang_main->language->language] = Input::get('horario_'.$lang_main->language->language);

        $rules = array(
            "service_id"   =>  'required|min:1|max:255',
            "phone"        =>  'required|min:1|max:20',
            "picture"      =>  'mimes:jpeg,gif,png'
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:100';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';
        $rules['horario_'.$lang_main->language->language]  = 'required|min:1|max:255';

        $messages = array();

        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails()){
            return Redirect::back()->withErrors($validation)->withInput();
        
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $business = new Business;
            $business->state = 0;
            $business->service_id = Input::get('service_id');
            $business->phone = Input::get('phone');
            $business->hotel_id = $hotel->id;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture= $hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $business->picture = $picture;
            }else{
                $business->picture = url().'/assets/img/no-image.png';
            }

            if($business->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,100 ); 
                }

                foreach($langs->get() as $lang)
                {
                    if(Input::has($lang->language->language) or Input::has('descrption_'.$lang->language->language))
                    {
                        $businessLang = new BusinessLang;
                        $businessLang->name = Input::get($lang->language->language);
                        $businessLang->horario = Input::get('horario_'.$lang->language->language);
                        $businessLang->description = Input::get('descrption_'.$lang->language->language);
                        $businessLang->business_id = $business->id;
                        $businessLang->language_id = $lang->language->id;
                        $businessLang->save();
                    }
                }

                return Redirect::to('hotel/business?service='.$business->service_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $business = Business::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($business)
        {
            $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $services = array(''=>'Seleccione una categoria');
            $serviceAll = Service::where('hotel_id', $hotel->id)->orderBy('Serviceorder', 'ASC')->get();
            foreach($serviceAll as $service)
            {
                $serviceLang = ServiceLang::where('service_id', $service->id)->where('language_id', $lang_main->language_id)->first();
                $services[$service->id] = $serviceLang->name;
            }

            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_business')->withBusiness($business)
                                                           ->withHotel($hotel)
                                                           ->withLangs($lang_active->get())
                                                           ->withServices($services);
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
            "service_id"   =>  Input::get("service_id"),
            "picture"      =>  Input::file("picture"),
            "phone"        =>  Input::get("phone")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language] = Input::get('descrption_'.$lang_main->language->language);
        $data['horario_'.$lang_main->language->language] = Input::get('horario_'.$lang_main->language->language);

        $rules = array(
            "service_id"   =>  'required|min:1|max:255',
            "phone"        =>  'required|min:1|max:20',
            "picture"      =>  'mimes:jpeg,gif,png'
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:100';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';
        $rules['horario_'.$lang_main->language->language]  = 'required|min:1|max:255';
        
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $business = Business::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $business->service_id = Input::get('service_id');
            $business->phone = Input::get('phone');

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $business->picture = $picture;
            }

            if($business->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 400 , 150 , false , $out , true , false ,100 );  
                }

                foreach($lang_active->get() as $lang_)
                {
                    if(Input::has($lang_->language->language) or Input::has('descrption_'.$lang_->language->language))
                    {
                        $businessLang = BusinessLang::where('business_id', $business->id)->where('language_id', $lang_->language_id)->first();
                        if(!$businessLang)
                            $businessLang = new BusinessLang;

                        $businessLang->name = Input::get($lang_->language->language);
                        $businessLang->horario = Input::get('horario_'.$lang_->language->language);
                        $businessLang->description = Input::get('descrption_'.$lang_->language->language);
                        $businessLang->business_id = $business->id;
                        $businessLang->language_id = $lang_->language->id;
                        $businessLang->save();
                    }
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language) or Input::has('descrption_'.$lang->language))
                    {
                        $businessLang = BusinessLang::where('business_id', $business->id)->where('language_id', $lang->id)->first();
                        if(!$businessLang)
                            $businessLang = new BusinessLang;
                 
                        $businessLang->name = Input::get($lang->language);
                        $businessLang->horario = Input::get('horario_'.$lang->language);
                        $businessLang->description = Input::get('descrption_'.$lang->language);
                        $businessLang->business_id = $business->id;
                        $businessLang->language_id = $lang->id;
                        $businessLang->save();
                    }
                }

                return Redirect::to('hotel/business?service='.$business->service_id)->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $item = Business::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($item){
          $names = BusinessLang::where('business_id', $item->id)->get();
          foreach ($names as $name){
              $name->delete();
          }
          $item->delete();
          
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withErrors(trans('main.Error'));
        } 
    }
}