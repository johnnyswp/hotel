<?php
use Carbon\Carbon;
class ChefController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
        if(Sentry::getUser()->type_user!=3 and Sentry::getUser()->type_user!=0 and Sentry::getUser()->type_user!=2){ return View::make('404');}

        if(Payment::DisabledPayment()==false)
           return View::make('hotel.Payment.renews-payment');

		$hotel = Hotel::find(Hotel::id());
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		$stay = Stay::where('hotel_id', $hotel->id);

		$sec = Sector::where('hotel_id', $hotel->id)->get();
		$sectors = array('all'=>'all');
        foreach($sec as $s)
        {
            $sectors[$s->id] = $s->name;
        }

		if(Input::has('sector') and Input::get('sector')!="all"){
            $rooms = Room::where('sector_id', Input::get('sector'))->lists('id');
		    $stay = $stay->whereIn('room_id',$rooms);
		}
		$categories = Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();
        $items = Item::where('hotel_id', $hotel->id)->where('state', 1)->orderBy('order', 'ASC')->get();

		$ordersProgrammed = Order::where('state', 'programmed')->whereIn('stay_id',$stay->lists('id'));
		$ordersJust = Order::where('state', 'just_now')->whereIn('stay_id',$stay->lists('id'))->get();
		$ordersReady = Order::where('state', 'ready')->whereIn('stay_id',$stay->lists('id'))->get();
		$ordersDelivered = Order::where('state', 'delivered')->whereIn('stay_id',$stay->lists('id'))->get();
		return View::make('chef.dashboard')->with(array(
                'ordersProgrammed' => $ordersProgrammed->get(),
                'ordersJust'       => $ordersJust,
                'ordersReady'      => $ordersReady,
                'ordersDelivered'  => $ordersDelivered,
                'sectors'          => $sectors,
                'categorys'        => $categories,
                'items'            => $items,
                'lang'             => $lang,
                'hotel'            => $hotel,
			));
	}

    public function anyChangeState()
	{
		$id = Input::get('id');
		$order = Order::find($id);

		if($order->state=="programmed")
			$state = 'just_now';
		elseif($order->state=="just_now")
			$state = 'ready';
		elseif($order->state=="ready")
			$state = 'delivered';
        elseif($order->state=="delivered")
            $state = 'finalized';
        
        $order->state = $state;
        if($order->save())
        	return Response::json(array('success'  => true, 'state' => $order->state));
        else
        	return Response::json(array('success'  => false ));		
	}

	public function anyChangeState2()
	{
		$id = Input::get('id');
		$order = Order::find($id);
        $order->state = Input::get('state');
        if($order->save())
        	return Response::json(array('success'  => true, 'state' => $order->state));
        else
        	return Response::json(array('success'  => false ));
		
	}

	public function anyRemoveItem()
	{
		$id = Input::get('id');
		$item = ItemOrder::find($id);
		
        if($item->delete()){
            $order_id = $item->order_id;
        	$count = ItemOrder::where('order_id', $order_id)->count();
        	return Response::json(array('success'  => true, 'count'=>$count, 'code'=>$order_id));
        }else
        	return Response::json(array('success'  => false ));
		
	}

	public function anyRemoveOrder()
	{
		$id = Input::get('id');
		$item = Order::find($id);
        if($item->delete()){
        	return Response::json(array('success'  => true));
        }else
        	return Response::json(array('success'  => false ));
	}

	public function anyAddItem()
	{
		$data = array(
            "item"     =>  Input::file("item"),
            "quantity" =>  Input::file("quantity"),
            "category" =>  Input::file("category"),
        );

        $rules = array(
            "item"     =>  'required|min:1',
            "quantity" =>  'required|min:1',
            "category" =>  'required|min:1',
        );
                
        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {    
        	return Response::json(array(
                'success' => false,
                'errors' => $validation->getMessageBag()->toArray()
            ));
        }else{

            $order = Order::find(Input::get('order_id'));
            if($order){
            	$item = Item::find(Input::get('item'));
            	if($item)
            	{
            		$itemOrder = ItemOrder::where('order_id', $order->id)->where('name_item_menu_id', $item->id)->first();
            		if($itemOrder){
        			$quantity = $itemOrder->quantity+Input::get('quantity');
        			if($quantity<1){
                    	$quantity = 1;
                    }elseif($quantity>25){
                    	$quantity = 25;
                    }
                    $itemOrder->quantity = $quantity;
                    if($itemOrder->save()){
                    	$hotel = Hotel::find(Hotel::id());
                    	$lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                        $name = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
                        return Response::json(array(
                        	'success'  => true,
                        	'update'  => true,
                        	'id'  => $itemOrder->id,
                        	'quantity'  => $itemOrder->quantity,
                            'price' => $itemOrder->price,

                        	));
                    }else
                        return Response::json(array('success'  => false ));
            		}else{
            			$itemOrder = new ItemOrder;
                        $itemOrder->order_id         = Input::get('order_id');
                        
                        $quantity = Input::get('quantity');
                        if(Input::get('quantity')<1){
                        	$quantity = 1;
                        }elseif(Input::get('quantity')>25){
                        	$quantity = 25;
                        }
    
                        $itemOrder->quantity         = $quantity;
                        $itemOrder->price            = $item->price;
                        $itemOrder->name_item_menu_id= Input::get('item');
                        if($itemOrder->save()){
                        	if($item->delivery_time > $order->preparation_time)
                        	{
                               $time = $item->delivery_time-$order->preparation_time;
                               $order->delivery_time =  Carbon::parse($order->delivery_time)->addMinutes($time)->toDateTimeString(); 
                               $order->preparation_time = $item->delivery_time;
                               $order->save();
                        	}
                        	$hotel = Hotel::find(Hotel::id());
                        	$lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                            $name = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
                            return Response::json(array(
                            	'success'  => true,
                            	'update'  => false,
                            	'id'  => $itemOrder->id,
                            	'order_id'  => $itemOrder->order_id,
                            	'price'  => $itemOrder->price,
                            	'name'  => $name->name,
                            	'quantity'  => $itemOrder->quantity,
                            	'delivery' => Carbon::parse($order->delivery_time)->format('d-m-Y g:i'),
                            	'count' =>  ItemOrder::where('order_id', $itemOrder->order_id)->count()
                            ));
                        }else
                            return Response::json(array('success'  => false));
            		}
    
                    $itemOrder->order_id         = Input::get('order_id');
                    $itemOrder->quantity         = Input::get('quantity');
                    $itemOrder->price            = $item->price;
                    $itemOrder->name_item_menu_id= Input::get('item');
                    if($itemOrder->save()){
                    	$hotel = Hotel::find(Hotel::id());
                    	$lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                        $name = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
                   	    return Response::json(array(
                   	    	'success'  => true,
                   	    	'id'  => $itemOrder->id,
                   	    	'order_id'  => $itemOrder->order_id,
                   	    	'price'  => $itemOrder->price,
                   	    	'name'  => $name->name,
                   	    	'quantity'  => $itemOrder->quantity
    
                   	    	));
                    }else
                   	    return Response::json(array('success'  => false ));
            	}else{
            		return Response::json(array('success'  => false ));
            	}
            	
            }else{
            	return Response::json(array('success'  => false ));
            }
        }
	}

	public function anyEditItem()
	{
		$id = Input::get('id');
		$val = Input::get('value');
		$orderItem = ItemOrder::find($id);
        $orderItem->quantity = $val;
        if($orderItem->save())
        	return Response::json(array('success'  => true));
        else
        	return Response::json(array('success'  => false ));
	}

	public function anyFilterItems()
	{
		$id = Input::get('code');
		$items = Item::where('category_id', $id)->get();
		$hotel = Hotel::find(Hotel::id());
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
		foreach ($items as $item){
            $name = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
			echo "<option value='".$item->id."'>". $name->name."</option>";
		}
	}

    public function anyFilterCategory()
    {
        $hotel = Hotel::find(Hotel::id());

        $categorys = Category_menu::where('hotel_id', $hotel->id)->get();
        $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
        foreach($categorys as $category)
        {
            $name = Name_category_menu::where('language_id', $lang->language_id)->where('category_menu_id', $category->id)->first();
            echo "<option value='".$category->id."'>". $name->name."</option>";
        }
    }

    public function anyAutoUpdate()
    {
        set_time_limit(0);
        $fecha_ac = Input::has('datetime') ? Input::get('datetime'):Carbon::now();
        $hotel = Hotel::find(Hotel::id());
        $stays = Stay::where('hotel_id', $hotel->id)->lists('id');

        $state = array('programmed', 'cancel', 'just_now');
        $fecha_db = Order::whereIn('stay_id', $stays)->whereIn('state', $state)->orderBy('updated_at', 'DESC')->first();
        if($fecha_db){
            $date = $fecha_db->updated_at;
        }else{
            $date = '0000-00-00 00:00:00';
        }
        
        while ($date <= $fecha_ac){
            $or = Order::whereIn('stay_id', $stays)->whereIn('state', $state)->orderBy('updated_at', 'DESC')->first();
            if($or){
                $date = $or->updated_at;
            }
            usleep(100000);
            clearstatcache();
        }
    
        $orders = Order::whereIn('stay_id', $stays)->whereIn('state', $state)->orderBy('updated_at', 'DESC')->first();
        
        if($orders){
            if($orders->state=='cancel'){
                return Response::json(array(
                    'success'    => true,
                    'id'         => $orders->id,
                    'updated_at' => $orders->updated_at,
                    'state'      => 'cancel'
                ));
            }
            $stay = Stay::find($orders->stay_id);
            $hotel = Hotel::find(Hotel::id());
            $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
            $itemsOrders = ItemOrder::where('order_id', $orders->id)->get();
            $room = Room::find($stay->room_id);
            $items = array();
            $x = 0;
            foreach ($itemsOrders as $value) {
                $itemName = NameItem::where('item_id',$value->name_item_menu_id)->where('language_id',$lang->language_id)->first();
                $items[$x]['id'] = $value->id;
                $items[$x]['name'] = $itemName->name;
                $items[$x]['price'] = $value->price;
                $items[$x]['quantity'] = $value->quantity;
                $items[$x]['quantity'] = $value->quantity;
                $x++;
            }
            return Response::json(array(
                'success' => true,
                'id'               => $orders->id,
                'preparation_time' => $orders->preparation_time,
                'delivery_time2'    => Carbon::parse($orders->delivery_time)->format('d-m-Y H:i'),
                'delivery_time'    => $orders->delivery_time,
                'hour_order'       => Carbon::parse($orders->hour_order)->format('d-m-Y H:i'),
                'updated_at'       => $orders->updated_at,
                'number_room'      => $room ? $room->number_room : 0,
                'stay'             => $stay,
                'itemsCount'       => $itemsOrders->count(),
                'items'            => $items,
                'state'            => $orders->state,
                'name'             => $stay->name,
            ));
        }else{
            usleep(100000);
            clearstatcache();
            return Response::json(array(
                    'success' => false
                ));
        }
    }
}