@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif
<div id="content">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.alta de')}}</strong> {{trans('main.promotion')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
                @if (Session::has('error'))
                <label class="color" style="color: red;">{{ Session::get('error') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::open(array('action' => 'HotelPromoController@store', 'files'=>true))}} 
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>
					<div class="form-group">
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
					<div class="form-group">
						<label class="control-label">Precio</label>
						<div>
							{{ Form::text('price', NULL, ['class' => 'form-control', 'placeholder'=>'price', 'autocomplete'=>'off']) }}
                            {{ errors_for('price', $errors) }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Cantidad de items por promocion</label>
						<div>
							<select name="quantity" class="form-control" id="quantity">
								<?php
									for ($i=1; $i <= 10; $i++) { 
										echo "<option value='".$i."'>".$i."</option>";
									}
								?>
							</select>
						</div>
					</div>
                    <hr style="color: #4E0519" />
					<div class="form-group" id="grupos">
					    <label class="control-label">{{trans('main.Grupo')}} 1</label><br/>
					    <label class="control-label">{{trans('main.Nombres del grupo en idiomas activos')}}</label><br/>
					    <?php $x=0; ?>
					    @foreach($langs as $lang)
					        @if($lang->main==1)
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}({{trans('main.lang')}})</label>
					        	<div>
					        		{{ Form::text('name_group_1_'.$lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        @else
                                @if($lang->state==0 and $x==0)
                                <label class="control-label">{{trans('main.Nombres del grupo en idiomas no activos')}}</label><br/>
                                <?php $x=1; ?>
                                @endif
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					            	<div>
					            		{{ Form::text('name_group_1_'.$lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for($lang->language->language, $errors) }}
					            	</div>
					        @endif
					    @endforeach 
					    	<label class="control-label">Productos grupo 1</label>
					    	<div>
					    		{{ Form::text("items_group_1", NULL, ['class' => 'form-control','id'=>'items', 'placeholder'=>trans('main.items')]) }}
					    	</div>
					</div>
                     <hr style="color: #4E0519" />
					<label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
					<?php $x=0; ?>
					@foreach($langs as $lang)
					    @if($lang->main==1)
					    
					    <div class="form-group">
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}({{trans('main.lang')}})</label>
					    	<div>
					    		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                {{ errors_for($lang->language->language, $errors) }}
					    	</div>
					    </div>
					    @else
					        <div class="form-group">
                            @if($lang->state==0 and $x==0)
                            <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                            <?php $x=1; ?>
                            @endif
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					        
					        	<div>
					        		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					    @endif
					@endforeach 
					<hr style="color: #4E0519" />             
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
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $( "#quantity" ).change(function() {
    	var html = '';
        for (var i=1; i<parseInt($(this).val())+1; i++) {
      	    var x=0;
            html += '<label class="control-label">{{trans('main.Grupo')}} '+i+'</label><br/>'+
		               '<label class="control-label">{{trans('main.Nombres del grupo en idiomas activos')}}</label><br/>';
		    $.each({{$langs}}, function( index, value ) {
		        if(value.main==1){
		            html+= ''+
		                   '    <label class="control-label">{{trans('main.Nombre en')}}'+value.language.language+'({{trans('main.lang')}})</label>'+
		                   '	<div>'+
		                   '		<input class="form-control" placeholder="'+value.language.language+'" autocomplete="off" required="required" name="name_group_'+i+'_'+value.language.language+'" type="text">'+
		                   '	</div>'+
		                   '';
		        }else{
		        	html+='';
                    if(value.state==0 && x==0){
                     html+='    <label class="control-label">{{trans('main.Nombres del grupo en idiomas no activos')}}</label><br/>';
                     x=1;
                    }
		            html+= '    <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>'+
		                   '	<div>'+
		                   '		<input class="form-control" placeholder="'+value.language.language+'" autocomplete="off" required="required" name="name_group_'+i+'_'+value.language.language+'" type="text">'+
		                   '	</div>'+
		                   '';
		        }
		    });
		    html+= ''+
		           '	<label class="control-label">Productos grupo 1</label>'+
		           '	<div>'+
		           '		<input class="form-control" id="items" placeholder="Productos" name="items_group_'+i+'" type="text">'+
		           '	</div> <hr style="color: #4E0519" />'+
		           '';   
        } 
        $('#grupos').html(html);
    });
});
</script>
@stop