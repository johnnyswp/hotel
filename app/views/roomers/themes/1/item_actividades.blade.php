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
		?>	 
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")	
        <div class="row">
           
        </div>
		<!--<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">!! {{$lang->txt_catalogo}}</h5>
		</div>-->
		 
		<div class="row">
			<a style="margin: 10px 0;"   class="col s12 m12 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->name}} <!--<span style="    float: right; font-size: 12px; margin-top: 4px;"> {{$cat->since}}  - {{$cat->until}}</span>--></span>
				<div class="card-image z-depth-2">
					<img src="{{$cat->picture}}">
				</div>
			</a>

            <a style="margin: 10px 0; padding-left: 0;"  class="col s12 m12 waves-effect waves-white textP">
				<img src="{{asset('assets/ico/reloj.png')}}" class="img-responsive" style="width: 20px;"> 
				<span> {{$cat->since}}  - {{$cat->until}}</span>
			</a>            
            <a style="margin: 10px 0; padding-left: 0;"  class="waves-effect waves-white textP">
				<img src="{{asset('assets/ico/publico.png')}}" class="img-responsive" style="width: 20px;"> 
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->public}}</span>
			</a>
<br>
            <a style="margin: 10px 0; padding-left: 0;"  class="waves-effect waves-white textP">
				<img src="{{asset('assets/ico/lugar.png')}}" class="img-responsive" style="width: 20px;"> 
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->zone}}</span>
			</a>
			<a style="margin: 10px 0; padding-left: 0;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-info" aria-hidden="true" style="color:black; font-size: 20px;"></i>
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->description}}</span>
			</a>

            
			 
		</div>	
		 
		 
	</div>
</div>
@stop