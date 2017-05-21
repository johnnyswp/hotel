<?php $template = $hotel->theme; ?>
@extends("roomers.themes.$template.master_roomers")

@section('title',$item->item_name)

@section('container')
<div id="welcome" class="col s12 m12 l8 offset-l2 " style="padding:0">
	<div class="card-panel teal box " style="position: relative; padding: 0; margin: 0; height: 140px;">
		<?php 
			$template = $hotel->theme;
			$back = "/roomer/producto-item/".$item->category_id;
		?>
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")			
	</div>
	<div class="card-panel teal box " id="item_menu" style="margin: 0;">
		<div  class="col s12 m12 item">
			<span class="card-title truncate">
				<b> {{MenuLang::where('menu_id',$item->id)->where('language_id',$lang->id)->first()->name}} </b> 
			</span>				
			<div class="card-image">
				<img src="{{$item->picture}}">
			</div>	
			<div class="card-action">
				<a   href="#" class=""> <b>{{$exchange}} {{$item->price}} </b></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div  class="col s12 white m12">
			<h5 class="flow-text" style="margin-top:14px;"><b>{{$lang->txt_categoria}}: </b><br>{{CategoryLang::where('category_id',$item->category_id)->where('language_id',$lang->id)->first()->name}}</h5>
			<div class="item_description">
				<h5 class="flow-text" style="margin:0;"><b>{{$lang->txt_descripcion}}: </b></h5>
				<p class="flow-text " style="    margin-top: 5px;">{{MenuLang::where('menu_id',$item->id)->where('language_id',$lang->id)->first()->description}}</p>		
				<div class="clearfix"></div>		
			</div>
		</div>
	</div>

</div>

@stop

