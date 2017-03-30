
@extends('receptionists.master') 
@section('title', trans('main.title_check_in'))
@section('content')
@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif
<div id="check_in">	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel" style="" >
			<div class="panel-header">
				<h2 class="pull-right">{{$hotel->getName()}}</h2>
			</div>
			<div class="panel-body" style="">
				@if(isset($mgs))
				<h2>{{$mgs}}</h2>	
				@endif
				{{ Form::model($stay, ['files' => 'true', 'method' => 'PATCH', 'action'=>'ReceptionistSaveController@anyUpdateCheckIn']) }}
					<div class="form-group offset">
						<div>
							<input type="hidden" value="{{$hotel->id}}" name="hotel_id" >
						
							<button type="submit" class="btn btn-theme">{{trans('main.btn-checkin')}}</button>
							<a href="#" onclick="return window.history.back();" class="btn btn-theme" >{{trans('main.atras')}}</a>														
						</div>
					</div>
					<div class="form-group">					
						<h3>{{trans('main.title_check_in_update')}}</h3>
					</div>		
					<div class="form-group">
						<label class="control-label">{{trans('main.nombre completo')}}</label>
						<div>
							{{Form::text('name',null, ['class'=>'form-control']);}}
						</div>
							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('name'); ?>																	
								</li>
							</ul>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>					
						<div class="input-group">
							{{Form::text('email',null, ['class'=>'form-control']);}}							
							<!--<span class="input-group-btn">
								<div class="iSwitch flat-switch">
									<div class="switch switch-small">
											<input type="checkbox" @if($hotel->inform_email) checked @else @endif name="report_email">
									</div>																												
								</div>
							</span>-->
						</div>
						<ul class="parsley-error-list">
							<li class="mincheck" style="display: list-item;">
								<?php echo $errors->first('email'); ?>																	
							</li>
						</ul> 
					</div>
					<div class="form-group username" @if($hotel->type_login!=1) style="display: none" @endif>
						<label class="control-label">{{trans('main.username')}}</label>					
						<div class="input-group">
							{{Form::text('username',null, ['style'=>'width: 95%', 'class'=>'form-control',"autocomplete"=>"off", "oncopy"=>"return false", "ondrag"=>"return false", "ondrop"=>"return false", "onpaste"=>"return false"]);}}
						</div>
						<ul class="parsley-error-list">
							<li class="mincheck" style="display: list-item;">
								<?php echo $errors->first('username'); ?>																
							</li>
						</ul>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.contrasena')}}</label>
						<div>
							{{Form::text('token',null, ['class'=>'form-control']);}}							

						</div>
						<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('token'); ?>																	
								</li>
							</ul>
					</div>
					<div class="form-group">
						<label class="control-label" for="habitacion"> {{trans('main.habitacion')}}</label>
						<div>
							<select id="habitacion" name="habitacion"  class=" form-control selectpicker" data-size="10" data-live-search="true">
								<option value="">{{trans('main.seleccione una habitacion')}} </option>									
								@foreach($rooms as $ro)	
								    @if($ro->condition == 0 || $ro->id == $stay->room_id)
										@if($ro->id == $stay->room_id)
											<option selected="selected" value="{{$ro->id}}">{{$ro->number_room}}</option>										
										@else
											<option   value="{{$ro->id}}">{{$ro->number_room}}</option>										
										@endif

									@endif
								@endforeach
							</select>

						</div>
						<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('habitacion'); ?>																	
								</li>
							</ul>
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label">{{trans('main.entrada dia')}}</label>
						<div>
						<?php $opening_date = Helpers::date_bd($stay->opening_date); ?>
							{{Form::text('opening_date',$opening_date , ['class'=>'form-control']);}}							

							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('opening_date'); ?>																	
								</li>
							</ul> 
						</div>

					</div>
					<div class="form-group" style="display:none">
						<label class="control-label">{{trans('main.entrada hora')}}</label>
						<div>
						  <?php $start = Helpers::hora_min($stay->start); ?>

							{{Form::text('start',$start, ['class'=>'form-control']);}}							

							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('start'); ?>																	
								</li>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.salida dia')}}</label>
						<div>
						  <?php $closing_date = Helpers::date_bd($stay->closing_date); ?>
							{{Form::text('closing_date',$closing_date, ['class'=>'form-control', 'id'=>'salida_dia']);}}

							{{Form::hidden('id',null, ['class'=>'form-control']);}}	
							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('closing_date'); ?>																	
								</li>
							</ul>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.salida hora')}}</label>
						<div>
						 <?php $end = Helpers::hora_min($stay->end); ?>
							{{Form::text('end',$end, ['class'=>'form-control', 'id'=>'salida_hora']);}}
							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('end'); ?>																	
								</li>
							</ul>

						</div>
					</div>
					<div class="form-group" style="display: none">
						<label class="control-label">{{trans('main.telefono')}}</label>					
						<div class="input-group">
							 
							{{Form::text('phone',null, ['class'=>'form-control']);}}
							
							<span class="input-group-btn">
								<div class="iSwitch flat-switch">
									<div class="switch switch-small">
										<input type="checkbox" @if($hotel->inform_sms) checked @else @endif name="report_sms">

									</div>																												
								</div>
							</span>
						</div>
						<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('phone'); ?>																	
								</li>
							</ul>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.Idioma-preferente')}}</label>
						<div>
							<select id="idioma" name="idioma" class="form-control">								
								@foreach($langs as $lang)
									@if($lang->language_id==$lang_main->language_id)
										<option selected="selected" value="{{$lang->language_id}}">{{Language::find($lang->language_id)->language}} ({{trans('main.main')}} )</option>
									@else
										<option value="{{$lang->language_id}}">{{Language::find($lang->language_id)->language}}</option>										
									@endif										
								@endforeach
							</select>
						</div>
					</div>

					

					<div class="form-group offset">
						<div>
							<button type="submit" class="btn btn-theme">{{trans('main.btn-checkin')}}</button>
							<button type="reset" class="btn" >{{trans('main.limpiar')}}</button>
						</div>
					</div>
				</form>
			</div>
		</section>
		</div>

	</div>
	
</div>
@stop

@section('script')

<script type="text/javascript">
	$(function() {
		// Call dataTable in this page only
		//$('.nxa').addClass('nxa')
		$('.selectpicker').selectpicker();
		$('#entrada_dia').datetimepicker({
		    viewMode: 'years',
            format: 'DD/MM/YYYY',
            defaultDate:moment('{{$stay->opening_date}}') ,
            minDate:moment('{{ date("m-d-Y")}}'),       
		});
		$("#entrada_dia").on("dp.change", function (e) {
            $('#salida_dia').data("DateTimePicker").minDate(e.date);
        });
		$('#salida_dia').datetimepicker({
		    viewMode: 'days',
             format: 'DD-MM-YYYY',
            defaultDate:moment('{{$stay->closing_date}}')        
		});
		
		$('#entrada_hora').datetimepicker({		   	
            format: 'H:mm',
            defaultDate:moment('{{ date("m-d-Y")." ".$stay->start}}')
		});
		
		 
		$('#salida_hora').datetimepicker({		   	
             format: 'H:mm',
			defaultDate:moment('{{ date("m-d-Y")." ".$stay->end}}')
		});
		
	});
</script>
@stop