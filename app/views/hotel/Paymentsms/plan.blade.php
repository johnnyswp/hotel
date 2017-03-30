@extends('hotel.master')

@section('title', 'Hotel Dashboard')

@section('content')
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
						<h2><strong>{{trans('main.package')}}</strong></h2>
						<label class="color" >{{trans('main.package message sms')}} @if($payment) {{$payment->sms}} @else 0 @endif {{trans('main.package message sms 2')}}</label>
					    </br>
					    @if(Session::has('error'))
                            <label class="label label-danger">{{Session::get('error')}}</label>
                        @endif
					</header>
				</section>
			</div>
			<br>
			@foreach($plans as $plan)
			<div class="col-lg-4 col-md-4 col-xs-6">
				<ul class="plan corner-flip flip-gray">
					<li class="plan-name"> {{$plan->name}} </li>
					<li class="plan-price">{{$plan->price}} Euros</li>
					<li> <strong>{{$plan->sms}}</strong> {{trans('main.text messages')}}</li>
					<li class="plan-action">
					    {{Form::open(array('method'=>'post', 'action' => 'PaymentsSmsController@postPayment'))}}
			            {{Form::hidden("plan_id", $plan->id)}}
					    <button type="submit" data-toggle="tooltip" data-placement="left" title="{{trans('main.to pay')}}"  class="btn btn-theme-inverse">{{trans('main.to pay')}}</button>
					    {{ Form::close() }} 
				    </li>
				</ul>
			</div>
			@endforeach

			<div class="clearfix col-lg-12 "><p><strong>{{trans('main.Sending a message may deduct more than 1 SMS balance, depending on their length')}}</strong></p></div>
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