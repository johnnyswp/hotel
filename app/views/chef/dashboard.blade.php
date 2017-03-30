@extends('chef.master')
<?php use Carbon\Carbon; ?>
@section('title', trans('main.cocina'))

@section('content')

@if (Session::has('flash_message'))
    <p>{{Session::get('flash_message')}}</p>
@endif
<?php
$horas = new DateInterval('PT5M');
$date = new DateTime('NOW');
$date = $date->add($horas);
$date = $date->format(DateTime::ISO8601);

$horas2 = new DateInterval('PT6M');

$date2 = new DateTime('NOW', new DateTimeZone('America/El_Salvador'));
$date2 = $date2->add($horas2);
$date2 = $date2->format('Y/m/d H:i:s');
?>

<!-- START CONTENT FRAME -->
<div class="content-frame">     
    <!-- START CONTENT FRAME TOP -->
    <div class="content-frame-top">                        
        <div class="page-title">                    
            <h2><span class="fa fa-bars"></span> {{trans('main.orders')}}</h2>
        </div>                                                                               
        <div class="pull-right" style="width: 100px; margin-right: 5px;">
        <div style="float: right; position: absolute; margin-left: -61px;">

        {{ Form::open(array('url' =>'/chef', 'class' => 'filters', 'method' => 'GET')) }}
            {{ Form::select('sector',$sectors, Input::get('sector') ? e(Input::get('sector')) : 'all', array('class' => 'form-control select filter')) }}
        {{ Form::close() }}
        </div>
        <div style="position: absolute; float: left;">
            {{ Form::open(array('url' =>'/lang', 'class' => 'filters', 'method' => 'GET')) }}
                {{ Form::select('lang',Language::where('state',1)->lists('language', 'sufijo'), Helpers::lang(), array('class'         =>             'selectpicker form-control select change-lang')) }}
            {{ Form::close() }}
        </div>
    </div>

    
    <!-- START CONTENT FRAME BODY -->
    <div class="content-frame-body">
        <div class="row push-up-10">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <h3>{{trans('main.Pedidos programados')}}</h3>
                <div class="tasks" id="tasks_scheduled">
                @foreach($ordersProgrammed as $order)
                    <?php
                    $hotel = Hotel::find(Hotel::id());
                    $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                    $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
                    $stay = Stay::find($order->stay_id);
                    $room = Room::find($stay->room_id);
                    ?>
                    <div state="programmed" class="task-item item-{{$order->id}}" id="{{$order->id}}" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}">
                        <a href="#" class="circle blue next-board" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="{{$order->state}}">
                            <i class="fa fa-arrow-right btn-right"></i>                         
                        </a>
                        <div class="task-text">
                            <p>
                               {{trans('main.room')}} <span><b>{{$room->number_room}}</b></span>
                            </p>
                            <p class="ml-10">
                                {{trans('main.items')}}: 
                                <a href="#" class="show_item" cod="{{$order->id}}">
                                    <span class="bag-item count-item-{{$order->id}}">
                                        <b>{{$itemsOrders->count()}}</b>
                                    </span>
                                </a> 
                            </p>
                            <!--<p class="both"> {{trans('main.Entrega')}}: <span> <b><script>document.write(moment("{{$date}}", 'YYYY-MM-DDTHH:mm:ssZ').fromNow());</script> </b></span>-->
                            <p class="both">
                                {{trans('main.Entrega')}}: 
                                <span class="delivery-order-{{$order->id}}"> 
                                    <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}}</b>
                                </span>
                            </p>
                            <p class="ml-10">
                                <span class="clock_finish clock-finish-{{$order->id}}" date="{{$order->delivery_time}}"></span>
                            </p>
                        </div>  
                        <div id="task-accordion-{{$order->id}}" class="panel-group accordion">
                            <div class="panel-body" style="display:block;padding-top: 0;">
                            <hr class="hr">
                                <p class="mb-3">{{trans('main.huesped')}}: <span> <b> {{$stay->name}}</b> </span></p>
                                <p class="mb-3" style="margin: 0 0 -15px !important;">{{trans('main.Horario Pedido')}}: <span> <b>{{Carbon::parse($order->hour_order)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.Horario')}} {{trans('main.Entrega')}}: <span class="delivery-order-{{$order->id}}"> <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.state')}}: 
                                    <span> 
                                        <b id="btn-state-{{$order->id}}">
                                        @if($order->state=="programmed")
                                            <span class="btn btn-success btn-xs state"> {{trans('main.programmed')}} </span>
                                        @elseif($order->state=="just_now")
                                            <span class="btn btn-warning btn-xs state"> {{trans('main.just_now')}} </span>
                                        @elseif($order->state=="ready")
                                            <span class="btn btn-danger btn-xs state"> {{trans('main.ready')}} </span>
                                        @elseif($order->state=="delivered")
                                            <span class="btn btn-info btn-xs state"> {{trans('main.delivered')}} </span>
                                        @endif
                                        </b> 
                                    </span>
                                </p>
                                <p>
                                    <div class="form-group" id="btns-states-{{$order->id}}">
                                        
                                        <div class="col-md-4 programmed" style="padding: 3px; @if($order->state=='programmed') display: none; @endif">
                                            <button class="btn btn-success btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="programmed">{{trans('main.programmed')}}</button>
                                        </div>
                                        
                                        <div class="col-md-4 just_now" style="padding: 3px; @if($order->state=='just_now') display: none; @endif">
                                            <button class="btn btn-warning btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="just_now">{{trans('main.just_now')}}</button>
                                        </div> 

                                        <div class="col-md-4 ready" style="padding: 3px; @if($order->state=='ready') display: none; @endif">
                                            <button class="btn btn-danger btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="ready">{{trans('main.ready')}}</button>
                                        </div> 
                                        
                                        <div class="col-md-4 delivered" style="padding: 3px; @if($order->state=='delivered') display: none; @endif">
                                            <button class="btn btn-info btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="delivered">{{trans('main.delivered')}}</button>
                                        </div>
                                                 
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2"></div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                           <button class="btn  btn-block new-item" order="{{$order->id}}" style="margin-top: 2px !important; color:#33414E;">{{trans('main.add item')}}</button>
                                        </div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                            <button class="btn  btn-block order-delete" code="{{$order->id}}" style="color:#33414E; margin-top: 2px !important;">{{trans('main.delete')}} {{trans('main.order')}}</button>
                                        </div> 
                                        <div class="col-md-2"></div>             
                                    </div>
                                </p>
                            </div>
                            <div class="panel-items-{{$order->id}}">
                            @foreach($itemsOrders as $itemOrder)
                                <?php
                                $itemName = NameItem::where('item_id',$itemOrder->name_item_menu_id)->where('language_id',$lang->language_id)->first();
                                ?>
                                <div class="panel element-{{$itemOrder->id}}">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#accOneColOne" class="">
                                                <span class="col-md-4" style="padding: 0;">@if($itemName) {{$itemName->name}} @endif</span>
                                                <span  class="col-md-2" style="padding: 0;"><b> ${{$itemOrder->price}}</b></span>
                                                <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-{{$itemOrder->id}}" data-min="1" data-max="25" value="{{$itemOrder->quantity}}" code="{{$itemOrder->id}}"></span> 
                                            </a>
                                            <ul class="panel-controls">                                                                        
                                                <li><a href="#"  class="mb-control delete" code="{{$itemOrder->id}}" ><span class="fa fa-trash-o"></span></a></li>
                                            </ul>
                                        </h4>
    
                                    </div>                                
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <!-- END ACCORDION -->                          
                    </div>
                @endforeach
                </div>                            
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <h3>{{trans('main.Pedidos a preparar')}}</h3>
                <div class="tasks" id="tasks_progreess">                                
                @foreach($ordersJust as $order)
                    <?php
                    $hotel = Hotel::find(Hotel::id());
                    $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                    $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
                    $stay = Stay::find($order->stay_id);
                    $room = Room::find($stay->room_id);
                    ?>
                    <div state="just_now" class="task-item item-{{$order->id}} task-scheduled" id="{{$order->id}}" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}">
                        <a href="#" class="circle blue next-board" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="{{$order->state}}">
                            <i class="fa fa-arrow-right btn-right"></i>                         
                        </a>
                        <div class="task-text">
                            <p>
                               {{trans('main.room')}} <span><b>{{$room->number_room}}</b></span>
                            </p>
                            <p class="ml-10">
                                {{trans('main.items')}}: 
                                <a href="#" class="show_item" cod="{{$order->id}}">
                                    <span class="bag-item count-item-{{$order->id}}">
                                        <b>{{$itemsOrders->count()}}</b>
                                    </span>
                                </a> 
                            </p>
                            <!--<p class="both"> {{trans('main.Entrega')}}: <span> <b><script>document.write(moment("{{$date}}", 'YYYY-MM-DDTHH:mm:ssZ').fromNow());</script> </b></span>-->
                            <p class="both">
                                {{trans('main.Entrega')}}: 
                                <span class="delivery-order-{{$order->id}}"> 
                                    <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}}</b>
                                </span>
                            </p>
                            <p class="ml-10">
                                <span class="clock_finish clock-finish-{{$order->id}}" date="{{$order->delivery_time}}"></span>
                            </p>
                        </div>  
                        <div id="task-accordion-{{$order->id}}" class="panel-group accordion">
                            <div class="panel-body" style="display:block;padding-top: 0;">
                            <hr class="hr">
                                <p class="mb-3">{{trans('main.huesped')}}: <span> <b> {{$stay->name}}</b> </span></p>
                                <p class="mb-3" style="margin: 0 0 -15px !important;">{{trans('main.Horario Pedido')}}: <span> <b>{{Carbon::parse($order->hour_order)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.Horario')}} {{trans('main.Entrega')}}: <span class="delivery-order-{{$order->id}}"> <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.state')}}: 
                                    <span> 
                                        <b id="btn-state-{{$order->id}}">
                                        @if($order->state=="programmed")
                                            <span class="btn btn-success btn-xs state"> {{trans('main.programmed')}} </span>
                                        @elseif($order->state=="just_now")
                                            <span class="btn btn-warning btn-xs state"> {{trans('main.just_now')}} </span>
                                        @elseif($order->state=="ready")
                                            <span class="btn btn-danger btn-xs state"> {{trans('main.ready')}} </span>
                                        @elseif($order->state=="delivered")
                                            <span class="btn btn-info btn-xs state"> {{trans('main.delivered')}} </span>
                                        @endif
                                        </b> 
                                    </span>
                                </p>
                                <p>
                                    <div class="form-group" id="btns-states-{{$order->id}}">
                                       
                                        <div class="col-md-4 programmed" style="padding: 3px; @if($order->state=='programmed') display: none; @endif">
                                            <button class="btn btn-success btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="programmed">{{trans('main.programmed')}}</button>
                                        </div>

                                        <div class="col-md-4 just_now" style="padding: 3px; @if($order->state=='just_now') display: none; @endif">
                                            <button class="btn btn-warning btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="just_now">{{trans('main.just_now')}}</button>
                                        </div> 
      
                                        <div class="col-md-4 ready" style="padding: 3px; @if($order->state=='ready') display: none; @endif">
                                            <button class="btn btn-danger btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="ready">{{trans('main.ready')}}</button>
                                        </div> 
 
                                        <div class="col-md-4 delivered" style="padding: 3px; @if($order->state=='delivered') display: none; @endif">
                                            <button class="btn btn-info btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="delivered">{{trans('main.delivered')}}</button>
                                        </div>
        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2"></div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                           <button class="btn  btn-block new-item" order="{{$order->id}}" style="margin-top: 2px !important; color:#33414E;">{{trans('main.add item')}}</button>
                                        </div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                            <button class="btn  btn-block order-delete" code="{{$order->id}}" style="color:#33414E; margin-top: 2px !important;">{{trans('main.delete')}} {{trans('main.order')}}</button>
                                        </div> 
                                        <div class="col-md-2"></div>             
                                    </div>
                                </p>
                            </div>
                            <div class="panel-items-{{$order->id}}">
                            @foreach($itemsOrders as $itemOrder)
                                <?php
                                $itemName = NameItem::where('item_id',$itemOrder->name_item_menu_id)->where('language_id',$lang->language_id)->first();
                                ?>
                                <div class="panel element-{{$itemOrder->id}}">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#accOneColOne" class="">
                                                <span class="col-md-4" style="padding: 0;">@if($itemName) {{$itemName->name}} @endif</span>
                                                <span  class="col-md-2" style="padding: 0;"><b> ${{$itemOrder->price}}</b></span>
                                                <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-{{$itemOrder->id}}" data-min="1" data-max="25" value="{{$itemOrder->quantity}}" code="{{$itemOrder->id}}"></span> 
                                            </a>
                                            <ul class="panel-controls">                                                                        
                                                <li><a href="#"  class="mb-control delete" code="{{$itemOrder->id}}" ><span class="fa fa-trash-o"></span></a></li>
                                            </ul>
                                        </h4>
    
                                    </div>                                
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <!-- END ACCORDION -->                          
                    </div>
                @endforeach
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <h3>{{trans('main.Pedidos en preparacion')}} </h3>
                <div class="tasks" id="tasks_preparing">
                @foreach($ordersReady as $order)
                    <?php
                    $hotel = Hotel::find(Hotel::id());
                    $lang = LanguageHotel::where('main', 1)->where('hotel_id', $hotel->id)->first();
                    $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
                    $stay = Stay::find($order->stay_id);
                    $room = Room::find($stay->room_id);
                    ?>
                    <div state="ready" class="task-item item-{{$order->id}} task-scheduled" id="{{$order->id}}" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}">
                        <a href="#" class="circle blue next-board" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="{{$order->state}}">
                            <i class="fa fa-arrow-right btn-right"></i>                         
                        </a>
                        <div class="task-text">
                            <p>
                               {{trans('main.room')}} <span><b>{{$room->number_room}}</b></span>
                            </p>
                            <p class="ml-10">
                                {{trans('main.items')}}: 
                                <a href="#" class="show_item" cod="{{$order->id}}">
                                    <span class="bag-item count-item-{{$order->id}}">
                                        <b>{{$itemsOrders->count()}}</b>
                                    </span>
                                </a> 
                            </p>
                            <!--<p class="both"> {{trans('main.Entrega')}}: <span> <b><script>document.write(moment("{{$date}}", 'YYYY-MM-DDTHH:mm:ssZ').fromNow());</script> </b></span>-->
                            <p class="both">
                                {{trans('main.Entrega')}}: 
                                <span class="delivery-order-{{$order->id}}"> 
                                    <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}}</b>
                                </span>
                            </p>
                            <p class="ml-10">
                                <span class="clock_finish clock-finish-{{$order->id}}" date="{{$order->delivery_time}}"></span>
                            </p>
                        </div>  
                        <div id="task-accordion-{{$order->id}}" class="panel-group accordion">
                            <div class="panel-body" style="display:block;padding-top: 0;">
                            <hr class="hr">
                                <p class="mb-3">{{trans('main.huesped')}}: <span> <b> {{$stay->name}}</b> </span></p>
                                <p class="mb-3" style="margin: 0 0 -15px !important;">{{trans('main.Horario Pedido')}}: <span> <b>{{Carbon::parse($order->hour_order)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.Horario')}} {{trans('main.Entrega')}}: <span class="delivery-order-{{$order->id}}"> <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.state')}}: 
                                    <span> 
                                        <b id="btn-state-{{$order->id}}">
                                        @if($order->state=="programmed")
                                            <span class="btn btn-success btn-xs state"> {{trans('main.programmed')}} </span>
                                        @elseif($order->state=="just_now")
                                            <span class="btn btn-warning btn-xs state"> {{trans('main.just_now')}} </span>
                                        @elseif($order->state=="ready")
                                            <span class="btn btn-danger btn-xs state"> {{trans('main.ready')}} </span>
                                        @elseif($order->state=="delivered")
                                            <span class="btn btn-info btn-xs state"> {{trans('main.delivered')}} </span>
                                        @endif
                                        </b> 
                                    </span>
                                </p>
                                <p>
                                    <div class="form-group" id="btns-states-{{$order->id}}">
                                        
                                        <div class="col-md-4 programmed" style="padding: 3px; @if($order->state=='programmed') display: none; @endif">
                                            <button class="btn btn-success btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="programmed">{{trans('main.programmed')}}</button>
                                        </div>
                                        
                                        <div class="col-md-4 just_now" style="padding: 3px; @if($order->state=='just_now') display: none; @endif">
                                            <button class="btn btn-warning btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="just_now">{{trans('main.just_now')}}</button>
                                        </div> 

                                        <div class="col-md-4 ready" style="padding: 3px; @if($order->state=='ready') display: none; @endif">
                                            <button class="btn btn-danger btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="ready">{{trans('main.ready')}}</button>
                                        </div> 
                                        
                                        <div class="col-md-4 delivered" style="padding: 3px; @if($order->state=='delivered') display: none; @endif">
                                            <button class="btn btn-info btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="delivered">{{trans('main.delivered')}}</button>
                                        </div>
                                                 
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2"></div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                           <button class="btn  btn-block new-item" order="{{$order->id}}" style="margin-top: 2px !important; color:#33414E;">{{trans('main.add item')}}</button>
                                        </div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                            <button class="btn  btn-block order-delete" code="{{$order->id}}" style="color:#33414E; margin-top: 2px !important;">{{trans('main.delete')}} {{trans('main.order')}}</button>
                                        </div> 
                                        <div class="col-md-2"></div>             
                                    </div>
                                </p>
                            </div>
                            <div class="panel-items-{{$order->id}}">
                            @foreach($itemsOrders as $itemOrder)
                                <?php
                                $itemName = NameItem::where('item_id',$itemOrder->name_item_menu_id)->where('language_id',$lang->language_id)->first();
                                ?>
                                <div class="panel element-{{$itemOrder->id}}">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#accOneColOne" class="">
                                                <span class="col-md-4" style="padding: 0;">@if($itemName) {{$itemName->name}} @endif</span>
                                                <span  class="col-md-2" style="padding: 0;"><b> ${{$itemOrder->price}}</b></span>
                                                <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-{{$itemOrder->id}}" data-min="1" data-max="25" value="{{$itemOrder->quantity}}" code="{{$itemOrder->id}}"></span> 
                                            </a>
                                            <ul class="panel-controls">                                                                        
                                                <li><a href="#"  class="mb-control delete" code="{{$itemOrder->id}}" ><span class="fa fa-trash-o"></span></a></li>
                                            </ul>
                                        </h4>
    
                                    </div>                                
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <!-- END ACCORDION -->                          
                    </div>
                @endforeach
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <h3>{{trans('main.Pedidos entregados')}}</h3>
                <div class="tasks" id="tasks_completed">
                @foreach($ordersDelivered as $order)
                    <?php
                    $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
                    $stay = Stay::find($order->stay_id);
                    $room = Room::find($stay->room_id);
                    ?>
                    <div state="delivered" class="task-item item-{{$order->id}}" id="{{$order->id}}" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}">
                        <a href="#" class="circle blue next-board" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="{{$order->state}}">
                            <i class="fa fa-arrow-right btn-right"></i>                         
                        </a>
                        <div class="task-text">
                            <p>
                               {{trans('main.room')}} <span><b>{{$room->number_room}}</b></span>
                            </p>
                            <p class="ml-10">
                                {{trans('main.items')}}: 
                                <a href="#" class="show_item" cod="{{$order->id}}">
                                    <span class="bag-item count-item-{{$order->id}}" >
                                        <b>{{$itemsOrders->count()}}</b>
                                    </span>
                                </a> 
                            </p>
                            <!--<p class="both"> {{trans('main.Entrega')}}: <span> <b><script>document.write(moment("{{$date}}", 'YYYY-MM-DDTHH:mm:ssZ').fromNow());</script> </b></span>-->
                            <p class="both">
                                {{trans('main.Entrega')}}: 
                                <span class="delivery-order-{{$order->id}}"> 
                                    <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}}</b>
                                </span>
                            </p>
                            <p class="ml-10">
                                <span class="clock_finish clock-finish-{{$order->id}}" date="{{$order->delivery_time}}"></span>
                            </p>
                        </div>  
                        <div id="task-accordion-{{$order->id}}" class="panel-group accordion">
                            <div class="panel-body" style="display:block;padding-top: 0;">
                            <hr class="hr">
                                <p class="mb-3">{{trans('main.huesped')}}: <span> <b> {{$stay->name}}</b> </span></p>
                                <p class="mb-3" style="margin: 0 0 -15px !important;">{{trans('main.Horario Pedido')}}: <span> <b>{{Carbon::parse($order->hour_order)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.Horario')}} {{trans('main.Entrega')}}: <span class="delivery-order-{{$order->id}}"> <b>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </b> </span></p>
                                <p class="mb-3" style="display: none">{{trans('main.state')}}: 
                                    <span> 
                                        <b id="btn-state-{{$order->id}}">
                                        @if($order->state=="programmed")
                                            <span class="btn btn-success btn-xs state"> {{trans('main.programmed')}} </span>
                                        @elseif($order->state=="just_now")
                                            <span class="btn btn-warning btn-xs state"> {{trans('main.just_now')}} </span>
                                        @elseif($order->state=="ready")
                                            <span class="btn btn-danger btn-xs state"> {{trans('main.ready')}} </span>
                                        @elseif($order->state=="delivered")
                                            <span class="btn btn-info btn-xs state"> {{trans('main.delivered')}} </span>
                                        @endif
                                        </b> 
                                    </span>
                                </p>
                                <p>
                                    <div class="form-group" id="btns-states-{{$order->id}}">
                                        <div class="col-md-4 programmed" style="padding: 3px; @if($order->state=='programmed') display: none; @endif">
                                            <button class="btn btn-success btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="programmed">{{trans('main.programmed')}}</button>
                                        </div>
                                        
                                        <div class="col-md-4 just_now" style="padding: 3px; @if($order->state=='just_now') display: none; @endif">
                                            <button class="btn btn-warning btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="just_now">{{trans('main.just_now')}}</button>
                                        </div> 

                                        <div class="col-md-4 ready" style="padding: 3px; @if($order->state=='ready') display: none; @endif">
                                            <button class="btn btn-danger btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="ready">{{trans('main.ready')}}</button>
                                        </div> 
                                        
                                        <div class="col-md-4 delivered" style="padding: 3px; @if($order->state=='delivered') display: none; @endif">
                                            <button class="btn btn-info btn-block btn-chage" style="" preparation="{{$order->preparation_time}}" delivery="{{$order->delivery_time}}" code="{{$order->id}}" state="delivered">{{trans('main.delivered')}}</button>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2"></div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                            <button class="btn  btn-block new-item" order="{{$order->id}}" style="margin-top: 2px !important; color:#33414E;">{{trans('main.add item')}}</button>
                                        </div> 
                                        <div class="col-md-4" style="padding: 3px;">
                                            <button class="btn  btn-block order-delete" code="{{$order->id}}" style="color:#33414E; margin-top: 2px !important;">{{trans('main.delete')}} {{trans('main.order')}}</button>
                                        </div> 
                                        <div class="col-md-2"></div>             
                                    </div>
                                </p>
                            </div>
                            <div class="panel-items-{{$order->id}}">
                            @foreach($itemsOrders as $itemOrder)
                                <?php
                                $itemName = NameItem::where('item_id',$itemOrder->name_item_menu_id)->where('language_id',$lang->language_id)->first();
                                ?>
                                <div class="panel element-{{$itemOrder->id}}">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="" class="">
                                                <span class="col-md-4" style="padding: 0;">@if($itemName) {{$itemName->name}} @endif</span>
                                                <span  class="col-md-2" style="padding: 0;"><b> ${{$itemOrder->price}}</b></span>
                                                <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-{{$itemOrder->id}}"  data-min="1" data-max="25" value="{{$itemOrder->quantity}}" code="{{$itemOrder->id}}"></span> 
                                            </a>
                                            <ul class="panel-controls">                                                                        
                                                <li><a href="#"  class="mb-control delete" code="{{$itemOrder->id}}" ><span class="fa fa-trash-o"></span></a></li>
                                            </ul>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <!-- END ACCORDION -->
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="form_notice_item" style="display: none;">
        <div class="pf-element pf-heading">
          <h3 style="color:white;">{{trans('main.confirm delete item')}}</h3>
          <p></p>
        </div>
        <div class="pf-element pf-buttons pf-centered">
          <input class="pf-button btn btn-primary btn-delete" type="button" name="submit" value="{{trans('main.confirm')}}" />
          <input class="pf-button btn btn-default btn-calcel" type="button" name="cancel" value="{{trans('main.cancel')}}" />
        </div>
    </div>

    <div id="form_notice_order" style="display: none;">
        <div class="pf-element pf-heading">
          <h3 style="color:white;">{{trans('main.confirm delete order')}}</h3>
          <p></p>
        </div>
        <div class="pf-element pf-buttons pf-centered">
          <input class="pf-button btn btn-primary btn-delete" type="button" name="submit" value="{{trans('main.confirm')}}" />
          <input class="pf-button btn btn-default btn-calcel" type="button" name="cancel" value="{{trans('main.cancel')}}" />
        </div>
    </div>

    <!-- END CONTENT FRAME BODY -->
    <style type="text/css">
      a.filtros {
              background-color: rgba(148, 148, 148, 0.43);
              padding: 10px 15px 10px 15px;
              margin-bottom: 10px;
              font-size: 14px;
              color: rgb(0, 0, 0);
              float: left;
              margin: 2px;
      }
    </style>
    <div id="md-add-event" class="modal fade in" data-width="1500" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
          <h4 class="modal-title"> <i class="fa fa-plus"></i>{{trans('main.agregar producto')}}</h4>
      </div>
      <!-- //modal-header-->
      <div class="modal-body" style="padding-bottom:0px; margin-left: 20px; margin-right: 20px;  margin-bottom: 20px;">
        <div class="form-group col-md-12">
            <div class="layout">
                <div id="options" class="row">
                  <div class="option-set" data-isotope-key="filter">
                    <a href="#" class="filtros" data-isotope-value="*">{{trans('main.show all')}}</a>
                    @foreach($categorys as $category)
                    <?php
                       $name = Name_category_menu::where('language_id', $lang->language_id)->where('category_menu_id', $category->id)->first();
                    ?>
                    <a href="#" class="filtros" data-isotope-value=".{{Str::slug($name->name)}}">{{$name->name}}</a>
                    @endforeach
                  </div>
                </div>
    
                <div id="container" class="row" style="margin-top: 10px;">
                    @foreach($items as $item)
                    <?php
                       $name = Name_category_menu::where('category_menu_id', $item->category_id)->where('language_id', $lang->language_id)->first();
                       $nameItem = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
                    ?>                                    
                    <div data-order="" data-id="{{$item->id}}" data-price="{{$hotel->exchanges->symbol}}{{$item->price}}" data-name="{{$nameItem->name}}" data-category="{{$item->category_id}}" style="height: 70px; border: 3px solid white; background-color: rgba(148, 148, 148, 0.14); color: black; font-size: 14px;" class="col-sm-2 element  {{Str::slug($name->name)}}" data-category="{{Str::slug($name->name)}}">{{$nameItem->name}} ({{$hotel->exchanges->symbol}}{{$item->price}})</div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
      <!-- //modal-body-->
    </div>
</div>

<!-- END CONTENT FRAME -->
<script type="text/javascript">
var datetime = null;   
function autoUpdate(){
    $.ajax({
        type: 'POST',
        url:  "{{url('chef/auto-update')}}",
        data: {datetime:datetime},
        success: function (data) {
            if(data.success==false){
                setTimeout(autoUpdate(), 1000);
                return false;
            }
            datetime = data.updated_at.date;
            console.log("datah:v "+datetime);
            if(datetime != null){
                console.log(data.state);
                if(data.state =='cancel') {
                    $('#'+data.id).remove();
                    setTimeout(autoUpdate(), 1000);
                    return false;
                }
                
                if($('div[id^='+data.id+']').length >= 1) {
                    setTimeout(autoUpdate(), 1000);
                    return false;
                }

                

                var html = '<div state="programmed" class="task-item item-'+data.id+'" id="'+data.id+'" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'">'+
                    '    <a href="#" class="circle blue next-board" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'" code="'+data.id+'" state="programmed">'+
                    '        <i class="fa fa-arrow-right btn-right"></i>'+
                    '    </a>'+
                    '    <div class="task-text ui-sortable-handle">'+
                    '        <p>'+
                    '           {{trans('main.room')}} <span><b>'+data.number_room+'</b></span>'+
                    '        </p>'+
                    '        <p class="ml-10">'+
                    '            {{trans('main.items')}}: '+
                    '            <a href="#" class="show_item_'+data.id+'" cod="'+data.id+'">'+
                    '                <span class="bag-item count-item-'+data.id+'">'+
                    '                    <b>'+data.itemsCount+'</b>'+
                    '                </span>'+
                    '            </a>'+
                    '        </p>'+
                    '        <p class="both">'+
                    '            {{trans('main.Entrega')}}: '+
                    '            <span class="delivery-order-'+data.id+'">'+
                    '                <b>'+data.delivery_time2+'</b>'+
                    '            </span>'+
                    '        </p>'+
                    '        <p class="ml-10">'+
                    '            <span class="clock_finish clock-finish-'+data.id+'" date="'+data.delivery_time+'"></span>'+
                    '        </p>'+
                    '    </div>'+
                    '    <div id="task-accordion-'+data.id+'" class="panel-group accordion">'+
                    '        <div class="panel-body" style="display:block;padding-top: 0;">'+
                    '        <hr class="hr">'+
                    '            <p class="mb-3">{{trans('main.huesped')}}: <span> <b> '+data.name+'</b> </span></p>'+
                    '            <p class="mb-3" style="margin: 0 0 -15px !important;">{{trans('main.Horario Pedido')}}: <span> <b>'+data.hour_order+'</b> </span></p>'+
   
                    '            <p>'+
                    '                <div class="form-group" id="btns-states-'+data.id+'" >'+
                    '                    <div class="col-md-4 programmed" style="padding: 3px; display: none;">'+
                    '                        <button class="btn btn-success btn-block btn-chage" style="" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'" code="'+data.id+'" state="programmed">{{trans('main.programmed')}}</button>'+
                    '                    </div>'+
                    '                    <div class="col-md-4 just_now" style="padding: 3px;">'+
                    '                        <button class="btn btn-warning btn-block btn-chage" style="" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'" code="'+data.id+'" state="just_now">{{trans('main.just_now')}}</button>'+
                    '                    </div>'+
                    '                    <div class="col-md-4 ready" style="padding: 3px;">'+
                    '                        <button class="btn btn-danger btn-block btn-chage" style="" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'" code="'+data.id+'" state="ready">{{trans('main.ready')}}</button>'+
                    '                    </div>'+
                    '                    <div class="col-md-4 delivered" style="padding: 3px;">'+
                    '                        <button class="btn btn-info btn-block btn-chage" style="" preparation="'+data.preparation_time+'" delivery="'+data.delivery_time+'" code="'+data.id+'" state="delivered">{{trans('main.delivered')}}</button>'+
                    '                    </div>'+
                    '                </div>'+
                    '                <div class="form-group">'+
                    '                    <div class="col-md-2"></div>'+
                    '                    <div class="col-md-4" style="padding: 3px;">'+
                    '                       <button class="btn  btn-block new-item-'+data.id+'" order="'+data.id+'" style="color:#33414E; margin-top: 2px !important;">{{trans('main.add item')}}</button>'+
                    '                    </div>'+
                    '                    <div class="col-md-4" style="padding: 3px;">'+
                    '                        <button class="btn  btn-block order-delete_new" code="'+data.id+'" style="color:#33414E; margin-top: 2px !important;">{{trans('main.delete')}} {{trans('main.order')}}</button>'+
                    '                    </div>'+
                    '                    <div class="col-md-2"></div>'+
                    '                </div>'+
                    '            </p>'+
                    '        </div>'+
                    '        <div class="panel-items-'+data.id+'">';
                        $.each(data.items, function(key, value) {
                html += '<div class="panel element-'+data.id+'">'+
                        '                <div class="panel-heading">'+
                        '                    <h4 class="panel-title">'+
                        '                        <a href="#accOneColOne" class="">'+
                        '                            <span class="col-md-4" style="padding: 0;">'+value.name+'</span>'+
                        '                            <span  class="col-md-2" style="padding: 0;"><b> $ '+value.price+'</b></span>'+
                        '                            <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-'+value.id+'" data-min="1" data-max="25" value="'+value.quantity+'" code="'+value.id+'"></span>'+
                        '                        </a>'+
                        '                        <ul class="panel-controls">'+
                        '                            <li><a href="#"  class="mb-control delete_new" code="'+value.id+'" ><span class="fa fa-trash-o"></span></a></li>'+
                        '                        </ul>'+
                        '                    </h4>'+
                        '                </div>'+
                        '            </div>';
                        });
                html += '        </div>'+
                    '    </div>'+
                    '</div>';
                
                if(data.state=='just_now'){
                    $('#tasks_progreess').append(html);
                    $("#tasks_scheduled,#tasks_progreess,#tasks_preparing,#tasks_completed").sortable('refresh');

                    var code = data.id;
                    var delivery = data.delivery_time;
                    var preparation = data.preparation_time;
                    $('.item-'+code).attr('state', "just_now");
                    $('.item-'+code).addClass("task-scheduled");
                    var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                    var b = moment();
                    var time2 = pt.diff(b);
            
                    var html = "<span class='btn btn-warning btn-xs state'>{{trans('main.just_now')}}</span>";
                    $('#btn-state-'+code).html(html);

                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'none');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
                    
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time2);
                    }
                }else{
                    $('#tasks_scheduled').append(html);
                    $("#tasks_scheduled,#tasks_progreess,#tasks_preparing,#tasks_completed").sortable('refresh');
                }
                @include('chef.partials.codejs')
            }
            setTimeout(autoUpdate(), 1000);
        }
    });
}

$(document).ready(function() { 
autoUpdate();    
});


    $('.element').on('click', function(event){
        event.preventDefault();
        var values = $(this);
        var id = values.attr('data-id');
        var price = values.attr('data-price');
        var name = values.attr('data-name');
        var category = values.attr('data-category');
        var order_id = values.attr('data-order');
        $.ajax({
                type: 'POST',
                url:  "{{url('chef/add-item')}}",
                data: {item:id, order_id:order_id, quantity: 1, category:category},
                success: function (data) {
                    if(data.success == false){
                        if(!data.errors['item']){$('.item').html('');}else{$('.item').html(data.errors['item']);}
                        if(!data.errors['quantity']){$('.quantity').html('');}else{$('.quantity').html(data.errors['quantity']);}
                        if(!data.errors['category']){$('.category').html('');}else{$('.category').html(data.errors['category']);}
                    }else{
                        if(data.update==false){
                            var html = '<div class="panel element-'+data.id+'" style="margin-top: 5px;">'+
                                       '    <div class="panel-heading">'+
                                       '        <h4 class="panel-title">'+
                                       '            <a href="#accOneColOne" class="">'+
                                       '                <span class="col-md-4" style="padding: 0;">'+data.name+'</span>'+
                                       '                <span  class="col-md-2" style="padding: 0;"><b> $'+data.price+'</b></span>'+
                                       '                <span  class="col-md-6" style="padding: 0;"><input type="text" class="form-control bfh-number" id="bfh-number-'+data.id+'" data-min="1" data-max="25" value="'+data.quantity+'"  code="'+data.id+'"></span> '+
                                       '            </a>'+
                                       '            <ul class="panel-controls">'+                                                            
                                       '                <li><a href="#"  class="mb-control delete-'+data.id+'" code="'+data.id+'" ><span class="fa fa-trash-o"></span></a></li>'+
                                       '            </ul>'+
                                       '        </h4>'+
                                       '    </div>'
                                       '</div>';
                            
                            $('.panel-items-'+data.order_id).append(html);
                            $('.count-item-'+data.order_id).html('<b>'+data.count+'</b>');
                            $('.delivery-order-'+data.order_id).html('<b>'+data.delivery+'</b>');
                            $('.clock-finish-'+data.order_id).attr('date', data.delivery.date);

                        }else{
                            console.log('#bfh-number-'+data.id);
                            $('#bfh-number-'+data.id).val(data.quantity);
                        }

                        $('#category').selectpicker('deselectAll');

                        $('#items').prop('disabled',true); 
                        $('#items').selectpicker('deselectAll');

                        $('#quantity').val('');

                        $('.delete-'+data.id).on('click',function(event){
                            event.preventDefault();
                            PNotify.removeAll();
                            var code = $(this).attr('code');
                            var notice = new PNotify({
                                text: $('#form_notice_item').html(), 
                                icon: false, 
                                width: 'auto', 
                                hide: false, 
                                addclass: 'custom', 
                                icon: 'picon picon-32 picon-edit-delete', 
                                opacity: .8, 
                                nonblock: { nonblock: true }, 
                                animation: {effect_in: 'show', effect_out: 'show'}, 
                                buttons: {closer: false, sticker: false }, 
                                insert_brs: false 
                            }); 
                            $('.btn-delete').on('click', function(){
                                $.ajax({
                                    type: 'GET',
                                    url: 'chef/remove-item',
                                    data: {id:code},
                                    success: function (data) {
                                        $('.element-'+code).remove();
                                        $('.count-item-'+data.code).html('<b>'+data.count+'</b>');
                                        notice.remove();
                                    }
                                });
                            });
                            $('.btn-calcel').on('click', function(){
                                notice.remove();
                            });
                        });

                    +function ($) {
                    
                      'use strict';
                    
                    
                      /* NUMBER CLASS DEFINITION
                       * ====================== */
                    
                      var BFHNumber = function (element, options) {
                        this.options = $.extend({}, $.fn.bfhnumber.defaults, options);
                        this.$element = $(element);
                    
                        this.initInput();
                      };
                    
                      BFHNumber.prototype = {
                    
                        constructor: BFHNumber,
                    
                        initInput: function() {
                          var value;
                          
                          if (this.options.buttons === true) {
                            this.$element.wrap('<div class="input-group"></div>');
                            this.$element.parent().append('<span class="input-group-addon bfh-number-btn inc"><span class="glyphicon glyphicon-plus"></span></span>');
                            this.$element.parent().append('<span class="input-group-addon bfh-number-btn dec"><span class="glyphicon glyphicon-minus"></span></span>');
                          }
                          
                          this.$element.on('change.bfhnumber.data-api', BFHNumber.prototype.change);
                            
                          if (this.options.keyboard === true) {
                            this.$element.on('keydown.bfhnumber.data-api', BFHNumber.prototype.keydown);
                          }
                          
                          if (this.options.buttons === true) {
                            this.$element.parent()
                              .on('mousedown.bfhnumber.data-api', '.inc', BFHNumber.prototype.btninc)
                              .on('mousedown.bfhnumber.data-api', '.dec', BFHNumber.prototype.btndec);
                          }
                          
                          this.formatNumber();
                        },
                        
                        keydown: function(e) {
                          var $this;
                          $this = $(this).data('bfhnumber');
                          
                          if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
                            return true;
                          }
                          console.log('keydown');
                          switch (e.which) {
                            case 38:
                              $this.increment();
                              break;
                            case 40:
                              $this.decrement();
                              break;
                            default:
                          }
                          
                          return true;
                        },
                        
                        mouseup: function(e) {
                          console.log('mouseup');
                          var $this,
                              timer,
                              interval;
                          
                          $this = e.data.btn;
                          timer = $this.$element.data('timer');
                          interval = $this.$element.data('interval');
                          
                          clearTimeout(timer);
                          clearInterval(interval);
                        },
                        
                        btninc: function() {
                          var $this,
                              timer;
                          
                          $this = $(this).parent().find('.bfh-number').data('bfhnumber');
                          
                          if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
                            return true;
                          }
                          
                          $this.increment();
                          
                          timer = setTimeout(function() {
                            var interval;
                            interval = setInterval(function() {
                              $this.increment();
                            }, 80);
                            $this.$element.data('interval', interval);
                          }, 750);
                          $this.$element.data('timer', timer);
                          
                          $(document).one('mouseup', {btn: $this}, BFHNumber.prototype.mouseup);
                          
                          return true;
                        },
                        
                        btndec: function() {
                          console.log('btndec');
                          var $this,
                              timer;
                          
                          $this = $(this).parent().find('.bfh-number').data('bfhnumber');
                          
                          if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
                            return true;
                          }
                          
                          $this.decrement();
                          
                          timer = setTimeout(function() {
                            var interval;
                            interval = setInterval(function() {
                              $this.decrement();
                            }, 80);
                            $this.$element.data('interval', interval);
                          }, 750);
                          $this.$element.data('timer', timer);
                          
                          $(document).one('mouseup', {btn: $this}, BFHNumber.prototype.mouseup);
                          
                          return true;
                        },
                        change: function() {
                          var $this;
                    
                          $this = $(this).data('bfhnumber');
                    
                          if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
                            return true;
                          }
                    
                          $this.formatNumber();
                    
                          var value = $this.getValue();
                          var code = $this.$element.attr('code');
                          $.ajax({
                              type: 'GET',
                              url: 'chef/edit-item',
                              data: {id:code, value:value},
                              success: function (data) {
                                  console.log(value+" - "+code);
                              }
                          });
                          return true;
                        },
                        increment: function() {
                          var value = this.getValue() + 1;
                          var code = this.$element.attr('code');
                          $.ajax({
                              type: 'GET',
                              url: 'chef/edit-item',
                              data: {id:code, value:value},
                              success: function (data) {
                                  console.log(value+" - "+code);
                              }
                          });
                          this.$element.val(value).change();
                        },
                        
                        decrement: function() {
                          var value = this.getValue() - 1;
                          var code = this.$element.attr('code');
                          $.ajax({
                              type: 'GET',
                              url: 'chef/edit-item',
                              data: {id:code, value:value},
                              success: function (data) {
                                  console.log(value+" - "+code);
                              }
                          });
                          this.$element.val(value).change();
                        },
                        
                        getValue: function() {
                          var value;
                          
                          value = this.$element.val();
                    
                          if (value !== '-1') {
                            value = String(value).replace(/\D/g, '');
                          }
                          if (String(value).length === 0) {
                            value = this.options.min;
                          }
                          
                          return parseInt(value);
                        },
                        
                        formatNumber: function() {
                          var value,
                              maxLength,
                              length,
                              zero;
                          
                          value = this.getValue();
                          
                          if (value > this.options.max) {
                            if (this.options.wrap === true) {
                              value = this.options.min;
                            } else {
                              value = this.options.max;
                            }
                          }
                          
                          if (value < this.options.min) {
                            if (this.options.wrap === true) {
                              value = this.options.max;
                            } else {
                              value = this.options.min;
                            }
                          }
                          
                          if (this.options.zeros === true) {
                            maxLength = String(this.options.max).length;
                            length = String(value).length;
                            for (zero=length; zero < maxLength; zero = zero + 1) {
                              value = '0' + value;
                            }
                          }
                          
                          if (value !== this.$element.val()) {
                            this.$element.val(value);
                          }
                        }
                    
                      };
                    
                      /* NUMBER PLUGIN DEFINITION
                       * ======================= */
                    
                      var old = $.fn.bfhnumber;
                    
                      $.fn.bfhnumber = function (option) {
                        return this.each(function () {
                          var $this,
                              data,
                              options;
                    
                          $this = $(this);
                          data = $this.data('bfhnumber');
                          options = typeof option === 'object' && option;
                    
                          if (!data) {
                            $this.data('bfhnumber', (data = new BFHNumber(this, options)));
                          }
                          if (typeof option === 'string') {
                            data[option].call($this);
                          }
                        });
                      };
                    
                      $.fn.bfhnumber.Constructor = BFHNumber;
                    
                      $.fn.bfhnumber.defaults = {
                        min: 0,
                        max: 9999,
                        zeros: false,
                        keyboard: true,
                        buttons: true,
                        wrap: false
                      };
                    
                    
                      /* NUMBER NO CONFLICT
                       * ========================== */
                    
                      $.fn.bfhnumber.noConflict = function () {
                        $.fn.bfhnumber = old;
                        return this;
                      };
                    
                    
                      /* NUMBER DATA-API
                       * ============== */
                    
                      $(document).ready( function () {
                        $('input[type="text"].bfh-number, input[type="number"].bfh-number').each(function () {
                          var $number;
                    
                          $number = $(this);
                    
                          $number.bfhnumber($number.data());
                        });
                      });
                    
                    
                      /* APPLY TO STANDARD NUMBER ELEMENTS
                       * =================================== */
                        
                        
                        }(window.jQuery);
                    }
                }
        });
        return false;
    });

    $('#category').change(function(){

        var code = $(this).val();
        console.log(code);
        if(code){
            $.get("{{url('chef/filter-items')}}"+"?", { code: code }, function(resultado){
                if(resultado == false)
                {
                    $('#items').selectpicker('deselectAll');
                    $('#items').prop('disabled',true); 
                }else{
                    document.getElementById("items").options.length=1;
                    $('#items').append(resultado);

                    $('#items').selectpicker('deselectAll');
                    $('#items').prop('disabled',false);
                    $('#items').selectpicker('refresh');
                }
            });
        }

        $('#items').selectpicker('refresh');
    });

    $('.new-item').on('click',function(event){
        $('.element').attr('data-order', $(this).attr('order'));
        $('#md-add-event').modal({ backdrop: 'static', keyboard: false });
        setTimeout(function(){
           $('#container').isotope({ sortBy : 'original-order' });
        }, 1000);
    });

    $('.filter').change(function(){
        $(this).parent().submit();
    });

    $('.delete').on('click',function(event){
        event.preventDefault();
        var code = $(this).attr('code');
        PNotify.removeAll();
        var notice = new PNotify({
            text: $('#form_notice_item').html(), 
            icon: false, 
            width: 'auto', 
            hide: false, 
            addclass: 'custom', 
            icon: 'picon picon-32 picon-edit-delete', 
            opacity: .8, 
            nonblock: { nonblock: true }, 
            animation: {effect_in: 'show', effect_out: 'show'}, 
            buttons: {closer: false, sticker: false }, 
            insert_brs: false 
        }); 
        $('.btn-delete').on('click', function(){
            $.ajax({
                type: 'GET',
                url: 'chef/remove-item',
                data: {id:code},
                success: function (data) {
                    $('.element-'+code).remove();
                    $('.count-item-'+data.code).html('<b>'+data.count+'</b>');
                    notice.remove();
                }
            });
        });
        $('.btn-calcel').on('click', function(){
            notice.remove();
        });
    });

    $('.order-delete').on('click',function(event){
        event.preventDefault();
        var code = $(this).attr('code');
        PNotify.removeAll();
        var notice = new PNotify({
            text: $('#form_notice_order').html(), 
            icon: false, 
            width: 'auto', 
            hide: false, 
            addclass: 'custom', 
            icon: 'picon picon-32 picon-edit-delete', 
            opacity: .8, 
            nonblock: { nonblock: true }, 
            animation: {effect_in: 'show', effect_out: 'show'}, 
            buttons: {closer: false, sticker: false }, 
            insert_brs: false 
        }); 
        notice.get().find('.btn-delete').on('click', function(){
            $.ajax({
                type: 'GET',
                url: 'chef/remove-order',
                data: {id:code},
                success: function (data) {
                    $('.item-'+code).remove();
                    notice.remove();
                }
            });
        });
        notice.get().find('.btn-calcel').on('click', function(){
            notice.remove();
        });
    });

$( document ).ready(function() {
  var container = document.querySelector('#container');
  var iso = window.iso = new Isotope( container, {
    layoutMode: 'fitRows',
    isFitWidth: true,
    transitionDuration: '0.8s',
    cellsByRow: {
      columnWidth: '.col-sm-2',
      rowHeight: 140,
    },
    getSortData: {
      category: '[data-category]',
    }
  });
  $('.filtros').on('click',function(event){
    event.preventDefault();
    // var opt = {};
    var key = 'filter';
    var value = $(this).attr('data-isotope-value');

    console.log( key, value );
    iso.options[ key ] = value;
    iso.arrange();
  });
});
</script>

@foreach($ordersProgrammed as $order)
<script type="text/javascript">
    var code = {{$order->id}};
    var a = moment('{{$order->delivery_time}}').subtract({{$order->preparation_time+5}}, 'm');
    var pt = moment('{{$order->delivery_time}}').subtract({{$order->preparation_time}}, 'm');
    var b = moment();
    var time = a.diff(b);
    var time2 = pt.diff(b);
    if(time<=0){
        $('.item-{{$order->id}}').appendTo('#tasks_progreess');
        $('.item-{{$order->id}}').addClass("task-scheduled");
        var code = {{$order->id}};
        var state = "just_now";
        console.log(code);
        $.ajax({
            type: 'GET',
            url: 'chef/change-state2',
            data: {id:code, state:state},
            success: function (data) {
                return true;
            }
        });

        if(time2<=0){
            $('.item-'+code).addClass("task-progreess");
            $('.item-'+code).removeClass("task-scheduled");
        }else{
            setTimeout(function(){
               $('.item-{{$order->id}}').addClass("task-progreess");
               $('.item-'+code).removeClass("task-scheduled");
            },
            time2);
        }
    }else{
        setTimeout(function(){
            var pt = moment('{{$order->delivery_time}}').subtract({{$order->preparation_time}}, 'm');
            var b = moment();
            var time2 = pt.diff(b);
            $('.item-{{$order->id}}').appendTo('#tasks_progreess');
            $('.item-{{$order->id}}').addClass("task-scheduled");
            var code = {{$order->id}};
            var state = 'just_now';
            $.ajax({
                type: 'GET',
                url: 'chef/change-state2',
                data: {id:code, state:state},
                success: function (data) {
                    return true;
                }
            });
            setTimeout(function(){
                $('.item-{{$order->id}}').addClass("task-progreess");
                $('.item-{{$order->id}}').removeClass("task-scheduled");
             },
             time2);
        },
        time);
    }
</script>
@endforeach
@foreach($ordersJust as $order)
<script type="text/javascript">
    var pt = moment('{{$order->delivery_time}}').subtract({{$order->preparation_time}}, 'm');
    var b = moment();
    var time2 = pt.diff(b);

    if(time2<=0){
        $('.item-{{$order->id}}').addClass("task-progreess");
        $('.item-{{$order->id}}').removeClass("task-scheduled");
    }else{
        setTimeout(function(){
           $('.item-{{$order->id}}').addClass("task-progreess");
           $('.item-{{$order->id}}').removeClass("task-scheduled");
        },
        time2);
    }
</script>
@endforeach
@foreach($ordersReady as $order)
<script type="text/javascript">
    var pt = moment('{{$order->delivery_time}}');
    var b = moment();
    var time2 = pt.diff(b);
    if(time2<=0){
        $('.item-{{$order->id}}').addClass("task-progreess");
        $('.item-{{$order->id}}').removeClass("task-scheduled");
    }else{
        setTimeout(function(){
           $('.item-{{$order->id}}').addClass("task-progreess");
           $('.item-{{$order->id}}').removeClass("task-scheduled");
        },
        time2);
    }
</script>
@endforeach
@stop