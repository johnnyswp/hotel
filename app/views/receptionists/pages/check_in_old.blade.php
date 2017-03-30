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
			<div class="panel-body" style="">
				<form method="post" action="{{url('receptionist/save/check-in')}}" class="form-horizontal col-md-6 col-md-offset-2" data-collabel="4" data-alignlabel="left"  data-label="color">
					<div class="form-group offset">
						<div>
							<button type="submit" class="btn btn-theme">{{trans('main.btn-checkin')}}</button>
							<a href="#" onclick="return window.history.back();" class="btn btn-theme" >{{trans('main.atras')}}</a>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						</div>
					</div>
					<div class="form-group">					
						<h3>{{trans('main.title_check_in_old')}}</h3>
					</div>		
					<div class="form-group">
						<label class="control-label">{{trans('main.nombre')}}</label>
						<div>
							{{Form::text('nombre',null, ['class'=>'form-control']);}}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.apellido')}}</label>
						<div>
							{{Form::text('apellido',null, ['class'=>'form-control']);}}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.email')}}</label>
						<div>
							<div class="input-group">
								{{Form::email('email',null, ['class'=>'form-control']);}}
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" style="height: 34px;"><i class="fa fa-search"></i></button>
								</span>
							</div>
							<div>
								<ul class="parsley-error-list">
									<li class="mincheck" style="display: list-item;">
										<?php echo $errors->first('email'); ?>																	
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.contrasena')}}</label>
						<div>
							<input type="text" id="contrasena" name="contrasena" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="habitacion"> {{trans('main.habitacion')}}</label>
						<div>
							<select id="habitacion" name="habitacion"  class="selectpicker form-control" data-size="10" data-live-search="true">
									<option value="">{{trans('main.busqueda automatica')}} </option>									
									<option value="1">Hab #1</option>
									<option value="2">Hab #2</option>
									<option value="3">Hab #3</option>
									<option value="4">Hab #4</option>
									<option value="5">Hab #5</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.entrada dia')}}</label>
						<div>
							<input type="text" name="entrada_dia" id="entrada_dia" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.entrada hora')}}</label>
						<div>
							<input type="text" name="entrada_hora" id="entrada_hora" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.salida dia')}}</label>
						<div>
							<input type="text" id="salida_dia" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.salida hora')}}</label>
						<div>
							<input type="text" name="salida_hora" id="salida_hora" class="form-control">
						</div>
					</div>
					

					<div class="form-group">
						<label class="control-label">{{trans('main.telefono')}}</label>
						<div>
							<input type="text" id="telefono" name="telefono" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.Idioma-preferente')}}</label>
						<div>
							<select id="idioma" name="idioma" class="form-control">
								<option value="">{{trans('main.elije un idioma')}}</option>
								<option value="es">Es</option>
								<option value="en">En</option>
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
		$('#salida_dia, #entrada_dia').datetimepicker({
		    viewMode: 'years',
            format: 'DD/MM/YYYY'
		});

		$('#salida_hora, #entrada_hora').datetimepicker({		   	
            format: 'H:m'
		});
	});
</script>
@stop