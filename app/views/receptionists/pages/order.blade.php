@extends('receptionists.master') 
@section('title', trans('main.orders'))
<?php
use Carbon\Carbon;
?>
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-md-12">
			 <section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.pedidos')}}</strong></h2>
				<h2 class="pull-right">{{trans('main.total')}}: <strong id="total">{{Hotel::find(Hotel::id())->exchanges->symbol}} 0.00</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
                @if (Session::has('error'))
                <label class="color" style="color: red;">{{ Session::get('error') }}</label>
                @endif
                <p>{{trans('main.huesped')}}: {{$stay->name}}</p>
                <p>{{trans('main.habitacion')}}: {{$stay->room->number_room}}</p>
			</header>
			<div class="panel-body">			  
        <form class="form-horizontal"  data-collabel="3" data-alignlabel="left"  data-label="color">
    
					<div class="form-group">
						<div>
							<a href="{{url('receptionist/order-add/'.$stay->id)}}" class="btn btn-theme">{{trans('main.nuevo pedido')}}</a>
						</div>
					</div>
				</form>

				<table class="table" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.hora de entrega')}}</td>
                            <td>{{trans('main.state')}}</td>
                            <td>{{trans('main.total')}}</td>
                            <td>{{trans('main.action')}}</td>
						</tr>
					</thead>
					<tbody>
					<?php $total = 0; ?>
					@foreach($orders as $order)
					   <?php
                         $itemsOrders = ItemOrder::where('order_id', $order->id)->get();
                         
                         $subtotal = 0;
                         foreach ($itemsOrders as $itemOrder) {
                         	$subtotal = $subtotal+($itemOrder->price*$itemOrder->quantity);
                         }
                        if($order->state!='cancel'){
                             $total = $total+$subtotal;
                        }
					   ?>
						<tr>
                            <td>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </td>
                            <td>@if($order->state=="cancel") {{trans('main.cancelado')}} @else {{trans('main.'.$order->state)}} @endif</td>
                            <td>{{Hotel::find(Hotel::id())->exchanges->symbol}} {{round($subtotal,2)}}</td>
                            <td>
                                <a href="{{url('receptionist/order-edit/'. $order->id)}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a>
                                <button type="button" class="btn btn-md btn-warning"><span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="var notice = new PNotify({text: $('#form_notice_{{$order->id}}').html(), icon: false, width: 'auto', hide: false, addclass: 'custom', icon: 'picon picon-32 picon-edit-delete', opacity: .8, nonblock: {nonblock: true }, animation: {effect_in: 'show', effect_out: 'show'}, buttons: {closer: false, sticker: false }, insert_brs: false }); notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){notice.remove(); }).submit(function(){$('#form_notice_{{$order->id}}').submit(); });"></span></button>
                                <div id="form_notice_{{$order->id}}" style="display: none;">
                                  {{ Form::open(array('class'=>'pf-form pform_custom','url' => 'receptionist/order-delete/')) }}
                                    {{ Form::hidden("order_id", $order->id, array('class'=>'order_id')) }}
                                    <div class="pf-element pf-heading">
                                      <h3>{{trans('main.confirm delete orden')}}</h3>
                                      <p></p>
                                    </div>
                                    <div class="pf-element pf-buttons pf-centered">
                                      <input class="pf-button btn btn-primary" type="submit" name="submit" value="{{trans('main.confirm')}}" />
                                      <input class="pf-button btn btn-default" type="button" name="cancel" value="{{trans('main.cancel')}}      " />
                                    </div>
                                  {{ Form::close() }}
                                </div>
                            </td>
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
	$(function() {
		$('#total').html('{{Hotel::find(Hotel::id())->exchanges->symbol." ".round($total, 2)}}');
		$('#sector_table').dataTable();
		
	});
</script>
@stop