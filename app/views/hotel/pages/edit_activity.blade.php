@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.Editar')}}</strong> {{trans('main.activity')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($activity, ['files' => 'true', 'method' => 'PATCH', 'route' => ['hotel.activity.update', $activity->id]]) }}
					
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

					<div class="form-group col-ms-12">
						<label class="control-label">{{trans('main.select a Picture')}}</label><br>
						<div>
							<div class="fileinput fileinput-exists" data-provides="fileinput">
								<input type="hidden" value="" name="">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
									<img src="{{$activity->picture}}" />
								</div>
							<div>
								<span class="btn btn-default btn-file">
									<span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
									<input type="file" name="picture">
								</span>
							<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
							</div>
						</div>
						<br>

						<span class="label label-danger ">{{trans('main.note')}}</span>
						<span>{{trans('main.you must select single files of')}}</span>
						</div>
					</div>

					<label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
					<?php $x=0; ?>
					@foreach($langs as $lang)
					    <?php
                            $activityLang = ActivityLang::where('activity_id', $activity->id)->where('language_id', $lang->language_id)->first();
					    ?>
					    @if($activityLang)
					        @if($lang->main==1)
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}({{trans('main.lang')}})</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang->language->language, $activityLang->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::textarea('descrption_'.$lang->language->language, $activityLang->description, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('descrption_'.$lang->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text('public_'.$lang->language->language, $activityLang->public, ['class' => 'form-control', 'placeholder'=>trans('main.public en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('public_'.$lang->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text('zone_'.$lang->language->language, $activityLang->zone, ['class' => 'form-control', 'placeholder'=>trans('main.public en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('zone_'.$lang->language->language, $errors) }}
					        	</div>
					        </div>
					        @else
					            @if($lang->state==0 and $x==0)
                                <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                                <?php $x=1; ?>
                                @endif
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					            <div class="form-group">
					            	<div>
					            		{{ Form::text($lang->language->language, $activityLang->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for($lang->language->language, $errors) }}
					            	</div>
					            </div>
					            <div class="form-group">
					            	<div>
					            		{{ Form::textarea('descrption_'.$lang->language->language, $activityLang->description, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for('descrption_'.$lang->language->language, $errors) }}
					            	</div>
					            </div>
					        @endif
					    @else
					        @if($lang->state==0 and $x==0)
                            <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                            <?php $x=1; ?>
                            @endif
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::textarea('descrption_'.$lang->language->language, NULL, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('descrption_'.$lang->language->language, $errors) }}
					        	</div>
					        </div>
					    @endif
					@endforeach

					<div class="form-group">
                        <label class="control-label">{{trans('main.repetir')}}</label>
						<div class="iSwitch flat-switch">
							<div class="switch">
								<input name="type" value="1" type="checkbox" id="type" @if($activity->type == 1) checked @endif>
							</div>
						</div>
                    </div>
                    <div id="schedule" @if($activity->type == 1) style="display: block;" @else style="display: none;" @endif>
                        <label class="control-label">{{trans('main.dias ha repetir')}}</label><br/>
                        <div class="col-lg-12">
                            <ul class="iCheck"  data-style="line" data-color="aero">
                                @foreach($weekdays as $weekday => $value)
                                <li class="col-lg-4">
					            	<input type="checkbox" name="weekday[]" value="{{$weekday}}" @if(in_array($weekday, explode(',',$activity->daysActivity))) checked @endif>

					            	<label>{{trans('main.'.$value)}}</label>
					            </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div id="deschedule" @if($activity->type == 1) style="display: none;" @else style="display: block;" @endif>
                       <label class="control-label col-lg-12">{{trans('main.dia de la actividad')}}</label>
					    <div class="col-lg-12" style="padding-left: 2px !important; padding-right: 2px !important;">
					    	<div class="form-group">
					    		{{ Form::text('day_aciviti', NULL, ['class' => 'form-control date', 'placeholder'=>trans('main.dia de la actividad'), 'autocomplete'=>'off']) }}
                                {{ errors_for('day_aciviti', $errors) }}
					    	</div>
					    </div>
                    </div>
                    <br/>
                    <div class="col-lg-12">
                        <label class="control-label col-lg-6">Desde</label>
                        <label class="control-label col-lg-6">Hasta</label>
					    <div class="col-lg-6" style="padding-left: 2px !important; padding-right: 2px !important;">
					    	<div class="form-group">
					    		{{ Form::text('since', NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Desde', 'autocomplete'=>'off']) }}
                                {{ errors_for('since', $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-6" style="padding-left: 2px !important; padding-right: 2px !important;">
					    	<div class="form-group">
					    		{{ Form::text('until', NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Desde', 'autocomplete'=>'off']) }}
                                {{ errors_for('until', $errors) }}
					    	</div>
					    </div>
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

@section('js-script')
$('#type').change(function() {
    var $input = $(this);  
    var check = $input.prop( "checked" );
    if(check){
        $('#schedule').css('display', 'block');
        $('#deschedule').css('display', 'none');
    }else{
        $('#schedule').css('display', 'none');
        $('#deschedule').css('display', 'block');
    }
});

$('.selectpicker').selectpicker();

$('.timepicker').timepicker({
    minuteStep: 1,
    template: 'modal',
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});

var min = moment();
$('.date').datetimepicker({
    format: 'DD-MM-YYYY', minDate: min
});

@if($activity->type!=1)
$('.date').val(moment("{{$activity->daysActivity}}", "DD-MM-YYYY").format("DD-MM-YYYY"));
@endif
@stop