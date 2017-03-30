<?php
class HotelSectorsController extends \BaseController {
	
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
        $sectors = Sector::where('hotel_id', $hotel->id)->get();
		return View::make('hotel.pages.sectores')->with(array('sectors'=>$sectors));
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
       

        return View::make('hotel.pages.alta_sector');
    }

    public function store()
    {
        $data = array(
            "name"   =>  Input::get("name")
        );

        $rules = array(
            "name" =>  'required|min:2|max:50'
        );

        $messages = array();

        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $sector = new Sector;
            $sector->hotel_id = $hotel->id;
            $sector->name = Input::get('name');
            if($sector->save()){
                return Redirect::to('hotel/sectors')->withFlash_message(trans('main.Guardado Exitosamente'));
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
        $sector = Sector::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if(!$sector)
            return View::make('404');

        return View::make('hotel.pages.edit_sector')->withSector($sector);
    }

    public function update($id)
    {
        $data = array(
            "name"   =>  Input::get("name")
        );

        $rules = array(
            "name" =>  'required|min:2|max:50'
        );

        $messages = array();

        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $sector = Sector::where('id', $id)->where('hotel_id', $hotel->id)->first();
            if(!$sector)
                return View::make('404');

            $sector->name = Input::get('name');
            if($sector->save()){
                return Redirect::to('hotel/sectors')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans('main.Error'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $sector = Sector::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($sector){
          $rooms = Room::where('sector_id', $sector->id)->get();
          if($rooms->isEmpty())
          {
            $sector->delete();
          }else{
            return Redirect::back()->withError(trans('main.Error: Existen habitaciones que pertenecen ha este sector'));
          }
          
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withError(trans('main.Error'));
        } 
    }
}