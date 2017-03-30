@extends('hotel.master')

@section('title', 'Hotel Dashboard')@stop

@section('content')
<?php
use Carbon\Carbon;
$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
$plan = Plan::find($payment->plan_id);
$planes = Plan::where('state', 1)->orderBy('price', 'ASC')->get();
$create =  Carbon::parse($payment->updated_at);
$caducidad = $create->addDays($payment->time);
$itemsCount = Item::where('hotel_id', $hotel->id)->where('state', 1)->count();
$langCount = Room::where('hotel_id', $hotel->id)->where('state', 1)->count();
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
						<h2><strong>{{trans('main.improve your plan')}}.</strong></h2>
						<label class="color" style="height: 75px;"> {{trans('main.improve your plan message')}} {{$caducidad->format('d-m-Y')}} {{trans('main.improve your plan message 2')}}.</label>
					    </br>
					    @if(Session::has('error'))
                            <label class="label label-danger">{{Session::get('error')}}</label>
                        @endif
					</header>
				</section>
			</div>
			<br>
			@foreach($planes as $plan)
			@if(Payment::chancePayment($plan->price) > 0)
			{{Form::open(array('method'=>'post', 'action' => 'PaymentsController@postChancePayment'))}}
			{{Form::hidden("plan_id", $plan->id)}}
			<div class="col-lg-4 col-md-4 col-xs-6">
				<ul class="plan corner-flip flip-gray">
					<li class="plan-name"> {{$plan->name}} </li>
					<li> <strong>€ {{$plan->price}}</strong> {{trans('main.annual price')}} </li>
					<li> <strong>{{$plan->rooms}}</strong> {{trans('main.rooms')}}</li>
					<li> <strong>{{$plan->items}}</strong> {{trans('main.items')}}</li>
					<li> <strong>{{$plan->time}}</strong> {{trans('main.days')}}</li>
					<li>{{trans('main.due today')}} <strong class="plan-price"> € {{Payment::chancePayment($plan->price)}}</strong></li>
					<li class="plan-action"><button type="submit" class="btn btn-theme-inverse">{{trans('main.to pay')}} € {{Payment::chancePayment($plan->price)}} </button> </li>
				</ul>
			</div>
			{{ Form::close() }}
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