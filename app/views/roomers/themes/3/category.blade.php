<?php $template = $hotel->theme; ?>
@extends("roomers.themes.$template.master_roomers")

@section('title', trans('main.category'))

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
</script>
<style>
	.item .card-action{
		background: rgb(219, 213, 151) !important;
	}
</style>
<div id="welcome" class="col s12 m12 l8 offset-l2 ">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
		?>
		@include("roomers.themes.$template.partials.navBar")
		@include("roomers.themes.$template.partials.cart")
		@include("roomers.themes.$template.partials.header")
		
		<a href="/roomer/catalog?dt={{ Input::get('dt')}}" class="btn-flat waves-effect waves-light back_  back " style="padding: 0 10px; color: white; float: left; clear: both;" >
				<i class="material-icons">keyboard_backspace</i>
				<span style="position: relative; top: -4px; ">{{$lang->txt_catalogo}}</span>
			</a>
		<div  class="col s12 m12">
			<h5>{{$lang->txt_categoria}}: {{$category->category_name}}</h5>
		</div>
		<div class="row">
			@foreach($items as $item)

			<div  class="col s12 m12 item" style="   border-top: 2px solid  #666; border-bottom: 2px solid  #666; padding: 0; margin: 15px 0;">
				<span class="card-title truncate" style="width: auto; display: inline; position: absolute; top: 0;  left: 16px; background: transparent !important;">
					<b> {{$item->item_name }} </b> 
				</span>				
				<div class="card-image z-depth-2">
					
					<a style="border-left: 10px solid;display: inline-block; width: 80%;float: left; padding-top: 20px;  padding-left: 10px; height: 105px; word-break: break-all;overflow: hidden;line-height: .95; color: #666;"  href="{{url('roomer/item/')}}/{{$item->item_id}}?dt={{ Input::get('dt')}}" title="">
					{{$item->item_description}}
					</a>
					<div class="card-action" style="display: inline-block; width: 18%;float: left; top:0px; padding-top: 20px; padding-left: 0px; height: 105px; word-break: break-all;overflow: hidden;line-height: .95; color: #666;    background: #666 !important;"  >
						<a href="#" style="width: 100%;text-align: center;font-size: 1.5rem;display: block;padding-top: 12px;"> <b>{{$exchange}} {{$item->item_price}} </b></a>
						<a   href="#less"  class="less0 less_" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}" style="right: 42px;bottom: 10px; "><b><i class="material-icons">remove_circle</i></b></a>
						<span id="num0-{{$item->item_id}}" class="number-text0" style="    left: 30px; position: absolute; width: 20px; text-align: center; bottom:18px;"  > </span>
						<script>
						var id = "num0-{{$item->item_id}}";
						var num = "{{$item->item_id}}";
						ll(id,num);
						</script>
						<a href="#add" class="add" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}" style="bottom: 10px; "><b><i class="material-icons">add_circle</i></b></a>
					</div>
				</div>	
				@if(!$item->item_available)
						<a href="{{url('roomer/item/')}}/{{$item->item_id}}?dt={{ Input::get('dt')}}&a=1">
						
						<div class="aviable">
							{{$lang->txt_no_vailable}}
						</div>
						</a>
					@endif
			</div>
			@endforeach	 	
		</div>	 			 
	</div>
</div>
@stop