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
		?>
	 
		@include("roomers.themes.$template.partials.header")		
			
		<div  class="col s12 m12">
		 <br>
		</div>


		<div class="row">
			 <a href="/roomer/servicios" class="text-catg waves-effect waves-white flow-text col s5" style="margin-right: 14%;"><span>  {{$lang->txt_informacion_de_servicio}}</span> <i class="fa fa-info-circle fa-5x" aria-hidden="true"></i></a>
			 <a href="/roomer/actividades?day=0"   class="text-catg waves-effect waves-white flow-text col s5"><span> {{$lang->txt_programa_de_actividades}} </span><i class="fa fa-calendar fa-5x" aria-hidden="true"></i></a>
		</div>	
		<div class="row" style="margin-top:20px">
			 <a href="/roomer"  class="text-catg waves-effect waves-white flow-text col s5" style="margin-right: 14%;"><span>  {{$lang->txt_de_servicios_de_habitaciones}} </span><i class="fa fa-cutlery fa-5x" aria-hidden="true"></i></a>
			 <a href="/roomer/info-list"    class="text-catg waves-effect waves-white flow-text col s5 "><span>  {{$lang->txt_informacion_de_alrededores}} </span><i class="fa fa-info-circle fa-5x" aria-hidden="true"></i></a>
		</div>	
		 
	</div>
</div>
@stop