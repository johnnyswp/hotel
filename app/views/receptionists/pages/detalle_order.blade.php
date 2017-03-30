@extends('receptionists.master') 
@section('title', trans('main.detalle de la orden'))
<?php
use Carbon\Carbon;
?>
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel" style="" >
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.detalle')}}</strong> {{trans('main.pedido')}}</h2>
        <h2 class="pull-right">{{trans('main.total')}}: <strong>{{Hotel::find(Hotel::id())->exchanges->symbol}}</strong><strong id="total">0.00</strong></h2>
       <p>{{trans('main.huesped')}}: {{$stay->name}}</p>
       <p>{{trans('main.habitacion')}}: {{$stay->room->number_room}}</p>
			</header>
			<div class="panel-body" style="">
        <div class="form-group" style="width: 300px;">
            <div>
                <label class="control-label">{{trans('main.state')}}: <strong>{{trans('main.'.$order->state)}}</strong></label> 
            </div>
        </div>

        <div class="form-group"style="width: 300px;" >
            <label class="control-label">{{trans('main.Hora de entrega')}}: <strong>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}}</strong></label>
        </div>

        <table class="table table-bordered" id="sector_table">
          <thead>
            <tr>
              <td>{{trans('main.Producto')}}</td>
              <td style="width: 75px;">{{trans('main.Catidad')}}</td>
              <td>{{trans('main.Precio')}}</td>
              <td>{{trans('main.Sub Total')}}</td>
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
              <td style="width: 75px;">{{$itemOrder->quantity}}</td>
              <td>{{Hotel::find(Hotel::id())->exchanges->symbol}} {{$itemOrder->price}}</td>
              <td>{{Hotel::find(Hotel::id())->exchanges->symbol}} <span id="sub-total-{{$itemOrder->id}}">{{$itemOrder->price*$itemOrder->quantity}}</span></td>
            </tr>
          @endforeach
          </tbody>
        </table>
			</div>
		</section>
		</div>
	</div>
</div>


@stop
@section('script')
<script type="text/javascript">
$('#total').html('{{$total}}');
</script>
@stop