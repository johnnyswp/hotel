@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong> {{trans('main.horarios de cocina')}} </strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::open(array('action' => 'HotelController@anyScheduleSave', 'files'=>true))}}
                    <div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>
					
                    <label class="control-label">{{trans('main.Horario de disponibilidad')}}</label><br/>
                    @foreach($weekdays as $weekday => $value)
                    <?php
                        $schedule = Schedule::where('weekday', $weekday)->where('hotel_id', $hotel->id)->first();
                    ?>
                    @if($schedule)
                    <div class="col-lg-12" style="border-bottom: 1px solid #E4E4E4; margin-bottom: 10px;">
                        <label class="control-label col-lg-12">{{trans('main.'.$value)}}</label>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_1_'.$value, $schedule->desde_1, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Desde').' 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_1_'.$value, $schedule->hasta_1, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Hasta').' 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_2_'.$value, $schedule->desde_2, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Desde').' 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_2_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_2_'.$value, $schedule->hasta_2, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Hasta').' 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_2_'.$value, $errors) }}
					    	</div>
					    </div>
					</div>
					@else
					<div class="col-lg-12" style="border-bottom: 1px solid #E4E4E4; margin-bottom: 10px;">
                        <label class="control-label col-lg-12">{{$value}}</label>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_1_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Desde').' 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_1_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Hasta').' 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_2_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Desde').' 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_2_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_2_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>trans('main.Hasta').' 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_2_'.$value, $errors) }}
					    	</div>
					    </div>
					</div>
					@endif
                    @endforeach
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

$('.timepicker').timepicker({
    minuteStep: 1,
    template: 'modal',
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});

@stop