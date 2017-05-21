<?php
class HotelBusinessMenusController extends \BaseController {
	
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
        
        $cat = array(''=>trans('main.Seleccione un category'));
        $catAll = Category::where('hotel_id', $hotel->id)->orderBy('categoryOrder', 'ASC');
        foreach($catAll->get() as $category)
        {
            $catLang = CategoryLang::where('category_id', $category->id)->where('language_id', $lang->language_id)->first();
            $businessLang = BusinessLang::where('business_id', $category->business_id)->where('language_id', $lang->language_id)->first();
            $cat[$category->id] = $catLang->name." - ".$businessLang->name;
        }

        if(Input::has('category')){
            $first_cat = Input::get('category');
        }else{
            $first_cat = Category::where('hotel_id', $hotel->id)->orderBy('categoryOrder', 'ASC')->first();
            if($first_cat)
                $first_cat = $first_cat->id;
            else
                $first_cat ='';
        }
        
        $menus = Menu::where('category_id', $first_cat)->where('hotel_id', $hotel->id)->orderBy('menuOrder', 'ASC')->get();
		return View::make('hotel.pages.menus_business')->with(array('menus'=>$menus, 'lang'=>$lang, 'cats'=>$cat, 'first_cat'=>$first_cat));
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
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $cat = array(''=>trans('main.Seleccione un category'));
        $catAll = Category::where('hotel_id', $hotel->id)->orderBy('categoryOrder', 'ASC');
        foreach($catAll->get() as $category)
        {
            $catLang = CategoryLang::where('category_id', $category->id)->where('language_id', $lang->language_id)->first();
            $businessLang = BusinessLang::where('business_id', $category->business_id)->where('language_id', $lang->language_id)->first();
            $cat[$category->id] = $catLang->name." - ".$businessLang->name;
        }

        return View::make('hotel.pages.alta_menu_business')->withHotel($hotel)->withCats($cat)
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
            "category_id"   =>  Input::get("category_id"),
            "price"   =>  Input::get("price"),
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png',
            "category_id" => 'required|min:1|max:255',
            "price" => 'required|min:1|max:255',
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
            $menu = new Menu;
            $menu->hotel_id = $hotel->id;
            $menu->category_id = Input::get("category_id");
            $menu->price = Input::get("price");

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $menu->picture = $picture;
            }else{
                $menu->picture = url().'/assets/img/no-image.png';

            }

            if($menu->save()){
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
                   $menuLang = new MenuLang;
                   $menuLang->name = Input::get($lang_->language->language);
                   $menuLang->description = Input::get('descrption_'.$lang_->language->language);
                   $menuLang->menu_id = $menu->id;
                   $menuLang->language_id = $lang_->language->id;
                   $menuLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $menuLang = new MenuLang;
                        $menuLang->name = Input::get($lang->language);
                        $menuLang->description = Input::get('descrption_'.$lang->language);
                        $menuLang->menu_id = $menu->id;
                        $menuLang->language_id = $lang->id;
                        $menuLang->save();
                    }
                }

                return Redirect::to('hotel/business/menu?category='.$menu->category_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $menu = Menu::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($menu)
        {
            $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $cat = array(''=>'Seleccione una categoria');
            $catAll = Category::where('hotel_id', $hotel->id)->orderBy('categoryOrder', 'ASC')->get();
            foreach($catAll as $category)
            {
                $catLang = CategoryLang::where('category_id', $category->id)->where('language_id', $lang_main->language_id)->orderBy('name', 'ASC')->first();
                $businessLang = BusinessLang::where('business_id', $category->business_id)->where('language_id', $lang_main->language_id)->first();
                $cat[$category->id] = $catLang->name." - ".$businessLang->name;
            }

            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_menu_business')->withMenu($menu)
                                                           ->withHotel($hotel)
                                                           ->withLangs($lang_active->get())
                                                           ->withCats($cat);
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
            "category_id"   =>  Input::get("category_id"),
            "price"   =>  Input::get("price"),
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png',
            "category_id" => 'required|min:1|max:255',
            "price" => 'required|min:1|max:255',
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
            $menu = Menu::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $menu->category_id = Input::get("category_id");
            $menu->price = Input::get("price");

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $menu->picture = $picture;
            }

            if($menu->save()){
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

                    $menuLang = MenuLang::where('menu_id', $menu->id)->where('language_id', $lang_->language_id)->first();
                    if(!$menuLang)
                        $menuLang = new MenuLang;

                    $menuLang->name = Input::get($lang_->language->language);
                    $menuLang->description = Input::get('descrption_'.$lang_->language->language);
                    $menuLang->menu_id = $menu->id;
                    $menuLang->language_id = $lang_->language->id;
                    $menuLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $menuLang = MenuLang::where('menu_id', $menu->id)->where('language_id', $lang->id)->first();
                        if(!$menuLang)
                            $menuLang = new MenuLang;
                        $menuLang->name = Input::get($lang->language);
                        $menuLang->description = Input::get('descrption_'.$lang->language);
                        $menuLang->menu_id = $menu->id;
                        $menuLang->language_id = $lang->id;
                        $menuLang->save();
                    }
                }

                return Redirect::to('hotel/business/menu?category='.$menu->category_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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
       $menu = Menu::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($menu){
          $menuLang = MenuLang::where('menu_id', $menu->id)->get();
          foreach ($menuLang as $menuLang) {
              $menuLang->delete();
          }
          $menu->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}