<?php $template = $hotel->theme; ?>

@extends("roomers.themes.$template.master_roomers")

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
	 
	.textP{
		color:White;    line-height: 1.25;    text-align: left;
	}
	.textP span{
		font-size:18px;
	}	
	.textP i.fa {
		margin-right: 15px;
	}

</style>
<div id="welcome" class="col s12 m8 offset-m2">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
			$back = "/roomer/servicios-list/".$business->service_id;
		?>	 
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")			
		<!--<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">!! {{$lang->txt_catalogo}}</h5>
		</div>-->
		@if($business=='0')
			<div class="row">
			<a style="margin: 10px 0;" href="#" class="col s12 m12 waves-effect waves-white">
				 No existe Datos
			</a>
			</div>
		@else
		<div class="row">
		 
			<a style="margin: 10px 0;" href="#" class="col s12 m12 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{ BusinessLang::where('business_id',$business->id)->first()->name 	}} </span>
				<div class="card-image z-depth-2">
					<img src="{{$business->picture}}">
				</div>
			</a>
            @if($pro)
			<a href="/roomer/categoria-producto-item/{{$business->id}}" style="margin-bottom: 30px; font-size:14px;"  class="col s6 m6 btn waves-effect waves-white">
				<span>{{$lang->txt_ver_productos}}</span>
			</a>
            @endif

			
			
			<a style="margin-bottom: 10px;"  class="col s12 m12 waves-effect waves-white textP">
				<p>
					<img src="{{asset('assets/ico/reloj.png')}}" class="img-responsive" style="width: 20px;"> 
				    <span style="margin-left: 10px;"> {{BusinessLang::where('business_id',$business->id)->first()->horario}}</span>
				</p>
				<p>
					<i class="fa fa-phone" aria-hidden="true" style="color:black; font-size: 20px;"></i> 
				     <span> {{$business->phone}}</span>
				</p>
			</a>

			<a style="margin-bottom: 15px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-list-alt" aria-hidden="true" style="color:black; font-size: 20px;"></i>  
				<span>{{BusinessLang::where('business_id',$business->id)->first()->description}}</span>
			</a>
		</div>	
		@endif
		 
	</div>
</div>
@stop