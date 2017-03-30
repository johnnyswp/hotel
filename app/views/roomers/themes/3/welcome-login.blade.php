<?php $template = $hotel->theme; ?>

@extends("roomers.themes.$template.master_roomers_login")

@section('title', 'Welcome')

@section('container')

<div id="welcome" class="col s12 m9 l6 offset-m1 offset-l3">
	<div class="card-panel teal box " style="position:relative">
		<?php 
			$template = $hotel->theme;
		?>
		@include("roomers.themes.$template.partials.navBar-login")
		@include("roomers.themes.$template.partials.header-login")
		<div  class="col s12 m12">
				{{ Form::open(array('class'=>'col s12', 'style'=>'margin-left: 0; padding-left: 0;','action' => 'RoomerController@postCheckLogin'))}} 

				<div class="row" >

					<div class="input-field col s12" style="margin-left: 0; padding-left: 0;">
						<input id="username" name="username" type="text" class="validate" style="height: 53px; font-size: 45px; font-weight: 800;border-bottom: 1px solid #FFFFFF;">
						<input value="{{$lang->id}}" id="lang" name="lang"  type="hidden">
						<label for="username" style="left:0; color:white">{{$lang->txt_username}}</label>
					</div>
					<ul class="parsley-error-list">
						<li class="mincheck red-text" style="display: list-item; font-weight: 700; text-shadow: 2px 2px 6px #7CB342; color: #B71C1C !important;">
							<?php echo $errors->first('username'); ?>																	
							@if (Session::has('mgs'))
							 {{ Session::get('mgs') }} 
							@endif
						</li>
					</ul> 
					<div class="input-field col s12" style="margin-left: 0; padding-left: 0;">
						<input id="token" name="token" type="text" class="validate" style="height: 53px; font-size: 45px; font-weight: 800;border-bottom: 1px solid #FFFFFF;">
						<label for="username" style="left:0; color:white">{{$lang->txt_pass}}</label>
					</div>
					<ul class="parsley-error-list">
						<li class="mincheck red-text" style="display: list-item; font-weight: 700; text-shadow: 2px 2px 6px #7CB342; color: #B71C1C !important;">
							<?php echo $errors->first('token'); ?>																	
							@if (Session::has('mgspass'))
							 {{ Session::get('mgspass') }} 
							@endif
						</li>
					</ul> 
					<label class="white-text">* {{$lang->txt_message_ingresar_contrasena}}</label>

					<div class="input-field col s12">
						<button class="waves-effect waves-light btn red darken-4">{{$lang->txt_enviar}}</button>
					</div>
				</div>		
			</form>
		</div>	 			 
	</div>
</div>
@stop