@extends('hotel.master')

@section('title', 'Admin Dashboard')

@section('content')
<?php
use Carbon\Carbon;
$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
$planes = Plan::where('state', 1)->orderBy('price', 'ASC')->get();
$itemsCount = Item::where('hotel_id', $hotel->id)->where('state', 1)->count();
$langCount = Room::where('hotel_id', $hotel->id)->where('state', 1)->count();

$payment = Payment::where('user_id', $hotel->user_id)->first();
$create =  Carbon::parse($payment->updated_at);
$caducidad = $create->addDays($payment->time);
$date = new DateTime($caducidad);
?>
<!--
/////////////////////////////////////////////////////////////////////////
//////////     Planes de pago de menbrecias     //////////
//////////////////////////////////////////////////////////////////////
-->
<div id="main">

	<div id="content">
		<div class="row pricing">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading  align-lg-center">
						<h2><strong>{{trans('main.plans')}}</strong></h2>
						<label class="color" >{{trans('main.his latest plan ends the')}}: {{$date->format('d-m-Y')}}</label>
					    </br>
					    @if(Session::has('error'))
                            <label class="label label-danger">{{Session::get('error')}}</label>
                        @endif
					</header>
				</section>
			</div>
			<br>
			@foreach($planes as $plan)
			@if($itemsCount < $plan->items and $langCount < $plan->rooms)
			<div class="col-lg-4 col-md-4 col-xs-6">
				<ul class="plan corner-flip flip-gray">
					<li class="plan-name"> {{$plan->name}} </li>
					<li class="plan-price">€ {{$plan->price}} </li>
					<li> <strong>{{$plan->items}}</strong> {{trans('main.items')}} </li>
					<li> <strong>{{$plan->rooms}}</strong> {{trans('main.rooms')}} </li>
					<li> <strong>{{$plan->time}}</strong> {{trans('main.days')}}  </li>
					<li class="plan-action">
					    {{Form::open(array('method'=>'post', 'action' => 'PaymentsController@postPayment'))}}
			            {{Form::hidden("plan_id", $plan->id)}}
					    <button type="submit" data-toggle="tooltip" data-placement="left" title="{{trans('main.to pay')}}"  class="btn btn-theme-inverse">{{trans('main.to pay')}}</button>
					    {{ Form::close() }} 
				    </li>
				</ul>
			</div>
			@endif
			@endforeach

			<div class="clearfix"></div>
		</div>
		<!-- //content > row-->
	</div>
	<!-- //content-->
</div>
<!-- //main-->

@stop
@section('js-script')
	$(function() {
     $('[data-toggle="tooltip"]').tooltip();
     });
@stop