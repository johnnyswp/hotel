<?php
class HotelMenuController extends \BaseController {
	
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
        $categories = array(''=>trans('main.Seleccione una categoria'));
        $categorys = Category_menu::where('hotel_id', $hotel->id)->orderBy('order', 'ASC');
        foreach($categorys->get() as $category)
        {
            $nameC = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang_main->language_id)->first();
            $categories[$category->id] = $nameC->name;
        }

        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        if(Input::has('category')){
            $first_category = Input::get('category');
        }else{
            $first_category = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->first();
            if($first_category)
                $first_category = $first_category->id;
            else
                $first_category ='';
        }

        $items = Item::where('hotel_id', $hotel->id)->where('category_id', $first_category)->orderBy('order', 'ASC')->get();
        return View::make('hotel.pages.elementos_menu')->with(array('categories'=>$categories,
                                                                    'lang'=>$lang,
                                                                    'items'=>$items,
                                                                    'hotel'=>$hotel,
                                                                    'first_category'=>$first_category));
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
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $item = Item::where('hotel_id', $hotel->id)->count();
        if($plan->items <= $item){
            return Redirect::to('hotel/menu')->withError(trans('main.Su plan ha llegado al limite de').$plan->items.' '.trans('main.items'));
        }
        
        $categories = array(''=>'Seleccione una categoria');
        $categorys = Category_menu::where('hotel_id', $hotel->id)->orderBy('order', 'ASC')->get();
        foreach($categorys as $category)
        {
            $nameC = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang_main->language_id)->first();
            $categories[$category->id] = $nameC->name;
        }

        $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');

        return View::make('hotel.pages.alta_menu')->withHotel($hotel)
                                                  ->withLangs($lang_active->get())
                                                  ->withCategories($categories)
                                                  ->withWeekdays($weekdays);
    }

    public function store()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $langs = LanguageHotel::where('hotel_id', $hotel->id);
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $item = Item::where('hotel_id', $hotel->id)->count();
        if($plan->items <= $item){
            return Redirect::to('hotel/menu')->withError(trans('main.Su plan ha llegado al limite de').$plan->items.' '.trans('main.items'));
        }

        $data = array(
            "category_id"   =>  Input::get("category_id"),
            "price"         =>  Input::get("price"),
            "delivery_time" =>  Input::get("delivery_time"),
            "picture"       =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language] = Input::get('descrption_'.$lang_main->language->language);

        $rules = array(
            "category_id"   =>  'required|min:1|max:255',
            "price"         =>  'required|numeric|between:0,99999.99',
            "delivery_time" =>  'required|min:1|max:255',
            "picture"       =>  'mimes:jpeg,gif,png'
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';

        $messages = array();

        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $item = new Item;
            $item->state = 0;
            $item->hotel_id = $hotel->id;
            $item->price = Input::get('price');
            $item->delivery_time = Input::get('delivery_time');
            $item->code = Input::get('code');
            $item->category_id = Input::get('category_id');
            if(Input::get('type_of_schedule')==1)
                $item->type_of_schedule = 1;
            else
                $item->type_of_schedule = 0;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture= $hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $item->picture = $picture;
            }else{
                $item->picture = url().'/assets/img/no-image.png';
            }

            if($item->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 100 , 100 , false , $out , true , false ,100 );
                }

                foreach($langs->get() as $lang)
                {
                    if(Input::has($lang->language->language) or Input::has('descrption_'.$lang->language->language))
                    {
                        $name_item = new NameItem;
                        $name_item->name = Input::get($lang->language->language);
                        $name_item->description = Input::get('descrption_'.$lang->language->language);
                        $name_item->item_id = $item->id;
                        $name_item->language_id = $lang->language->id;
                        $name_item->save();
                    }
                }

                if(Input::get('type_of_schedule')==1){
                    $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes'    , '6'=>'Sabado');
                    foreach($weekdays as $weekday => $value)
                    {
                        if(Input::get('desde_1_'.$value) or Input::get('hasta_1_'.$value) or Input::get('desde_2_'.$value) or Input    ::get('hasta_2_'.$value))
                        {
                            $availble = new Available;
                            $availble->item_id = $item->id;
                            $availble->weekday = $weekday;
                            $availble->desde_1 = Input::get('desde_1_'.$value);
                            $availble->hasta_1 = Input::get('hasta_1_'.$value);
                            $availble->desde_2 = Input::get('desde_2_'.$value);
                            $availble->hasta_2 = Input::get('hasta_2_'.$value);
                            $availble->save();
                        }
                    }
                }

                return Redirect::to('hotel/menu?category='.$item->category_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $item = Item::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($item)
        {
            $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');
            $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $categories = array(''=>'Seleccione una categoria');
            $categorys = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();
            foreach($categorys as $category)
            {
                $nameC = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang_main->language_id)->first();
                $categories[$category->id] = $nameC->name;
            }

            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_menu')->withItem($item)
                                                           ->withHotel($hotel)
                                                           ->withLangs($lang_active->get())
                                                           ->withWeekdays($weekdays)
                                                           ->withCategories($categories);
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
            "category_id"   =>  Input::get("category_id"),
            "price"         =>  Input::get("price"),
            "delivery_time" =>  Input::get("delivery_time"),
            "picture"       =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);
        $data['descrption_'.$lang_main->language->language] = Input::get('descrption_'.$lang_main->language->language);

        $rules = array(
            "category_id"   =>  'required|min:1|max:255',
            "price"         =>  'required|numeric|between:0,99999.99',
            "delivery_time" =>  'required|min:1|max:255',
            "picture"       =>  'mimes:jpeg,gif,png'
        );

        $rules[$lang_main->language->language]  = 'required|min:1|max:255';
        $rules['descrption_'.$lang_main->language->language]  = 'min:1|max:255';
        
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $item = Item::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $item->price = Input::get('price');
            $item->delivery_time = Input::get('delivery_time');
            $item->code = Input::get('code');
            $item->category_id = Input::get('category_id');
            if(Input::get('type_of_schedule')==1)
                $item->type_of_schedule = 1;
            else
                $item->type_of_schedule = 0;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/item/PIC'.$picture;
                $item->picture = $picture;
            }

            if($item->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/item/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/item/PIC'.$picname;
                    Img::resize($in , null, 500 , 500 , false , $out , true , false ,100 ); 
                }

                foreach($lang_active->get() as $lang_)
                {
                    if(Input::has($lang_->language->language) or Input::has('descrption_'.$lang_->language->language))
                    {
                        $name_item = NameItem::where('item_id', $item->id)->where('language_id', $lang_->language_id)->first();
                        if(!$name_item)
                            $name_item = new NameItem;

                        $name_item->name = Input::get($lang_->language->language);
                        $name_item->description = Input::get('descrption_'.$lang_->language->language);
                        $name_item->item_id = $item->id;
                        $name_item->language_id = $lang_->language->id;
                        $name_item->save();
                    }
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language) or Input::has('descrption_'.$lang->language))
                    {
                        $name_item = NameItem::where('item_id', $item->id)->where('language_id', $lang->id)->first();
                        if(!$name_item)
                            $name_item = new NameItem;
                        
                        $name_item->name = Input::get($lang->language);
                        $name_item->description = Input::get('descrption_'.$lang->language);
                        $name_item->item_id = $item->id;
                        $name_item->language_id = $lang->id;
                        $name_item->save();
                    }
                }
        
                $weekdays = array('0'=>'Domingo', '1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6'=>'Sabado');
                foreach($weekdays as $weekday => $value)
                {
                    if(Input::get('desde_1_'.$value) or Input::get('hasta_1_'.$value) or Input::get('desde_2_'.$value) or Input::get('hasta_2_'.$value))
                    {
                        $availble = Available::where('weekday', $weekday)->where('item_id', $item->id)->first();
                        if(!$availble)
                            $availble = new Available;
                        $availble->item_id = $item->id;
                        $availble->weekday = $weekday;
                        $availble->desde_1 = Input::get('desde_1_'.$value);
                        $availble->hasta_1 = Input::get('hasta_1_'.$value);
                        $availble->desde_2 = Input::get('desde_2_'.$value);
                        $availble->hasta_2 = Input::get('hasta_2_'.$value);
                        $availble->save();
                    }
                }

                return Redirect::to('hotel/menu?category='.$item->category_id)->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $item = Item::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($item){
          $names = NameItem::where('item_id', $item->id)->get();
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