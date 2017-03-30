@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel corner-flip">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.hotel data')}}</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($hotel, ['files' => 'true', 'method' => 'PATCH', 'action'=>'HotelController@anyUpdate']) }}
					<div class="form-group">
						<label class="control-label">{{trans('main.hotel name')}}</label>
						<div>
						    {{ Form::text('name', NULL, ['class' => 'form-control']) }}
						    {{ errors_for('name', $errors) }}
						</div>
					</div>

<!--					<div class="form-group">
						<label class="control-label">Estado</label>
						<div>
							<div class="row">
								<div class="col-sm-4 iSwitch flat-switch">
									<div class="switch">
									    {{ Form::checkbox('state', 1) }}
									</div>
								</div>
								{{ errors_for('state', $errors) }}

							</div>
						</div>
					</div> -->

					<div class="form-group">
                        <label class="control-label">{{trans('main.country')}}</label>
                        <div>
                            {{Form::select('country_id', $countries, NULL, ['id'=>'country','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off'])}}
                            {{errors_for('country_id', $errors)}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{trans('main.city')}}</label>
                        <div id="ccity">
                            {{ Form::text('city', NULL, ['class' => 'form-control', 'autocomplete'=>'off']) }}
                            {{ errors_for('city', $errors) }}
                        </div>
                    </div>

					<div class="form-group">
						<label class="control-label">{{trans('main.address')}}</label>
						<div>
						    {{ Form::text('address', NULL, ['class' => 'form-control', 'autocomplete'=>'off']) }}
						    {{ errors_for('address', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.email publico')}}</label>
						<div>
							{{ Form::text('infoemail', NULL, ['class' => 'form-control', 'autocomplete'=>'off']) }}
						    {{ errors_for('infoemail', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.web site')}}</label>
						<div>
							{{ Form::text('web', NULL, ['class' => 'form-control', 'autocomplete'=>'off']) }}
						    {{ errors_for('web', $errors) }}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.lang')}}</label>
						<div>
						    {{Form::select('language_id', $langs, $langmain->language_id, ['id'=>'lang','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off'])}}
                            {{errors_for('language_id', $errors)}}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.divisa de precios')}}</label>
						<div>
							{{Form::select('exchange_id', $exchanges, NULL, ['id'=>'exchange','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off'])}}
                            {{errors_for('exchange_id', $errors)}}
						</div>
					</div>

					<!--<div class="form-group">
						<label class="control-label">{{trans('main.lista de horarios segun')}}</label>
						<div>
							{{Form::select('list_times_as', array('0'=>trans('main.horario de entrega'), '1'=>trans('main.horario de solicitud')), NULL, ['id'=>'country','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'false', 'autocomplete'=>'off'])}}
                            {{errors_for('list_times_as', $errors)}}
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label">{{trans('main.tipo de login')}}</label>
						<div>
							{{Form::select('type_login', array('0'=>trans('main.con token'), '1'=>trans('main.con username')), NULL, ['id'=>'country','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'false', 'autocomplete'=>'off'])}}
                            {{errors_for('type_login', $errors)}}
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">{{trans('main.Seleccion de Plantilla')}}</label>
						<div>
							{{Form::select('theme', array('1'=>trans('main.tema 1'), '2'=>trans('main.tema 2'), '3'=>trans('main.tema 3')), NULL, ['id'=>'theme','class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'false', 'autocomplete'=>'off'])}}
                            {{errors_for('theme', $errors)}}
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.Hora limite')}}</label>
						<div>
						    {{ Form::text('limit_time', NULL, ['class' => 'form-control timepicker']) }}
						    {{ errors_for('limit_time', $errors) }}
						</div>
					</div>

					<!--<div class="form-group">
						<label class="control-label">{{trans('main.Informar check in por email')}}</label>
						<div>
							<div class="row">
								<div class="col-sm-4 iSwitch flat-switch">
									<div class="switch">
									    {{ Form::checkbox('inform_email', 1) }}
									</div>
								</div>
								{{ errors_for('inform_email', $errors) }}

							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{{trans('main.Informar check in por sms')}}</label>
						<div>
							<div class="row">
								<div class="col-sm-4 iSwitch flat-switch">
									<div class="switch">
									    {{ Form::checkbox('inform_sms', 1) }}
									</div>
								</div>
								{{ errors_for('inform_sms', $errors) }}

							</div> 
						</div>
					</div>-->

					<div class="form-group">
						<label class="control-label">{{trans('main.logo')}}</label><br>
						<div>
							<div class="fileinput fileinput-exists" data-provides="fileinput">
								<input type="hidden" value="" name="">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
									<img src="@if($hotel->logo) {{$hotel->logo}} @else http://www.ngondopages.cm/media/com_jbusinessdirectory/pictures/categories/Hotel-1429249035.png @endif" />
								</div>
							<div>
								<span class="btn btn-default btn-file">
									<span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
									<input type="file" name="logo">
								</span>
							<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
							</div>
						</div>
						<br>
						{{ errors_for('logo', $errors) }}
						<span class="label label-danger ">{{trans('main.note')}}</span>
						<span>{{trans('main.you must select single files of')}}</span>
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
$('.selectpicker').selectpicker();

$('.timepicker').timepicker({
    minuteStep: 1,
    template: 'modal',
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});
//////////////////Filtros de city, province///////////////////
function dependencia_ciudades()
{
    var code = $("#provinces").val();
    if(code){
        $.get("{{url('filter-citys')}}"+"?", { code: code }, function(resultado){
            if(resultado == false)
            {
              $('#city').val('');
              $('#city').prop('disabled',true);
              $('#city').selectpicker('refresh');
            }
            else
            {
                document.getElementById("city").options.length=1;
                $('#city').append(resultado);
                $('#city').val('');
                $('#city').prop('disabled',false);
                $('#city').selectpicker('refresh');
            }
        });
    }
}

function dependencia_provinces()
{
    var code = $("#country").val();
    if(code){
        $.get("{{url('filter-provinces')}}"+"?", { code: code }, function(resultado){
            if(resultado == false)
            {
                $('#provinces').val('');
                $('#city').val('');
                $('#provinces').prop('disabled',true);
                $('#city').prop('disabled',true);
                $('#provinces').selectpicker('refresh'); 
                $('#city').selectpicker('refresh'); 
            }
            else
            {
                document.getElementById("provinces").options.length=1;
                $('#provinces').append(resultado);
                $('#provinces').val('');
                $('#city').val('');
                $('#provinces').prop('disabled',false);
                $('#city').prop('disabled',true);
                $('#provinces').selectpicker('refresh');
                $('#city').selectpicker('refresh');     
            }
        }); 
    }
}

$('#country').on('change',function(){            
    var country_id = $(this).val();
    dependencia_provinces(country_id);
});

$('#provinces').on('change',function(){
    var province_id = $(this).val();
    dependencia_ciudades(province_id);
});
@stop