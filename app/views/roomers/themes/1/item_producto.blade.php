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
			$back = "/roomer/categoria-producto-item/".$business;
		?>	 
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")			
	 
		<div class="row">		 
		    @foreach($productos as $item)
			 
            <div  class="col s6 m3 item">
				<span class="card-title truncate">
					<b> {{MenuLang::where('menu_id',$item->id)->where('language_id',$lang->id)->first()->name}} </b> 
				</span>				
				<div class="card-image z-depth-2">					
					<a href="/roomer/item-detalle/{{$item->id}}">
						<img src="{{$item->picture}}">
					</a>
					<div class="card-action">
						<a href="#" class=""> <b>{{$exchange}} {{$item->price}} </b></a>
					</div>
				</div>
			</div>
			@endforeach				 
		</div>	
		 
		 
	</div>
</div>
@stop