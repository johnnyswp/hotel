<?php
use Carbon\Carbon;
class ReceptionistController extends \BaseController {

	public function getIndex()
	{
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


		$user = Sentry::getUser();
		$hotel = Hotel::find($user->hotel_id);
		$lang_activos = LanguageHotel::where('hotel_id',$user->hotel_id)->where('state',1)->orderBy('main','DESC')->get();
		$lang_main = LanguageHotel::where('hotel_id',$user->hotel_id)->where('state',1)->where('main',1)->first();
		$rooms = Room::where('hotel_id',$user->hotel_id)->where('state',1)->where('condition',0)->get();

		return View::make('receptionists.pages.check_in')
			->withHotel($hotel)
			->withLangs($lang_activos)
			->withLang_main($lang_main)
			->withRooms($rooms)
			->withUser($user);
	}

	public function getStays()
	{
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');
       
		$user = Sentry::getUser();
		$hotel = Hotel::find($user->hotel_id);
		$stays = DB::table('stays')
                        ->join('rooms', 'rooms.id', '=', 'stays.room_id')
                        ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                        ->where('hotels.id','=',$hotel->id)
                        ->where('stays.state', 'Pending')
                        ->select('rooms.number_room as numero_habitacion', 
                                 'stays.id as id',
                                 'stays.name as nombre_huesped',
                                 'stays.opening_date as date_start',
                                 'stays.closing_date as date_end',
                                 'stays.start as hour_start',
                                 'stays.end as hour_end',
                                 'stays.state as status')
                        ->get();

		return View::make('receptionists.pages.stays')
			->withHotel($hotel)
			->withStays($stays)
			->withUser($user);
	}

    public function getAllStays()
    {
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


        $user = Sentry::getUser();
        $hotel = Hotel::find($user->hotel_id);
        $stays = DB::table('stays')
                        ->join('rooms', 'rooms.id', '=', 'stays.room_id')
                        ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                        ->where('hotels.id','=',$hotel->id)
                        ->select('rooms.number_room as numero_habitacion', 
                                 'stays.id as id',
                                 'stays.name as nombre_huesped',
                                 'stays.opening_date as date_start',
                                 'stays.closing_date as date_end',
                                 'stays.start as hour_start',
                                 'stays.end as hour_end',
                                 'stays.state as status')
                        ->get();

        return View::make('receptionists.pages.stays_search')
            ->withHotel($hotel)
            ->withStays($stays)
            ->withUser($user);
    }

	public function getStayEdit($id)
	{
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


		$user = Sentry::getUser();
		$stay = Stay::find($id);
		$hotel = Hotel::find($user->hotel_id);
		
        $lang_activos = LanguageHotel::where('hotel_id',$user->hotel_id)->where('state',1)->orderBy('main','DESC')->get();
		
        $lang_main = LanguageHotel::where('hotel_id',$user->hotel_id)->where('state',1)->where('main',1)->first();
		
        $rooms = Room::where('hotel_id',$user->hotel_id)->where('state',1)->get();
		
        $id_room = Room::where('hotel_id',$user->hotel_id)->where('state',1)->where('condition',0)->get();
		


        return View::make('receptionists.pages.check_in_edit')
			->withHotel($hotel)
			->withStay($stay)
			->withLangs($lang_activos)
			->withLang_main($lang_main)
			->withRooms($rooms)
			->withUser($user);
	}

	public function getStayDelete($id)
	{
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


		$room_id = Stay::find($id)->room_id;
		$room = Room::find($room_id);
		$room->condition=0;
		$room->save();
		$stay = Stay::find($id)->delete();	

		return  Redirect::to('/receptionist/stays');
	}

    public function getStayCheckOut()
    {
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


        $id = Input::get('id');
        $stay = Stay::find($id);
        if($stay){
             $stay->state ="check-out";
             $order = Order::whereIn('state', array('programmed','just_now','ready','delivered'))->where('stay_id', $stay->id)->first();
             if($order){
                return  Redirect::back()->with(array('error' => trans('main.msg chekout con pedido')));
             }
             if($stay->save())
             {
                 $room = Room::find($stay->room_id);
                 $room->condition = 0;
                 $room->save();
                 return  Redirect::back()->with(array('flash_message' => trans('main.Check out realizado con exito')));
             }
        }else{
            return  Redirect::back()->with(array('error' => trans('main.Error stadia invalida')));
        }
       
    }

	public function getFinish()
	{
		$user = Sentry::getUser();
		$hotel = Hotel::find($user->hotel_id);		
		return View::make('receptionists.pages.finish')
			->withHotel($hotel)
			->withUser($user);
	}

    public function anyOrders($stay_id)
    {
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

    	$hotel = Hotel::find(Hotel::id());
        $stay = Stay::where('id', $stay_id)->where('hotel_id', $hotel->id)->first();
        if(!$stay){
        	return View::make('404');
        }

        $orders = Order::where('state', '!=', 'not-send')->where('stay_id', $stay->id)->get();
    	return View::make('receptionists.pages.order')->with(array('orders'=>$orders, 'stay'=>$stay));
    }

    public function anyOrder($stay_id)
    {
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');


        $hotel = Hotel::find(Hotel::id());
        $stay = Stay::where('id', $stay_id)->where('hotel_id', $hotel->id)->first();
        if(!$stay){
            return View::make('404');
        }

        $orders = Order::where('state', '!=', 'not-send')->where('stay_id', $stay->id)->get();
        return View::make('receptionists.pages.order_search')->with(array('orders'=>$orders, 'stay'=>$stay));
    }

    public function anyAllOrder()
    {
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=1){ return View::make('404');}
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

        
        return View::make('receptionists.pages.order_all');
    }

    public function anyOrderAdd($stay_id)
    {
        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

    	$hotel = Hotel::find(Hotel::id());
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $stay = Stay::where('id', $stay_id)->where('hotel_id', $hotel->id)->first();
        if(!$stay){
        	return View::make('404');
        }
        
        $order = Order::where('stay_id', $stay->id)->where('state', 'not-send')->first();
        if(!$order){
            $order = new Order;
            $order->stay_id = $stay->id;
            $order->state = "not-send";
            $order->preparation_time = 0;
        }

        $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
        if(!$itemsOrders->isEmpty())
        {
            if($order->updated_at < Carbon::now()->subDay())
            {
                foreach ($itemsOrders as $itemOrder) {
                    $itemOrder->delete();
                }
            }
        }
        $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
        $order->delivery_time = Carbon::now();
        $order->hour_order = Carbon::now();
        $order->save();

        

        $categories = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();
        $items = Item::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();

    	return View::make('receptionists.pages.alta_order')->with(array('hotel'=>$hotel, 'lang'=>$lang, 'order'=>$order, 'itemsOrders'=>$itemsOrders, 'categories'=>$categories, 'items'=>$items, 'stay'=>$stay));
    }

    public function anyOrderSave()
    {
        $id = Input::get('order_id');
    	$order = Order::find($id);
    	$order->state = Input::get('state');
    	$order->delivery_time = Input::get('date');
    	if($order->save())
    	{
            return Redirect::to('receptionist/orders/'.$order->stay_id);
    	}
    }

    public function anyOrderRemove()
    {
       if(Input::has('id')){
           $item = ItemOrder::find(Input::get('id'));
           $sub_total = $item->price*$item->quantity;
           if($item->delete())
           {
            return Response::json(array('success'  => true, 'sub_total'  => $sub_total));
           }
       }else{
           return Response::json(array('success'  => false )); 
       }
    }

    public function anyOrderDelete()
    {
       if(Input::has('order_id')){
           $order = Order::find(Input::get('order_id'));
           $order->state= 'cancel';
           if($order->save())
           {
            return Redirect::back()->with('flash_message', trans('main.eliminado con exito'));
           }
       }else{
           return Redirect::back();
       }
    }

    public function anyOrderEdit($id)
    {
        $hotel = Hotel::find(Hotel::id());
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $order = Order::find($id);
        if($order){
            $stay = Stay::where('id', $order->stay_id)->where('hotel_id', $hotel->id)->first();
            if(!$stay){
                return View::make('404');
            }
            $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
            $categories = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();
            $items = Item::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();

            return View::make('receptionists.pages.edit_order')->with(array('hotel'=>$hotel, 'lang'=>$lang, 'order'=>$order, 'itemsOrders'=>$itemsOrders, 'categories'=>$categories, 'items'=>$items, 'stay'=>$stay));
        }else{
            return View::make('404');
        }
    }

     public function anyOrderDetail($id)
    {
        $hotel = Hotel::find(Hotel::id());
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        $order = Order::find($id);
        if($order){
            $stay = Stay::where('id', $order->stay_id)->where('hotel_id', $hotel->id)->first();
            if(!$stay){
                return View::make('404');
            }
            $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
            $categories = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->get();
            $items = Item::where('hotel_id', $hotel->id)->where('state', 1)->get();

            return View::make('receptionists.pages.detalle_order')->with(array('hotel'=>$hotel, 'lang'=>$lang, 'order'=>$order, 'itemsOrders'=>$itemsOrders, 'categories'=>$categories, 'items'=>$items, 'stay'=>$stay));
        }else{
            return View::make('404');
        }
    }

    public function anyOrderUpdate()
    {
        $id = Input::get('order_id');
        $order = Order::find($id);
        $order->state = Input::get('state');
        $order->delivery_time = Input::get('date');
        if($order->save())
        {
            return Redirect::to('receptionist/orders/'.$order->stay_id);
        }
    }

    public function anyIncrement()
    {
       $item = ItemOrder::find(Input::get('code'));
       $item->quantity = $item->quantity+1;
       if($item->save())
            return Response::json(array('success'  => true, 'price'  => $item->price, 'quantity'  => $item->quantity));
        else
            return Response::json(array('success'  => false )); 
    }

    public function anyDecrement()
    {
       $item = ItemOrder::find(Input::get('code'));
       if($item->quantity>=2){
            $item->quantity = $item->quantity-1;
            if($item->save())
                return Response::json(array('success'  => true, 'price'  => $item->price, 'quantity'  => $item->quantity));
            else
                return Response::json(array('success'  => false )); 
        }else{
            return Response::json(array('success'  => true, 'price'  => 0, 'quantity'  => $item->quantity));
        }
    }

    public function anyDataTable()
    {
         $hotel = Hotel::id();
         $table = 'stays';
         $primaryKey = 'id';
         $columns = array(
             array( 'db' => 'name', 'dt' => 0,'formatter' => function( $d, $row ) {
                     return utf8_encode($d);
                 }),
             array( 'db' => 'room_id',  'dt' => 1, 'formatter' => function( $d, $row ) {
                     $room = Room::find($d);
                     return utf8_encode($room->number_room);
                 }),
             array( 'db' => 'opening_date',   'dt' => 2, 'formatter' => function( $d, $row ) {
                     return date( 'd-m-Y', strtotime($d));
                 }
             ),
             array( 'db' => 'start',   'dt' => 3),
             array( 'db' => 'closing_date',   'dt' => 4, 'formatter' => function( $d, $row ) {
                     return date( 'd-m-Y', strtotime($d));
                 }
             ),
             array( 'db' => 'end',   'dt' => 5),
             array( 'db' => 'id',   'dt' => 6, 'formatter' => function( $d, $row ) {
                     return '<a class="btn btn-info btn-transparent" href="'.url('receptionist/order/'. $d).'" data-toggle="tooltip" data-placement="left" title="'.trans('main.orders').'"> Pedidos</a>';
            }),
         );
         $conf = Config::get('database');
         $sql_details = array(
             'user' => $conf['connections']['mysql']['username'],
             'pass' => $conf['connections']['mysql']['password'],
             'db'   => $conf['connections']['mysql']['database'],
             'host' => $conf['connections']['mysql']['host']
         );
         
         $filter = "`hotel_id` =".$hotel;
         return  Response::json(
             SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $filter )
         );
    }

    public function anyDataTableOrder()
    {
         $hotel = Hotel::id();
         $stays = Stay::where('hotel_id', $hotel)->lists('id');
         $table = 'orders';
         $primaryKey = 'id';
         $columns = array(
             array( 'db' => 'stay_id',  'dt' => 0, 'formatter' => function( $d, $row ) {
                     $stay = Stay::find($d);
                     return utf8_encode($stay->name);
                 }),
             array( 'db' => 'stay_id',  'dt' => 1, 'formatter' => function( $d, $row ) {
                     $stay = Stay::find($d);
                     $room = Room::find($stay->room_id);
                     return utf8_encode($room->number_room);
                 }),
             array( 'db' => 'delivery_time',   'dt' => 2, 'formatter' => function( $d, $row ) {
                     return date( 'd-m-Y H:i', strtotime($d));
                 }
             ),
             array( 'db' => 'state',   'dt' => 3, 'formatter' => function( $d, $row ) {
                     return trans('main.'.$d);
                 }
             ),
             array( 'db' => 'id',   'dt' => 4, 'formatter' => function( $d, $row ) {
                      $hotel = Hotel::find(Hotel::id());
                      $itemsOrders = ItemOrder::where('order_id', $d)->get();
                      $subtotal = 0;
                      foreach ($itemsOrders as $itemOrder) {
                         $subtotal = $subtotal+($itemOrder->price*$itemOrder->quantity);
                      }
                      return utf8_encode($hotel->exchanges->symbol." ".$subtotal);
                 }
             ),
             array( 'db' => 'id',   'dt' => 5, 'formatter' => function( $d, $row ) {
                      return '<a href="'.url('receptionist/order-detail/'. $d).'" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="color: white;"> '.trans('main.detalle').'</a>';
                 }
             ),
         );
         $conf = Config::get('database');
         $sql_details = array(
             'user' => $conf['connections']['mysql']['username'],
             'pass' => $conf['connections']['mysql']['password'],
             'db'   => $conf['connections']['mysql']['database'],
             'host' => $conf['connections']['mysql']['host']
         );
         if(!$stays)
            $filter = "`state` = 'vacio'";
         else
            $filter = "`stay_id` IN (".implode(',', $stays).") and `state` != 'not-send'";
         return  Response::json(
             SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $filter )
         );
    }
}