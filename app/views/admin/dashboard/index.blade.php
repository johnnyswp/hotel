@extends('admin.master')

@section('title', 'Admin Dashboard')@stop

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	<div class="row" style="margin-bottom: 20px; margin-top: 10px; ">
		<div class="col-md-4">
			<a href="{{url('admin/hotel/create')}}" class="btn btn-success btn-block" style="font-size: 20px;"><i class="fa fa-user-md"></i> Agregar Hotel </a>
		</div>
		<div class="col-md-4">
			<a href="{{url('admin/planes/create')}}" class="btn btn-success btn-block" style="font-size: 20px;"><i class="fa fa-user-md"></i> Agregar Plan </a>
		</div>
		<div class="col-md-4">
			<a href="{{url('admin/paquetes-sms/create')}}" class="btn btn-success btn-block" style="font-size: 20px;"><i class="fa fa-user-md"></i> Agregar Plan SMS </a>
		</div>
		 
		 
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="well bg-theme-inverse">
				<div class="widget-tile">
					<section>
						<?php $countHotels = Hotel::count(); ?>
						<h2><strong>Hoteles</strong> </h2>
						<h2>{{$countHotels}}</h2>
					</section>
					<div class="hold-icon"><i class="fa fa-hospital-o"></i></div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="well bg-theme-inverse">
				<div class="widget-tile">
					<section>
						<?php $saldoSms = OptionAdmin::where('code', 'sal_sms')->first(); ?>
						<h2><strong>Saldo SMS</strong> </h2>
						<h2>{{$saldoSms->value}}</h2>
					</section>
					<div class="hold-icon"><i class="fa fa-comments"></i></div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="well bg-theme-inverse">
				<div class="widget-tile">
					<section>
						<?php 
						$Payments = Userpayment::get();
						$cost = 0;
						foreach($Payments as $Payment)
						{
                           $cost = $cost+$Payment->price;
						}
						?>
						<h2><strong>Paypal</strong> </h2>
						<h2>${{$cost}}</h2>
					</section>
					<div class="hold-icon"><i class="fa fa-paypal"></i></div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="well bg-theme-inverse">
				<div class="widget-tile">
					<section>
						<?php $plans = Plan::count(); ?>
						<h2><strong>Plans</strong> </h2>
						<h2>{{$plans}}</h2>
					</section>
					<div class="hold-icon"><i class="fa fa-files-o"></i></div>
				</div>
			</div>
		</div>
</div>

@stop