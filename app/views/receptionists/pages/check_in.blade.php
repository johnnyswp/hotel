@extends('receptionists.master') 
@section('title', trans('main.title_check_in'))
@section('content')
@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif
<style>
	bootstrap-timepicker {
  position: relative;
}
.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu {
  left: auto;
  right: 0;
}
.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:before {
  left: auto;
  right: 12px;
}
.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:after {
  left: auto;
  right: 13px;
}
.bootstrap-timepicker .input-group-addon {
  cursor: pointer;
}
.bootstrap-timepicker .input-group-addon i {
  display: inline-block;
  width: 16px;
  height: 16px;
}
.bootstrap-timepicker-widget.dropdown-menu {
  padding: 4px;
}
.bootstrap-timepicker-widget.dropdown-menu.open {
  display: inline-block;
}
.bootstrap-timepicker-widget.dropdown-menu:before {
  border-bottom: 7px solid rgba(0, 0, 0, 0.2);
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  content: "";
  display: inline-block;
  position: absolute;
}
.bootstrap-timepicker-widget.dropdown-menu:after {
  border-bottom: 6px solid #FFFFFF;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  content: "";
  display: inline-block;
  position: absolute;
}
.bootstrap-timepicker-widget.timepicker-orient-left:before {
  left: 6px;
}
.bootstrap-timepicker-widget.timepicker-orient-left:after {
  left: 7px;
}
.bootstrap-timepicker-widget.timepicker-orient-right:before {
  right: 6px;
}
.bootstrap-timepicker-widget.timepicker-orient-right:after {
  right: 7px;
}
.bootstrap-timepicker-widget.timepicker-orient-top:before {
  top: -7px;
}
.bootstrap-timepicker-widget.timepicker-orient-top:after {
  top: -6px;
}
.bootstrap-timepicker-widget.timepicker-orient-bottom:before {
  bottom: -7px;
  border-bottom: 0;
  border-top: 7px solid #999;
}
.bootstrap-timepicker-widget.timepicker-orient-bottom:after {
  bottom: -6px;
  border-bottom: 0;
  border-top: 6px solid #ffffff;
}
.bootstrap-timepicker-widget a.btn,
.bootstrap-timepicker-widget input {
  border-radius: 4px;
}
.bootstrap-timepicker-widget table {
  width: 100%;
  margin: 0;
}
.bootstrap-timepicker-widget table td {
  text-align: center;
  height: 30px;
  margin: 0;
  padding: 2px;
}
.bootstrap-timepicker-widget table td:not(.separator) {
  min-width: 30px;
}
.bootstrap-timepicker-widget table td span {
  width: 100%;
}
.bootstrap-timepicker-widget table td a {
  border: 1px transparent solid;
  width: 100%;
  display: inline-block;
  margin: 0;
  padding: 8px 0;
  outline: 0;
  color: #333;
}
.bootstrap-timepicker-widget table td a:hover {
  text-decoration: none;
  background-color: #eee;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  border-color: #ddd;
}
.bootstrap-timepicker-widget table td a i {
  margin-top: 2px;
  font-size: 18px;
}
.bootstrap-timepicker-widget table td input {
  width: 25px;
  margin: 0;
  text-align: center;
}
.bootstrap-timepicker-widget .modal-content {
  padding: 4px;
}
@media (min-width: 767px) {
  .bootstrap-timepicker-widget.modal {
    width: 200px;
    margin-left: -100px;
  }
}
@media (max-width: 767px) {
  .bootstrap-timepicker {
    width: 100%;
  }
  .bootstrap-timepicker .dropdown-menu {
    width: 100%;
  }
}
</style>
<div id="check_in">	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel" style="" >
			<div class="panel-header">
				<h2 class="pull-right">{{$hotel->getName()}}</h2>
			</div>
			<div class="panel-body" style="">
				@if (Session::has('message'))
                <label class="color" style="    color: #D81717; background-color: rgba(255, 204, 51, 0.63); width: 100%; font-size: 14px; text-align: center; font-weight: 700;">{{ Session::get('message') }}</label>
                @endif
				<form method="post" action="{{url('save/check-in')}}" class="col-md-6 col-md-offset-2" >
					<div class="form-group offset">
						<div>
							<button type="submit" class="btn btn-theme">{{trans('main.btn-checkin')}}</button>
							<a href="#" onclick="return window.history.back();" class="btn btn-theme" >{{trans('main.atras')}}</a>							
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						</div>
					</div>
					<div class="form-group">					
						<h3>{{trans('main.title_check_in')}}</h3>
					</div>		
					<div class="form-group">
						<label class="control-label">{{trans('main.nombre completo')}}</label>
						<div>
							{{Form::text('nombre',null, ['class'=>'form-control',"autocomplete"=>"off", "oncopy"=>"return false", "ondrag"=>"return false", "ondrop"=>"return false", "onpaste"=>"return false"]);}}
							<input type="hidden" value="{{$hotel->id}}" name="hotel_id" >
						</div>
							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('nombre'); ?>																	
								</li>
							</ul>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>					
						<div class="">
							{{Form::text('email',null, [ 'class'=>'form-control',"autocomplete"=>"off", "oncopy"=>"return false", "ondrag"=>"return false", "ondrop"=>"return false", "onpaste"=>"return false"]);}}
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
					<div class="form-group" style="display: none">
						<label class="control-label">{{trans('main.telefono')}}</label>					
						<div class="input-group">
							{{Form::text('telefono',null, ['style'=>'width: 95%', 'class'=>'form-control',"autocomplete"=>"off", "oncopy"=>"return false", "ondrag"=>"return false", "ondrop"=>"return false", "onpaste"=>"return false"]);}}
							
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
									<?php echo $errors->first('telefono'); ?>																	
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
						<div class="input-group">
							{{Form::text('contrasena',Helpers::token($hotel->id,5), ['style'=>'width: 95%', 'class'=>'form-control',"autocomplete"=>"off", "oncopy"=>"return false", "ondrag"=>"return false", "ondrop"=>"return false", "onpaste"=>"return false"]);}}
						</div>
						<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('contrasena'); ?>																	
								</li>
							</ul>
					</div>			
				 
					<div class="form-group" style="display: none">
						<div class="col-md-6">
							<label class="control-label">{{trans('main.entrada dia')}}</label>
							<div>
								{{Form::text('entrada_dia',null, ['id'=>'entrada_dia','style'=>'width: 60%','class'=>'form-control']);}}
								<ul class="parsley-error-list">
									<li class="mincheck" style="display: list-item;">
										<?php echo $errors->first('entrada_dia'); ?>																	
									</li>
								</ul> 
							</div>
						</div>
						<div class="col-md-6" style="display: none">
							<label class="control-label">{{trans('main.entrada hora')}}</label>
							<div>
								{{Form::text('entrada_hora',null, ['id'=>'entrada_hora','style'=>'width: 60%','class'=>'form-control']);}}

								<ul class="parsley-error-list">
									<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('entrada_hora'); ?>		
									</li>
								</ul>
							</div>
						</div>
					</div>
					 
					<div class="form-group">
						<div class="col-md-6">
							<label class="control-label">{{trans('main.salida dia')}}</label>
							<div>
								{{Form::text('salida_dia',null, ['id'=>'salida_dia','style'=>'width: 60%','class'=>'form-control']);}}

								<ul class="parsley-error-list">
									<li class="mincheck" style="display: list-item;">
										<?php echo $errors->first('salida_dia'); ?>																	
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<label class="control-label">{{trans('main.salida hora')}}</label>
							<div>
								{{Form::text('salida_hora',$hotel->limit_time, ['id'=>'salida_hora','style'=>'width: 60%','class'=>'form-control']);}}
								<ul class="parsley-error-list">
									<li class="mincheck" style="display: list-item;">
										<?php echo $errors->first('salida_hora'); ?>																	
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="habitacion"> {{trans('main.habitacion')}}</label>
						<div>
							<select id="habitacion" name="habitacion"  class=" form-control selectpicker" data-size="10" data-live-search="true">
								<option value="">{{trans('main.seleccione una habitacion')}} </option>									
								@foreach($rooms as $ro)									
									<option value="{{$ro->id}}">{{$ro->number_room}}</option>										
								@endforeach
							</select>

						</div>
							<ul class="parsley-error-list">
								<li class="mincheck" style="display: list-item;">
									<?php echo $errors->first('habitacion'); ?>																	
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
		$('.type_login').on('change', function(){
			if($(this).val()==1)
			{
                $('.username').css('display', 'block');
			}else{
				$('.username').css('display', 'none');
			}
		});
		// Call dataTable in this page only
		//$('.nxa').addClass('nxa')
		$('#entrada_dia').datetimepicker({
            format: 'DD-MM-YYYY',
            minDate: moment().format(),       

		});
		$("#entrada_dia").on("dp.change", function (e) {
            $('#salida_dia').data("DateTimePicker").minDate(e.date);            
        });

        $('.selectpicker').selectpicker();
        
		$('#salida_dia').datetimepicker({
            format: 'DD-MM-YYYY',
             minDate: moment().add(1, 'day').format(),
		});
		
		$('#entrada_hora').datetimepicker({		   	
            format: 'H:mm',
            defaultDate:moment()
		});

		$("#entrada_hora").on("dp.change", function (e) {
            $('#salida_hora').data("DateTimePicker").minDate(e.date);
        });

		$('#salida_hora').datetimepicker({		   	
            format: 'H:mm',
            defaultDate:moment(),
		});
		
			/*$('#salida_hora').timepicker({
			    minuteStep: 1,
			    appendWidgetTo: 'body',
			    showSeconds: false,
			    showMeridian: false,
			    defaultTime: false
			});*/
	});
</script>
@stop