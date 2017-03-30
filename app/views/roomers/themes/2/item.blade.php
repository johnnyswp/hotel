<?php $template = $hotel->theme; ?>
@extends("roomers.themes.$template.master_roomers")

@section('title', $item->item_name)

@section('container')
<script type="text/javascript">
	function ll (id,num) {
		$('#'+id).ready(function() {
			var elem = 'elem_'+num;
			var a = store.get(elem); 
			if(store.get(elem)==null || store.get(elem) ===undefined){
				$('#'+id).text('0');
			}else{
				var item = store.get(elem);
				$('#'+id).text(item.count);
			}
		});
	}
	shopcar.setItemHorario('{{$item->item_id}}','{{$hotel->id}}');
</script>
<style>
	.item .card-action {
	    position: absolute;
	    display: block;
	    bottom: 0;
	    width: 100%;
	    right: 0;
	}
</style>
<div id="welcome" class="col s12 m12 l8 offset-l2 " style="padding:0">
	<div class="card-panel teal box " style="position: relative; padding: 8px 0px;">
		<?php 
			$template = $hotel->theme;
		?>
		@include("roomers.themes.$template.partials.navBar")
		@include("roomers.themes.$template.partials.cart")			
	</div>
	<a   href="/roomer/catalog" class="btn-flat waves-effect waves-light back_  back " style="    padding: 0 10px; color: white; position: absolute; z-index: 99; width: 43px; height: 41px; background: #780001; top: 12px; left: 5px;" >
		<i class="material-icons">keyboard_backspace</i>
		<span class="white-text" style="position: relative; top: -4px; ">{{$lang->txt_atras}}</span>
	</a>
	<div class="card-panel teal box " id="item_menu">
		<div  class="col s12 m12 item">
			<span class="card-title truncate">
				<b> {{$item->item_name }} </b> 
			</span>				
			<div class="card-image">
				<a href="{{url('roomer/item/')}}/{{$item->item_id}}">
					<img src="{{$item->item_picture}}">
				</a>

			</div>	
			<div class="card-action" style="background: rgba(119, 0, 0, 0.85);">
				@if($item_available)
					<div class="aviable" style="top: -27px; height: 40px !important; padding: 33px 0 55px;">
						{{$lang->txt_no_vailable}}
					</div>
				@endif
				<a   href="#" class=""> <b>{{$exchange}} {{$item->item_price}} </b></a>
				<a   href="#less" class="less0 less_" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}" ><b><i class="material-icons medium">remove_circle</i></b></a>
				<span id="num0-{{$item->item_id}}" class="number-text0" style=""  > </span>
				<script>
					var id = "num0-{{$item->item_id}}";
					var num = "{{$item->item_id}}";
					ll(id,num);
				</script>
				<a href="#add" class="add" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}"><b><i class="material-icons medium">add_circle</i></b></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div  class="col s12 white m12">
			<h5 class="flow-text" style="margin-top:14px;"><b>{{$lang->txt_categoria}}: </b><br>{{$category->category_name}}</h5>
			<div class="item_description">
				<h5 class="flow-text" style="margin:0;"><b>{{$lang->txt_descripcion}}: </b></h5>
				<p class="flow-text " style="    margin-top: 5px;">{{$item->item_description}}</p>		
				<div class="clearfix"></div>		
			</div>
			<div class="clearfix"></div>		
			<h5 class="flow-text" style="margin-top:14px;"><b>{{$lang->txt_delayed}}: </b><br>{{$item->item_time}}</h5>
			<div class="clearfix"></div>		
			<h5 class="flow-text" style="margin-top:14px;"><b>{{$lang->txt_horario_disponible}}:</h5>
			<div class="item_description" id="horario">

			</div>
		</div>
	</div>

</div>


@stop

