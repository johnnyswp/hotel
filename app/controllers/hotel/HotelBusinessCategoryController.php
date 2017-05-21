<?php
class HotelBusinessCategoryController extends \BaseController {
    
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
        
        $business = array(''=>trans('main.Seleccione un business'));
        $businessAll = Business::where('hotel_id', $hotel->id)->orderBy('businessOrder', 'ASC');
        foreach($businessAll->get() as $busines)
        {
            $businessLang = BusinessLang::where('business_id', $busines->id)->where('language_id', $lang->language_id)->first();
            $business[$busines->id] = $businessLang->name;
        }

        if(Input::has('business')){
            $first_business = Input::get('business');
        }else{
            $first_business = Business::where('hotel_id', $hotel->id)->orderBy('businessOrder', 'ASC')->first();
            if($first_business)
                $first_business = $first_business->id;
            else
                $first_business ='';
        }
        
        $categories = Category::where('business_id', $first_business)->where('hotel_id', $hotel->id)->orderBy('categoryOrder', 'ASC')->get();
        return View::make('hotel.pages.business_category')->with(array('categories'=>$categories, 'lang'=>$lang, 'business'=>$business, 'first_business'=>$first_business));
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
        $business = array(''=>trans('main.Seleccione un business'));
        $businessAll = Business::where('hotel_id', $hotel->id)->orderBy('businessOrder', 'ASC');
        foreach($businessAll->get() as $busines)
        {
            $businessLang = BusinessLang::where('business_id', $busines->id)->where('language_id', $lang->language_id)->first();
            $business[$busines->id] = $businessLang->name;
        }

        return View::make('hotel.pages.alta_business_category')->withHotel($hotel)->withBusiness($business)
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
            "business_id"   =>  Input::get("business_id"),
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png',
            "business_id" => 'required|min:1|max:255',
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
            $cat = new Category;
            $cat->hotel_id = $hotel->id;
            $cat->business_id = Input::get("business_id");

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $cat->picture = $picture;
            }else{
                $cat->picture = url().'/assets/img/no-image.png';

            }

            if($cat->save()){
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
                   $catLang = new CategoryLang;
                   $catLang->name = Input::get($lang_->language->language);
                   $catLang->category_id = $cat->id;
                   $catLang->language_id = $lang_->language->id;
                   $catLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $catLang = new CategoryLang;
                        $catLang->name = Input::get($lang->language);
                        $catLang->category_id = $cat->id;
                        $catLang->language_id = $lang->id;
                        $catLang->save();
                    }
                }

                return Redirect::to('hotel/business/category?business='.$cat->business_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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

        $category = Category::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if($category)
        {
            $lang_main = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $business = array(''=>'Seleccione una business');
            $businessAll = Business::where('hotel_id', $hotel->id)->orderBy('businessOrder', 'ASC')->get();
            foreach($businessAll as $busin)
            {
                $businessLang = BusinessLang::where('business_id', $busin->id)->where('language_id', $lang_main->language_id)->first();
                $business[$busin->id] = $businessLang->name;
            }

            $lang_active = LanguageHotel::where('hotel_id', $hotel->id)->orderBy('main', 'DESC')->orderBy('state', 'DESC');

            return View::make('hotel.pages.edit_business_category')->withCategory($category)
                                                           ->withHotel($hotel)
                                                           ->withLangs($lang_active->get())
                                                           ->withBusiness($business);
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
            "business_id"   =>  Input::get("business_id"),
            "picture" =>  Input::file("picture")
        );

        $data[$lang_main->language->language] = Input::get($lang_main->language->language);

        $rules = array(
            "picture" =>  'mimes:jpeg,gif,png',
            "business_id" => 'required|min:1|max:255',
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
            $cat = Category::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $cat->business_id = Input::get("business_id");

            if(Input::file('picture')!=NULL)
            {
                //agrega imagen de picture
                $file_picture=Input::file('picture');
                $ext = Input::file('picture')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $picture=$hotel->id.$nameIMG.'.'.$ext;
                $picname = $picture;
                $picture= url().'/assets/pictures_hotels/services/PIC'.$picture;
                $cat->picture = $picture;
            }

            if($cat->save()){
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

                    $categoryLang = CategoryLang::where('category_id', $cat->id)->where('language_id', $lang_->language_id)->first();
                    if(!$categoryLang)
                        $categoryLang = new CategoryLang;

                    $categoryLang->name = Input::get($lang_->language->language);
                    $categoryLang->category_id = $cat->id;
                    $categoryLang->language_id = $lang_->language->id;
                    $categoryLang->save();
                }

                foreach($langs as $lang)
                {
                    if(Input::has($lang->language))
                    {
                        $categoryLang = CategoryLang::where('category_id', $cat->id)->where('language_id', $lang->id)->first();
                        if(!$categoryLang)
                            $categoryLang = new CategoryLang;
                        $categoryLang->name = Input::get($lang->language);
                        $categoryLang->category_id = $cat->id;
                        $categoryLang->language_id = $lang->id;
                        $categoryLang->save();
                    }
                }

                return Redirect::to('hotel/business/category?business='.$cat->business_id)->withFlash_message(trans('main.Guardado Exitosamente'));
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
       $cat = Category::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($cat){
          $categoryLang = CategoryLang::where('category_id', $cat->id)->get();
          foreach ($categoryLang as $categoryLang) {
              $categoryLang->delete();
          }
          $cat->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}