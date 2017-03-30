@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="alta_user">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel corner-flip">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.Editar')}}</strong> {{trans('main.user')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($user, ['files' => 'true', 'method' => 'PATCH', 'route' => ['hotel.users.update', $user->id]]) }}
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
                    <?php $pos = strpos($user->email, 'notuser'); ?>
                    @if ($pos === false)
					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>
						<div>
						    {{ Form::text('email', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('email', $errors) }}
						</div>
					</div>
					@else
					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>
						<div>
						    {{ Form::text('email', '', ['class' => 'form-control']) }}
						    {{ errors_for('email', $errors) }}
						</div>
					</div>
					@endif

					<div class="form-group">
					    <label class="col-md-12" style="padding-left: 0;">{{trans('main.phone')}}</label>
						<div class="col-md-3" style="padding-left: 0;">
						    {{ Form::select('country_id', $countries, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
						</div>
						<div class="col-md-9" style="padding-right: 0;">
						    {{ Form::text('phone', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('phone', $errors) }}
						</div>
					</div>

					<div class="form-group col-md-12">
                        <label class="control-label">{{trans('main.password')}}</label>
                        <div>
                            <a href="#" id="password" data-type="text" data-pk="{{$user->id}}" data-placement="right" data-placeholder="{{trans('main.required')}}" data-title="{{trans('main.enter new password')}}"></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6"><label class="control-label">{{trans('main.recepcion')}}</label></div>
                        <div class="col-md-6"><label class="control-label">{{trans('main.cocina')}}</label></div>
						<div class="col-md-6 iSwitch flat-switch">
							<div class="switch">
								<input name="type_user[]" value="1" type="checkbox" @if($user->type_user==0 or $user->type_user==1) checked @endif>
							</div>
						</div>
						<div class="col-md-6 iSwitch flat-switch">
							<div class="switch">
								<input name="type_user[]" value="2" type="checkbox" @if($user->type_user==0 or $user->type_user==2) checked @endif>
							</div>
						</div>
						<div class="col-md-12" >{{ errors_for('type_user', $errors) }}</div>
						
					</div>

					<div class="form-group offset col-md-12" style="margin-top: 15px;">
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

@section("script")
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="{{url('assets/plugins/typeahead/typeahead.bundle.min.js')}}"></script>
@stop

@section('js-script')
$('#password').editable({
    url: '{{url('change-pass')}}',
    name: 'password',
    title: 'Enter New Password',
    validate: function(value) {
        if ($.trim(value) == '') return 'This field is required';
    }
});

$('#birthday').datetimepicker({
    locale: '{{Helpers::lang()}}',
    format: 'DD-MM-YYYY'
});

@stop