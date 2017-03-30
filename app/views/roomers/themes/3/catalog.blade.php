<?php $template = $hotel->theme; ?>
@extends("roomers.themes.$template.master_roomers")

@section('title',trans('main.catalog'))

@section('container')
<script>
	store.set('lang',{{$lang->id}});
</script>
<style>
	.card-image img {
	     width: 100%;
    	height: 125px;
    	display: block;
	}

	span.card-title {
	    font-size: 1.3rem;
	    padding: 12px 0px 7px 0px;
	    display: block;
	}
</style>
<div id="welcome" class="col s12 m12 l12">
	<div class="card-panel teal box " style="position:relative">
		
		@include("roomers.themes.$template.partials.navBar")
		@include("roomers.themes.$template.partials.cart")
		@include("roomers.themes.$template.partials.header")
		<a href="/roomer/" class="btn-flat waves-effect waves-light back_  back " style="padding: 0 10px; color: white; float: left; clear: both;" >
				<i class="material-icons">keyboard_backspace</i>
				<span style="position: relative; top: -4px; ">{{$lang->txt_inicio}}</span>
			</a>
			
		<div  class="col s12 m12">
			
			<h5 style="padding: 0;margin: 0;"> {{$lang->txt_catalogo}}</h5>
		</div>


		<div class="row">
			<!--<a href="" class="col s6 m3 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: #f44336; width: 100%; padding: 15px; top: 25px; z-index: 2; height: 150px; text-align: center;" class="card-title truncate">{{$lang->txt_promociones}} </span>
			</a>-->
			@foreach($categories as $cat)
			<a href="{{url('roomer/category/')}}/{{$cat->category_id}}?dt={{ Input::get('dt')}}" class="col s12 m6 waves-effect waves-white" style="    padding: 0 5px; margin-bottom: 15px;">
				<span style="text-align: center; color: white; text-transform: uppercase;" class="card-title truncate"> {{$cat->category_name}} </span>
			</a>
			@endforeach					 
		</div>	 			 
	</div>
</div>
@stop