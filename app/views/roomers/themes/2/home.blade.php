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
</style>
<div id="welcome" class="col s12 m8 offset-m2">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
		?>
		@include("roomers.themes.$template.partials.navBar")
		@include("roomers.themes.$template.partials.cart")
		@include("roomers.themes.$template.partials.header")		
			
		<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;  color: #780001 !important;" class="center"> {{$lang->txt_catalogo}}</h5>
		</div>


		<div class="row">
 
			 <button id="bt_pi" class="btn card   waves-effect waves-white flow-text col s12">{{$lang->txt_pedido_inmediato}}</button>
			 <button id="bt_pg" class="btn card   waves-effect waves-white flow-text col s12">{{$lang->txt_pedido_programado}}</button>
			 
		</div>	
		<div id="entregaInmediata">
			<input type='hidden' class="datetimepicker" id='datetimepicker2' />
			<input type='hidden'   id='stay_id' value="{{$stay->id}}" />
		</div>
	
		<div id="box_w" style=" display:none; position: relative; top: 45px;">
				<span class="white-text">{{$lang->txt_date}}:</span>				
	        	<input type='text' id='asd' />
				<span class="white-text">{{$lang->txt_time}}:</span>				
	        	<input type='text' id='qwe' />
	        	<a id="okC" date="0" time="0" href="#" class="btn btn-primary">
	        		{{$lang->txt_aceptar}}
	        	</a>
		</div>	
		<div style="clear:both; clear: both; margin: 43px 0;"></div>
	</div>
</div>
<script>
		store.clear();
        store.set('item_list',null);
        store.set('item_time',0);
        store.set('item_total',0);
        store.set('item_num',0);
        var t = "inmediato";
		store.set('item_type',t);
</script>
@stop