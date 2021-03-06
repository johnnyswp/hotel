<?php $template = $hotel->theme; ?>

@extends("roomers.themes.$template.master_services")

@section('title', trans('main.catalog'))

@section('container')
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
	 
	.text-catg{
		color:White;    border: 1px solid;line-height: 1;    text-align: center;
	}
	.text-catg span{
		font-size:12px;
	}	
</style>
<div id="welcome" class="col s12 m8 offset-m2">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
			$back = "/roomer/servicios";
		?>	 			
			@include("roomers.themes.$template.partials.navBar-services")
			
			@include("roomers.themes.$template.partials.header")			
			
		<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">{{ $lang->txt_servicios}}</h5>
		</div>
		 
		<div class="row">
			 @foreach($business as $cat)
			<a style="margin: 10px 0;" href="{{url('roomer/servicio-item/')}}/{{$cat->id}}" class="col s12 m12 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{BusinessLang::where('business_id',$cat->id)->first()->name}} </span>
				<div class="card-image z-depth-2">
					<img src="{{$cat->picture}}">
				</div>
			</a>
			@endforeach	
		</div>	
		 
		 
	</div>
</div>
@stop