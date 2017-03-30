<?php
class HotelCategoryController extends \BaseController {
	
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
        $category = Category_menu::where('hotel_id', $hotel->id)->orderBy('order', 'ASC')->get();
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		return View::make('hotel.pages.categorias')->with(array('categorys'=>$category, 'lang'=>$lang));
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

        return View::make('hotel.pages.alta_categoria')->withHotel($hotel)
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
            $category = new Category_menu;
            $category->hotel_id = $hotel->id;

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/category/PIC'.$picture;
                $category->picture = $picture;
            }else{
                $category->picture = url().'/assets/img/no-image.png';

            }

            if($category->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/category/",$picture); 
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/category/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/category/PIC'.$picname;
                    Img::resize($in , null, 100 , 100 , false , $out , true , false ,100 );
                }

                foreach($lang_active->get() as $lang_)
                {
                   $name_category = new Name_category_menu;
                   $name_category->name = Input::get($lang_->language->language);
                   $name_category->category_menu_id = $category->id;
                   $name_category->language_id = $lang_->language->id;
                   $name_category->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $name_category = new Name_category_menu;
                        $name_category->name = Input::get($lang->language);
                        $name_category->category_menu_id = $category->id;
                        $name_category->language_id = $lang->id;
                        $name_category->save();
                    }
                }

                return Redirect::to('hotel/category')->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $category = Category_menu::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($category)
        {
            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_categoria')->withCategory($category)
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
            $category = Category_menu::where('id', $id)->where('hotel_id', $hotel->id)->first();

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/category/PIC'.$picture;
                $category->picture = $picture;
            }

            if($category->save()){
                if(Input::file('picture')!=NULL)
                {
                    $file_picture->move("assets/pictures_hotels/category/",$picture);
                    $path = base_path();
                    $in = $path.'/assets/pictures_hotels/category/PIC'.$picname;
                    $out     = $path.'/assets/pictures_hotels/category/PIC'.$picname;
                    Img::resize($in , null, 100 , 100 , false , $out , true , false ,100 );
                }

                foreach($lang_active->get() as $lang_)
                {

                    $name_category = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang_->language_id)->first();
                    if(!$name_category)
                        $name_category = new Name_category_menu;

                    $name_category->name = Input::get($lang_->language->language);
                    $name_category->category_menu_id = $category->id;
                    $name_category->language_id = $lang_->language->id;
                    $name_category->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $name_category = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang->id)->first();
                        if(!$name_category)
                            $name_category = new Name_category_menu;
                        $name_category->name = Input::get($lang->language);
                        $name_category->category_menu_id = $category->id;
                        $name_category->language_id = $lang->id;
                        $name_category->save();
                    }
                }

                return Redirect::to('hotel/category')->withFlash_message(trans('main.Guardado Exitosamente'));
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
       $category = Category_menu::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($category){
        $item = Item::where('category_id', $category->id)->first();
        if($item)
            return Redirect::back()->withError("Error: Existen algunos elemento que pertenecen ha la categoria que intenta eliminar");

          $names_categorys = Name_category_menu::where('category_menu_id', $category->id)->get();
          foreach ($names_categorys as $name_category) {
              $name_category->delete();
          }
          $category->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}