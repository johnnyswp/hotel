<?php
class HotelRoomsController extends \BaseController {
	
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
        $rooms = Room::where('hotel_id', $hotel->id)->get();
		return View::make('hotel.pages.rooms')->with(array('rooms'=>$rooms));
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
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $item = Room::where('hotel_id', $hotel->id)->count();
        if($plan->rooms <= $item){
            return Redirect::to('hotel/rooms')->withError(trans('main.Su plan ha llegado al limite de').$plan->rooms.' '.trans('main.rooms'));
        }

        $sectors = Sector::where('hotel_id', $hotel->id)->lists('name', 'id');
        return View::make('hotel.pages.alta_room')->with(array('sectors'=>$sectors));
    }

    public function store()
    {
        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $payment  = Payment::where('user_id', $hotel->user_id)->first();
        $plan = Plan::find($payment->plan_id);
        $item = Room::where('hotel_id', $hotel->id)->count();
        if($plan->rooms <= $item){
        return Redirect::to('hotel/rooms')->withError(trans('main.Su plan ha llegado al limite de').$plan->rooms.' '.trans('main.rooms'));
         }
        $data = array(
            "desde" =>  Input::get("desde"),
            "sector_id"   => Input::get('sector_id')
        );

        $rules = array(
            "desde"       =>  'required|min:1|max:50',
            "sector_id"   =>  'required|min:1|max:50',
            "state"       =>  'min:1|max:5',
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
            if(is_int(intval(Input::get('desde')))==true and is_int(intval(Input::get('hasta')))==true and intval(Input::get('desde')) < intval(Input::get('hasta')))
            {
                if((Input::get('hasta')-Input::get('desde'))>100)
                    return Redirect::back()->withError(trans('main.Error: no es posible agregar mas de 100 habitaciones ha la vez'))->withInput();

                for ($i=Input::get('desde'); $i <= Input::get('hasta'); $i++) {
                    if(!Room::where('hotel_id', $hotel->id)->where('number_room', $i)->first()){
                        $payment  = Payment::where('user_id', $hotel->user_id)->first();
                        $plan = Plan::find($payment->plan_id);
                        $item = Room::where('hotel_id', $hotel->id)->count();
                        if($plan->rooms <= $item){
                        return Redirect::to('hotel/rooms')->withError(trans('main.Su plan ha llegado al limite de').$plan->rooms.' '.trans('main.rooms'));
                         }
                        $room = new Room;
                        $room->hotel_id = $hotel->id;
                        $room->number_room = $i;
                        $room->sector_id = Input::get('sector_id');
                        $room->state = Input::get('state');
                        $room->save();
                    }                    
                }
                return Redirect::to('hotel/rooms')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                if(!Room::where('hotel_id', $hotel->id)->where('number_room', Input::get('desde'))->first()){
                    $room = new Room;
                    $room->hotel_id = $hotel->id;
                    $room->number_room = Input::get('desde');
                    $room->sector_id = Input::get('sector_id');
                    $room->state = Input::get('state');
                    if($room->save()){
                        return Redirect::to('hotel/rooms')->withFlash_message(trans('main.Guardado Exitosamente'));
                    }else{
                        return Redirect::back()->withError(trans("main.Error"))->withInput();
                    }
                }else{
                    return Redirect::back()->withError(trans('main.Error esta habitacion ya existe'))->withInput();
                }
            }
            
        }
    }

    public function edit($id)
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $sectors = Sector::where('hotel_id', $hotel->id)->lists('name', 'id');
        $room = Room::where('id', $id)->where('hotel_id', $hotel->id)->first();
        if(!$room)
            return View::make('404');;

        return View::make('hotel.pages.edit_room')->withRoom($room)->withSectors($sectors);
    }

    public function update($id)
    {
        $data = array(
            "number_room" =>  Input::get("number_room"),
            "sector_id"   => Input::get('sector_id')
        );

        $rules = array(
            "number_room"  =>  'required|min:1|max:50',
            "sector_id"    =>  'required|min:1|max:50',
            "state"        =>  'min:1|max:5',
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
            $room = Room::where('id', $id)->where('hotel_id', $hotel->id)->first();
            $room->number_room = Input::get('number_room');
            $room->sector_id = Input::get('sector_id');
            $room->state = Input::get('state');
            if($room->save()){
                return Redirect::to('hotel/rooms')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
                return Redirect::back()->withErrors(trans("main.Error"))->withInput();
            }
        }
    }

    public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $room = Room::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($room){
          $staies = Stay::where('room_id', $room->id)->get();
          if(!$staies->isEmpty())
          {
            return Redirect::back()->withError(trans('main.Error: Existen un historial de estadias que pertenecen ha esta Habitacion'));
          }

          $room->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withErrors(trans("main.Error"));
        } 
    }
}