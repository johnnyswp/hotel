@extends('hotel.master') 
<?php use Carbon\Carbon; ?>
@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel corner-flip">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.personal data')}}</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($user, ['class' => 'cmxform form-horizontal adminex-form', 'files' => 'true', 'method' => 'PATCH', 'action'=>'HotelController@anyProfileSave']) }}
				   {{ Form::hidden('birthday', NULL, ['id'=>'birthday']) }}
					<div class="form-group">
						<label class="control-label">{{trans('main.name')}}</label>
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
						    {{ Form::text('username', NULL, ['class' => 'form-control', 'disabled'=>'true']) }}
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

                    @if($user->type_user==3)
					<div class="form-group">
						<label class="control-label">{{trans('main.fn')}}</label>
						<div>
						    {{ Form::text('date', Carbon::parse($user->birthday)->format("d-m-Y"), ['class' => 'form-control', 'id'=>'date']) }}
						    {{ errors_for('birthday', $errors) }}
						</div>
					</div>
					
					<div class="form-group">
                        <label class="control-label">{{trans('main.country')}}</label>
                        <div>
                            {{ Form::select('country_id', $countries, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                            {{ errors_for('country_id', $errors) }}
                        </div>
                    </div>
                    @endif

					<div class="form-group">
						<label class="control-label">{{trans('main.phone').' '.trans('main.sin codigo de pais')}}</label>
						<div>
						    {{ Form::text('phone', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('phone', $errors) }}
						</div>
					</div>

					<div class="form-group col-ms-12">
                        <label for="firstname" class="control-label col-md-2">{{trans('main.password')}}</label>
                        <div class="col-md-4">
                            <a href="#" id="password" data-type="text" data-pk="{{$user->id}}" data-placement="right" data-placeholder="{{trans('main.required')}}" data-title="{{trans('main.enter new password')}}"></a>
                        </div>
                    </div>

					<div class="form-group col-ms-12">
    			    	<label class="control-label col-md-2">{{trans('main.picture')}}</label><br>
    			    	<div class="col-sm-10">
    			    		<div class="fileinput fileinput-exists" data-provides="fileinput">
    			    			<input type="hidden" value="" name="">
    			    			<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
    			    				<img src="@if($user->picture) {{$user->picture}} @else {{url('assets/img/avatar.png')}} @endif" />
    			    			</div>
    			    		<div>
    			    			<span class="btn btn-default btn-file">
    			    				<span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
    			    				<input type="file" name="picture" accept="image/*">
    			    			</span>
    			    		<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
    			    		</div>
    			    	</div>
    			    	<br>
    			    	<span class="label label-danger ">{{trans('main.note')}}</span>
    			    	<span>{{trans('main.you must select single files of')}}</span>
    			    	</div>
                        {{ errors_for('picture', $errors) }}
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

@section("script")
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="{{url('assets/plugins/typeahead/typeahead.bundle.min.js')}}"></script>
@stop

@section('js-script')
//defaults
$.fn.editable.defaults.url = 'data/x-post.php';

$('#password').editable({
    url: '{{url('change-pass')}}',
    name: 'password',
    title: '{{trans('main.enter new password')}}',
    validate: function(value) {
        if ($.trim(value) == '') return '{{trans('main.Este campo es requerido')}}';
    }
});

$('#date').datetimepicker({
    locale: '{{Helpers::lang()}}',
    format: 'DD-MM-YYYY',
    viewMode: 'years',
});

$("#date").on("dp.hide", function (e) {
    fecha = moment($(this).val(), "DD-MM-YYYY").format("YYYY-MM-DD"); 
    $("#birthday").val(fecha);
});

@stop