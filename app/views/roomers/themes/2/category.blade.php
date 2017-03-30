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
		background: #780001 !important;
		position: absolute;
		display: block;
		    bottom: -126px;
		    width: 59%;
		    right: 1%;
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
				<i class="material-icons white-text">keyboard_backspace</i>
				<span class="white-text" style="position: relative; top: -4px; ">{{$lang->txt_catalogo}}</span>
			</a>
		<div  class="col s12 m12">
			<h5 class="white-text">{{$category->category_name}}</h5>
		</div>
		<div class="row">
			@foreach($items as $item)

			<div  class="col s12 m12 item" style="    padding: 0 5px; margin: 15px 0;">
				<span class="card-title truncate" style="width: 57%;display: inline;position: absolute; top: 0;left: 41%;background: #780001;">
					<b> {{$item->item_name }} </b> 
				</span>				
				<div class="card-image z-depth-2">
					
					<a style="display: inline-block; width: 40%;float: left; " href="{{url('roomer/item/')}}/{{$item->item_id}}?dt={{ Input::get('dt')}}">
						<img src="{{$item->item_picture}}">
					</a>
					<a  style="display: inline-block; width: 59%; float: left; padding-top: 20px; padding-left: 5px; height: 105px; word-break: break-all; line-height: .95;    font-size: 12px; border: 5px solid #780001; overflow: hidden;"  class="white-text" href="{{url('roomer/item/')}}/{{$item->item_id}}?dt={{ Input::get('dt')}}"> {{$item->item_description}} </a>
					<div class="card-action" >
						<a href="#" class=""> <b>{{$exchange}} {{$item->item_price}} </b></a>
						<a   href="#less" class="less0 less_" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}" style="right: 42px; "><b><i class="material-icons">remove_circle</i></b></a>
						<span id="num0-{{$item->item_id}}" class="number-text0" style="    right: 23px; position: absolute; width: 20px; text-align: center;"  > </span>
						<script>
						var id = "num0-{{$item->item_id}}";
						var num = "{{$item->item_id}}";
						ll(id,num);
						</script>
						<a href="#add" class="add" data-description="{{$item->item_description}}" data-name="{{$item->item_name}}" data-time="{{$item->item_time}}" data-exchange="{{$exchange}}"  data-picture="{{$item->item_picture}}" data-price="{{$item->item_price}}" data-id="{{$item->item_id}}"><b><i class="material-icons">add_circle</i></b></a>
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