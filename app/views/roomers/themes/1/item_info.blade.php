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
			$back = "/roomer/info-list/".$business->category_id;
		?>	 
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")			
		<!--<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">!! {{$lang->txt_catalogo}}</h5>
		</div>-->
		
		<div class="row">
		 
			<a style="margin: 30px 0;" class="col s12 m12 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{InfoPlaceLang::where('info_place_id',$business->id)->where('language_id',$lang->id)->first()->name}}</span>
				<div class="card-image z-depth-2">
					<img src="{{$business->picture}}">
				</div>
			</a>

			<a style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-list-alt" aria-hidden="true" style="color:black; font-size: 20px;"></i>  
				<span>{{InfoPlaceLang::where('info_place_id',$business->id)->where('language_id',$lang->id)->first()->description}}</span>
			</a>
			<a href="{{$business->link}}" style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-link" aria-hidden="true" style="color:black; font-size: 20px;"></i> 
				<span>{{InfoPlaceLang::where('info_place_id',$business->id)->where('language_id',$lang->id)->first()->link}}</span>
			</a>
		 
		</div>	
		 
		 
	</div>
</div>
@stop