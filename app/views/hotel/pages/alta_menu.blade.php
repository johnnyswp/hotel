@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.alta de')}}</strong>  {{trans('main.menu')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::open(array('action' => 'HotelMenuController@store', 'files'=>true))}} 
					
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.category')}}</label>
                        <div>
                            {{ Form::select('category_id', $categories, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                            {{ errors_for('category_id', $errors) }}
                        </div>
                    </div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.price').' '.trans('main.mesage punto')}}</label>
                        <div>
                            {{ Form::text('price', null, ['class' => 'form-control', 'autocomplete'=>'off']) }}
                            {{ errors_for('price', $errors) }}
                        </div>
                    </div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.delivery time')}}</label>
                        <div>
                            {{ Form::number('delivery_time', null, ['class' => 'form-control', 'autocomplete'=>'off']) }}
                            {{ errors_for('delivery_time', $errors) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{trans('main.codigo externo')}}</label>
                        <div>
                            {{ Form::text('code', null, ['class' => 'form-control', 'autocomplete'=>'off']) }}
                            {{ errors_for('code', $errors) }}
                        </div>
                    </div>

					<div class="form-group col-ms-12">
						<label class="control-label">{{trans('main.select a Picture')}}</label><br>
						<div>
							<div class="fileinput fileinput-exists" data-provides="fileinput">
								<input type="hidden" value="" name="">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
									<img src="/assets/img/no-image.png" />
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
					    @if($lang->main==1)
					    <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}({{trans('main.lang')}})</label>
					    <div class="form-group">
					    	<div>
					    		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                {{ errors_for($lang->language->language, $errors) }}
					    	</div>
					    </div>
					    <div class="form-group">
					    	<div>
					    		{{ Form::textarea('descrption_'.$lang->language->language, NULL, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang->language->language, 'autocomplete'=>'off']) }}
                                {{ errors_for('descrption_'.$lang->language->language, $errors) }}
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
                        <label class="control-label">{{trans('main.type of schedule')}}</label>
						<div class="iSwitch flat-switch">
							<div class="switch">
								<input name="type_of_schedule" value="1" type="checkbox" id="type_of_schedule">
							</div>
						</div>
                    </div>
                    
                    <div id="schedule" style="display: none;">
                    <label class="control-label">{{trans('main.Horario de disponibilidad')}}</label><br/>
                    @foreach($weekdays as $weekday => $value)
                    <div class="col-lg-12" style="border-bottom: 1px solid #E4E4E4; margin-bottom: 10px;">
                        <label class="control-label col-lg-12">{{trans('main.'.$value)}}</label>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_1_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Desde 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 1</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_1_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Hasta 1', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_1_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Desde')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('desde_2_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Desde 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('desde_2_'.$value, $errors) }}
					    	</div>
					    </div>
					    <div class="col-lg-3">
					        <label class="control-label">{{trans('main.Hasta')}} 2</label>
					    	<div class="form-group">
					    		{{ Form::text('hasta_2_'.$value, NULL, ['class' => 'form-control timepicker', 'placeholder'=>'Hasta 2', 'autocomplete'=>'off']) }}
                                {{ errors_for('hasta_2_'.$value, $errors) }}
					    	</div>
					    </div>
					</div>
                    @endforeach
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
$('#type_of_schedule').change(function() {
    var $input = $(this);  
    var check = $input.prop( "checked" );
    if(check){
        $('#schedule').css('display', 'block');
    }else{
        $('#schedule').css('display', 'none');
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
@stop