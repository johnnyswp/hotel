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
	#welcome .divider{
		display:none;
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
            <div class=" col s12 m12">
                <a href="/roomer/actividades?day={{$myday}}&type=less" class="waves-effect waves-light btn modal-trigger left btn-ico" >
			      <i class="material-icons">keyboard_arrow_left</i>
		        </a>
                <a href="/roomer/actividades?day={{$myday}}&type=more" class="waves-effect waves-light btn modal-trigger right btn-ico"  >
			      <i class="material-icons">keyboard_arrow_right</i>
		        </a>
            </div>
        </div>
		<!--<div  class="col s12 m12">
			<h5 style="padding: 0;margin: 0 0 20px;" class="center">!! {{$lang->txt_catalogo}}</h5>
		</div>-->
		 
		<div class="row">
			 @foreach($actividades as $cat)
			<a style="margin: 10px 0;" href="{{url('roomer/servicio-item/')}}/{{$cat->id}}" class="col s12 m12 waves-effect waves-white">
				<span style="font-size: 1.2rem; display: block; color: white; position: relative; background: rgba(38, 166, 154, 0.82); width: 100%; padding: 0 5px; top: 0; z-index: 2;" class="card-title truncate">{{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->name}} </span>
				<div class="card-image z-depth-2">
					<img src="{{$cat->picture}}">
				</div>
			</a>

            <a style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-phone" aria-hidden="true"></i> 
				<span> {{$cat->since}}  - {{$cat->until}}</span>
			</a>


            <a style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-phone" aria-hidden="true"></i> 
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->description}}</span>
			</a>

            <a style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-phone" aria-hidden="true"></i> 
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->public}}</span>
			</a>

            <a style="margin-bottom: 30px;"  class="col s12 m12 waves-effect waves-white textP">
				<i class="fa fa-phone" aria-hidden="true"></i> 
				<span> {{ActivityLang::where('activity_id',$cat->id)->where('language_id',$lang->id)->first()->zone}}</span>
			</a>
			@endforeach	
		</div>	
		 
		 
	</div>
</div>
@stop