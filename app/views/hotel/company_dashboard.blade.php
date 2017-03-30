@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content" style="margin-top: 50px;">
	<div class="row">
		<div class="col-lg-4" style=" text-align: center;">
		    <div class="jumbotron" style="margin: 20px; background-color:rgba(103, 97, 97, 0.3);">
			    <h3 style="font-weight: 500;">{{trans('main.cocina')}}</h3>
			    <h1><i class="glyphicon glyphicon-cutlery"></i></h1>
			</div>
		</div>
		<div class="col-lg-4" style="text-align: center;">
		    <div class="jumbotron" style="margin: 20px; background-color:rgba(103, 97, 97, 0.3);">
			    <h3 style="font-weight: 500;">{{trans('main.recepcion')}}</h3>
			    <h1><i class="glyphicon glyphicon-list-alt"></i></h1>
			</div>
		</div>
		<div class="col-lg-4" style=" text-align: center;">
		    <div class="jumbotron" style="margin: 20px; background-color:rgba(103, 97, 97, 0.3);">
			    <h3 style="font-weight: 500;">{{trans('main.Configuracion')}}</h3>
			    <h1><i class="icon  fa fa-cogs"></i></h1>
			</div>
		</div>
	</div>
</div>
@stop