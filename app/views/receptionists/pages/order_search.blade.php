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
				<h2 class="pull-right">{{trans('main.total')}}: <strong id="total">$ 0.00</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
                <p>{{trans('main.huesped')}}: {{$stay->name}}</p>
                <p>{{trans('main.habitacion')}}: {{$stay->room->number_room}}</p>
			</header>
			<div class="panel-body">			  
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
                         $total = $total+$subtotal;
					   ?>
						<tr>
                            <td>{{Carbon::parse($order->delivery_time)->format('d-m-Y H:i')}} </td>
                            <td>{{trans('main.'.$order->state)}}</td>
                            <td>$ {{$subtotal}}</td>
                            <td>
                                <a href="{{url('receptionist/order-detail/'. $order->id)}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="color: white;"></span> {{trans('main.detalle')}}</a>
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
		$('#total').html('{{"$ ".$total}}');
		$('#sector_table').dataTable();
		
	});
</script>
@stop