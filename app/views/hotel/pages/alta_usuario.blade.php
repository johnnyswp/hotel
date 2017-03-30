@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="alta_user">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel corner-flip">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.alta de')}}</strong> {{trans('main.user')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::open(['class' => 'cmxform form-horizontal adminex-form', 'files' => 'true', 'method' => 'POST', 'action'=>'HotelUsersController@store']) }}
					<div class="form-group">
						<label class="control-label">{{trans('main.first name')}}</label>
						<div>
						    {{ Form::text('first_name', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('first_name', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.last name')}}</label>
						<div>
						    {{ Form::text('last_name', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('last_name', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.position')}}</label>
						<div>
						    {{ Form::text('position', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('position', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.username')}}</label>
						<div>
						    {{ Form::text('username', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('username', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>
						<div>
						    {{ Form::text('email', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('email', $errors) }}
						</div>
					</div>

					<div class="form-group">
					   <label style="padding-left: 0;" class="col-md-12">{{trans('main.phone')}}</label>
						<div class="col-md-3" style="padding-left: 0;">
						    
						    {{ Form::select('country_id', $countries, Hotel::where('user_id', Sentry::getUser()->id)->first()->country->id, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
						</div>
						<div class="col-md-9" style="padding-right: 0;">
						    {{ Form::text('phone', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('phone', $errors) }}
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.password')}}</label>
                        <div>
                        {{ Form::text("password", NULL, ['class' => 'form-control', 'placeholder'=>'6-8 '.trans('main.Characters'),'parsley-rangelength'=>'[6,8]', 'parsley-trigger'=>'keyup',  'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                        {{ errors_for('password', $errors) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{trans('main.password confirmation')}}</label>
                        <div>
                        {{ Form::text("password_confirmation", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.password confirmation'),'parsley-rangelength'=>'[6,8]', 'parsley-trigger'=>'keyup',  'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-md-6"><label class="control-label">{{trans('main.recepcion')}}</label></div>
                        <div class="col-md-6"><label class="control-label">{{trans('main.cocina')}}</label></div>
						<div class="col-md-6 iSwitch flat-switch">
							<div class="switch">
								<input name="type_user[]" value="1" type="checkbox">
							</div>
						</div>
						<div class="col-md-6 iSwitch flat-switch">
							<div class="switch">
								<input name="type_user[]" value="2" type="checkbox">
							</div>
						</div>
						<div class="col-md-12" >{{ errors_for('type_user', $errors) }}</div>
						
					</div>

					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</section>
		</div>
	</div>
</div>


@stop