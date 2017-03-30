@extends('receptionists.master') 
@section('title', trans('main.add orden'))
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel" style="" >
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>Nuevo</strong> Pedido</h2>
        <h2 class="pull-right">{{trans('main.total')}}: <strong>$</strong><strong id="total">0.00</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
       @endif
       <p>{{trans('main.huesped')}}: {{$stay->name}}</p>
			 <p>{{trans('main.habitacion')}}: {{$stay->room->number_room}}</p>
      </header>
			<div class="panel-body" style="">
        <div class="form-group" style="padding: 10px;">
            <div>
                <button type="button" class="btn btn-theme" id="item-add">{{trans('main.agregar producto')}}</button>
            </div>
        </div>
				{{ Form::open(['files' => 'true', 'method' => 'POST', 'action'=>'ReceptionistController@anyOrderSave']) }}
        {{ Form::hidden('order_id', $order->id) }}
                   <div class="form-group" style="width: 300px;">
                        <label class="control-label">{{trans('main.state')}}</label>
                        <div>
                            {{ Form::select('state',array('programmed'=> trans('main.programmed'),
                                    'just_now'=> trans('main.just_now'),
                                    'ready'=> trans('main.ready'),
                                    'delivered'=> trans('main.delivered'),
                                    'finalized'=> trans('main.finalized')), NULL, array('class' => 'form-control selectpicker', 'data-size'=>'10')) }}
                            {{ errors_for('state', $errors) }}
                        </div>
                    </div>

                    <div class="form-group" style="width: 300px;">
                        <label class="control-label">{{trans('main.Hora de entrega')}}</label>
                        <div>
                            {{ Form::hidden('date', $order->delivery_time, ['id' => 'date']) }}
                            {{ Form::text('fecha', $order->delivery_time->format('d-m-Y g:i:s')  , ['class' => 'form-control start-date', 'required'=>'required']) }}
                            {{ errors_for('fecha', $errors) }}
                        </div>
                    </div>

                    <table class="table table-bordered" id="sector_table">
                      <thead>
                        <tr>
                          <td>{{trans('main.Producto')}}</td>
                          <td style="width: 75px;">{{trans('main.Catidad')}}</td>
                          <td>{{trans('main.Precio')}}</td>
                          <td>{{trans('main.Sub Total')}}</td>
                          <td>{{trans('main.Eliminar')}}</td>
                        </tr>
                      </thead>
            
                      <tbody id="body">
                      <?php
                      $total = 0;
                      ?>
                      @foreach($itemsOrders as $itemOrder)
                         <?php
                         $item = Item::find($itemOrder->name_item_menu_id);
                         $nameItem = NameItem::where('item_id', $item->id)->where('language_id', $lang->language_id)->first();
                         $total = $total+($itemOrder->price*$itemOrder->quantity);
                         ?>
                        <tr id="item-order-{{$itemOrder->id}}">
                          <td>{{$nameItem->name}}</td>
                          <td style="width: 75px;">
                             <div class="input-group" style="width: 50px;">
                                 <span class="input-group-addon bfh-number-btn inc" item-id="{{$itemOrder->id}}"><i class="glyphicon glyphicon-plus"></i></span>
                                 <input type="text" class="form-control quantity-{{$itemOrder->id}}" item-id="{{$itemOrder->id}}" style="width: 50px;" value="{{$itemOrder->quantity}}" disabled>
                                 <span class="input-group-addon bfh-number-btn dec" item-id="{{$itemOrder->id}}"><i class="glyphicon glyphicon-minus"></i></span>
                             </div>
                          </td>
                          <td>$ {{$itemOrder->price}}</td>
                          <td>$ <span id="sub-total-{{$itemOrder->id}}">{{$itemOrder->price*$itemOrder->quantity}}</span></td>
                          <td><button class="btn btn-info btn-transparent delete" type="button" item-id="{{$itemOrder->id}}" data-placement="left" title="{{trans('main.delete')}}" onclick=""><i class="glyphicon glyphicon-trash"></i></button>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                         <tr>
                         </tr>
                    </table>
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
                    <div id="md-add-event" class="modal fade in"   data-width="700"  style="margin-top: -321px;">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                          <h4 class="modal-title"> <i class="fa fa-plus"></i> Nuevo Item</h4>
                      </div>
                      <!-- //modal-header-->
                      <div class="modal-body" style="padding-bottom:0px; margin-left: 20px; margin-right: 20px;  margin-bottom: 20px;">
                        <div class="form-group col-md-12">
                            <div class="layout">
                                <div id="options" class="row">
                                  <div class="option-set" data-isotope-key="filter">
                                    <a href="#" class="filtros" data-isotope-value="*">{{trans('main.show all')}}</a>
                                    @foreach($categories as $category)
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
                                    <div data-id="{{$item->id}}" data-price="{{$hotel->exchanges->symbol}}{{$item->price}}" data-name="{{$nameItem->name}}" data-category="{{$item->category_id}}" style="height: 70px; border: 3px solid white; background-color: rgba(148, 148, 148, 0.14); color: black; font-size: 14px;" class="col-sm-3 element  {{Str::slug($name->name)}}" data-category="{{Str::slug($name->name)}}">{{$nameItem->name}} ({{$hotel->exchanges->symbol}}{{$item->price}})</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                      </div>
                      <!-- //modal-body-->
                    </div>
                    

                    <div class="form-group" style="margin-top: 30px;">
                        <div>
                            <button type="submit" class="btn btn-theme">{{trans('main.Confirmar Orden')}}</button>
                        </div>
                    </div>
				{{ Form::close() }}
			</div>
		</section>
		</div>

	</div>
	
</div>

<div class="form_notice" style="display: none;">
    <div class="pf-element pf-heading">
      <h3>{{trans('main.confirme que eliminara el item')}}</h3>
      <p></p>
    </div>
    <div class="pf-element pf-buttons pf-centered">
      <input class="pf-button btn btn-primary btn-delete" type="button" name="submit" value="{{trans('main.confirmar')}}" />
      <input class="pf-button btn btn-default btn-calcel" type="button" name="cancel" value="{{trans('main.cancelar')}}" />
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
$('#total').html('{{$total}}');

$('.inc').on('click', function(event){
  event.preventDefault();
  var item_id = $(this).attr('item-id');
  $.ajax({
      type: 'GET',
      url: "{{url('receptionist/increment')}}",
      data: {code:item_id},
      success: function (data) {
        $('.quantity-'+item_id).val(data.quantity);
        $('#sub-total-'+item_id).html(parseInt($('#sub-total-'+item_id).html())+parseInt(data.price));
        $('#total').html(parseInt($('#total').html())+parseInt(data.price));
        console.log($('#total').html());
      }
  });
});

$('.dec').on('click', function(event){
  event.preventDefault();
  var item_id = $(this).attr('item-id');
  if($('.quantity-'+item_id).val()>=2){
      $.ajax({
          type: 'GET',
          url: "{{url('receptionist/decrement')}}",
          data: {code:item_id},
          success: function (data) {
            if(data.quantity>=1){
              $('.quantity-'+item_id).val(data.quantity);
              $('#sub-total-'+item_id).html(parseInt($('#sub-total-'+item_id).html())-parseInt(data.price));
              $('#total').html(parseInt($('#total').html())-parseInt(data.price));
              console.log($('#total').html());
            }
          }
      });
  }
  
});

$('.delete').on('click', function(event){
  event.preventDefault();
  $('.item_id').val($(this).attr('item-id'));
  var code = $(this).attr('item-id');
  var notice = new PNotify({
    text: $('.form_notice').html(),
    icon: false,
    width: 'auto',
    hide: false,
    addclass: 'custom',
    icon: 'picon picon-32 picon-edit-delete',
    opacity: .8,
    nonblock: {
        nonblock: true
    },
    animation: {
        effect_in: 'show',
        effect_out: 'show'
    },
    buttons: {
      closer: false,
      sticker: false
    },
    insert_brs: false
  });
  $('.btn-delete').on('click', function(){
      $.ajax({
          type: 'GET',
          url: "{{url('receptionist/order-remove')}}",
          data: {id:code},
          success: function (data) {
              $('#item-order-'+code).remove();
              $('#total').html(parseInt($('#total').html())-parseInt(data.sub_total));
              notice.remove();
          }
      });
  });
  $('.btn-calcel').on('click', function(){
      notice.remove();
  });
});

$('.element').on('click', function(event){
  event.preventDefault();
  var values = $(this);
  var id = values.attr('data-id');
  var price = values.attr('data-price');
  var name = values.attr('data-name');
  var category = values.attr('data-category');
  var order_id = {{$order->id}};
  $.ajax({
      type: 'GET',
      url: "{{url('chef/add-item')}}",
      data: {item:id, order_id:order_id, quantity: 1, category:category},
      success: function (data) {
        if(data.update==true){
          $()
          $('.quantity-'+data.id).val(data.quantity);
          $('#sub-total-'+data.id).html(parseInt($('#sub-total-'+data.id).html())+parseInt(data.price));
          $('#total').html(parseInt($('#total').html())+parseInt(data.price));
        }else{
            var element = '<tr id="item-order-'+data.id+'">'+
                          '  <td>'+name+'</td>'+
                          '  <td style="width: 75px;">'+
                          '     <div class="input-group" style="width: 50px;">'+
                          '         <span class="input-group-addon bfh-number-btn inc-'+data.id+'" item-id="'+data.id+'"><i class="glyphicon glyphicon-plus"></i></span>'+
                          '         <input type="text" class="form-control quantity-'+data.id+'" item-id="'+data.id+'" style="width: 50px;" value="1" disabled>'+
                          '         <span class="input-group-addon bfh-number-btn dec-'+data.id+'" item-id="'+data.id+'"><i class="glyphicon glyphicon-minus"></i></span>'+
                          '     </div>'+
                          '  </td>'+
                          '  <td>$ '+data.price+'</td>'+
                          '  <td>$ <span id="sub-total-'+data.id+'">'+data.price+'</span></td>'+
                          '  <td><button class="btn btn-info btn-transparent delete-'+data.id+'" type="button" item-id="'+data.id+'" data-placement="left" title="{{trans('main.delete')}}" onclick=""><i class="glyphicon glyphicon-trash"></i></button>'+
                          '  </td>'+
                          '</tr>';
             $("#body").append(element);
             $('#total').html(parseInt($('#total').html())+parseInt(data.price));
   
             $('.inc-'+data.id).on('click', function(event){
            event.preventDefault();
            var item_id = $(this).attr('item-id');
            $.ajax({
                type: 'GET',
                url: "{{url('receptionist/increment')}}",
                data: {code:item_id},
                success: function (objet) {
                  $('.quantity-'+item_id).val(objet.quantity);
                  $('#sub-total-'+item_id).html(parseInt($('#sub-total-'+item_id).html())+parseInt(objet.price));
                  $('#total').html(parseInt($('#total').html())+parseInt(objet.price));
                  console.log($('#total').html());
                }
            });
             });
   
             $('.dec-'+data.id).on('click', function(event){
            event.preventDefault();
            var item_id = $(this).attr('item-id');
            if($('.quantity-'+item_id).val()>=2){
                $.ajax({
                    type: 'GET',
                    url: "{{url('receptionist/decrement')}}",
                    data: {code:item_id},
                    success: function (objet) {
                      if(objet.quantity>=1){
                        $('.quantity-'+item_id).val(objet.quantity);
                        $('#sub-total-'+item_id).html(parseInt($('#sub-total-'+item_id).html())-parseInt(objet.price));
                        $('#total').html(parseInt($('#total').html())-parseInt(objet.price));
                        console.log($('#total').html());
                      }
                    }
                });
            }
               
             });
   
             $('.delete-'+data.id).on('click', function(event){
            event.preventDefault();
            $('.item_id').val($(this).attr('item-id'));
            var code = $(this).attr('item-id');
            var notice = new PNotify({
              text: $('.form_notice').html(),
              icon: false,
              width: 'auto',
              hide: false,
              addclass: 'custom',
              icon: 'picon picon-32 picon-edit-delete',
              opacity: .8,
              nonblock: {
                  nonblock: true
              },
              animation: {
                  effect_in: 'show',
                  effect_out: 'show'
              },
              buttons: {
                closer: false,
                sticker: false
              },
              insert_brs: false
            });
            $('.btn-delete').on('click', function(){
                $.ajax({
                    type: 'GET',
                    url: "{{url('receptionist/order-remove')}}",
                    data: {id:code},
                    success: function (data) {
                        $('#item-order-'+code).remove();
                        $('#total').html(parseInt($('#total').html())-parseInt(data.sub_total));
                        notice.remove();
                    }
                });
            });
            $('.btn-calcel').on('click', function(){
                notice.remove();
            });
             });
          }
      }
  });
});

docReady( function() {
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

$('#item-add').on('click',function(event){
  event.preventDefault();
  
  $('#md-add-event').modal();

  setTimeout(function(){
     $('#container').isotope({ sortBy : 'original-order' });
  },
  1000);

});


$('.start-date').datetimepicker({
    format: 'DD-MM-YYYY HH:mm'
});

$(".start-date").on("dp.hide", function (e) {
    $("#date").val(moment($(this).val(), "DD-MM-YYYY HH:mm").format("YYYY-MM-DD HH:mm:ss"));
});
</script>
@stop