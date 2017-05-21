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
	 
	.text-catg{
		color:White;    border: 1px solid;line-height: 1;    text-align: center;
	}
	.text-catg span{
		font-size:12px;
	}	

    .textP{
		color:White;    line-height: 1.25;    text-align: left;
		margin-left: 15px;
	}
	.textP span{
		font-size:18px;
	}	
	.textP i.fa {
		margin-right: 10px;
	}
</style>
<div id="welcome" class="col s12 m8 offset-m2">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
			$back = "/roomer/seleccion";
		?>	 
		@include("roomers.themes.$template.partials.navBar-services")
		@include("roomers.themes.$template.partials.header")	
        <div class="row">
            <div class=" col s12 m12">
            <?php $myday2 = Input::get('day') - 1; ?>
                <a href="/roomer/actividades?day={{$myday2}}" class="waves-effect waves-light btn modal-trigger left btn-ico" style="padding: 0 10px;">
			      <i class="material-icons">keyboard_arrow_left</i>
		        </a>
		        <a style="margin: 0 auto; text-align: center;width: 49%;display: block;  font-size: 1em;color: blue;">{{$fechita}}</a>
                <a href="/roomer/actividades?day={{$myday}}" class="waves-effect waves-light btn modal-trigger right btn-ico"  style="padding: 0 10px; position: relative; top: -21px;">
			      <i class="material-icons">keyboard_arrow_right</i>
		        </a>
            </div>
        </div>
		<!--<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">!! {{$lang->txt_catalogo}}</h5>
		</div>-->
		 
		<div class="row">
	        
	        @if($vacio)
	        <div class="card teal">
	            <a style="margin: 10px 0;" href="" class="waves-effect waves-white">
					<div class="card-image z-depth-2">
						 <h5 class="textP">{{$lang->txt_no_hay_actividades}}</h5>
					</div>
				</a>
			</div>
	        @endif

			@foreach($actividades as $cat)
			<div class="card teal">
			<a style="margin: 5px 0;" href="{{url('roomer/actividad-item/')}}/{{$cat->id}}" class="col s12 m12  waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->name}} <span style="    float: right; font-size: 12px; margin-top: 4px;"> {{$cat->since}}  - {{$cat->until}}</span></span>
				<div class="card-image">
					<img src="{{$cat->picture}}">
				</div>
			</a>
			</div>
			@endforeach	
		</div>	
		 
		 
	</div>
</div>
@stop