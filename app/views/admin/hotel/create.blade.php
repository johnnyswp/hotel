
<?php use Carbon\Carbon; ?>
@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')
<div id="content">
            <div class="row">
                        
                <div class="col-lg-12">
                    <section class="panel corner-flip">
                            <header class="panel-heading sm" data-color="theme-inverse">
                                <div class="pull-letf"><h2><strong>Registro de Hotel</strong>.</h2></div>
                            </header>
                            @if (Session::has('flash_message'))
                              <div class="form-group  col-md-12">
                                  <p>{{ Session::get('flash_message') }}</p>
                              </div>
                            @endif
                            <div class="panel-body">
                            {{Form::open(array('action' => 'AdminHotelController@store', 'files' => 'true'))}}
                                <div class="form-group col-md-12">
                                    <div class="col-md-12">
                                          <button type="submit"  class="btn btn-theme previous pull-left"> Guardar</button>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <header class="panel-heading sm" data-color="theme-inverse">
                                        <div class="pull-letf"><h2>Datos de Plan.</h2></div>
                                    </header>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label class="control-label">Nombre del plan</label>
                                         {{ Form::select('plan_id', $plans, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                                        {{ errors_for('plan_id', $errors) }}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Fecha en que terminara</label>
                                        {{ Form::text('cad', NULL, ['class' => 'form-control','placeholder'=>'Fin del plan','id'=>'datetimepicker1']) }}
                                        {{ errors_for('cad', $errors) }}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Pago</label>
                                        {{ Form::text('price', NULL, ['class' => 'form-control','placeholder'=>'Precio']) }}
                                        {{ errors_for('price', $errors) }}
                                    </div>
                                </div>
                                <!--  <div class="tab-pane fade" id="step1"> -->
                                 <div class="form-group col-md-12">
                                    <header class="panel-heading sm" data-color="theme-inverse">
                                        <div class="pull-letf"><h2>Datos Personales.</h2></div>
                                    </header>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Full Name</label>
                                        {{ Form::text('first_name', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('first_name', $errors) }}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Last Name</label>
                                        {{ Form::text('last_name', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('last_name', $errors) }}
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Posición</label>
                                    <div>
                                        {{ Form::text('position', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('position', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">Username</label>
                                    <div>
                                        {{ Form::text('username', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('username', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">Email</label>
                                    <div>
                                        {{ Form::text('email', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('email', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">Fecha de nacimiento</label>
                                    <div>
                                        {{ Form::text('birthday', NULL, ['class' => 'form-control', 'id'=>'birthday']) }}
                                        {{ errors_for('birthday', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">{{trans('main.country')}}</label>
                                    <div>
                                        {{ Form::select('country_id', $countries, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                                        {{ errors_for('country_id', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">Telefono</label>
                                    <div>
                                        {{ Form::text('phone', NULL, ['class' => 'form-control']) }}
                                        {{ errors_for('phone', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">{{trans('main.password')}}</label>
                                    <div>
                                    {{ Form::text("password", NULL, ['class' => 'form-control', 'placeholder'=>'6-8 '.trans('main.Characters'),'parsley-rangelength'=>'[6,8]', 'parsley-trigger'=>'keyup',  'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    {{ errors_for('password', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">{{trans('main.password confirmation')}}</label>
                                    <div>
                                    {{ Form::text("password_confirmation", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.password confirmation'),'parsley-rangelength'=>'[6,8]', 'parsley-trigger'=>'keyup',  'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    </div>
                                </div>
            
                                <!-- Datos de la clinica-->
                                <div class="form-group col-md-12">
                                    <header class="panel-heading sm" data-color="theme-inverse">
                                        <div class="pull-letf"><h2>Hotel Datos.</h2></div>
                                    </header>
                                </div>

                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.hotel name')}}</label>
                                    {{ Form::text("hotel_name", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.hotel name'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    {{ errors_for('hotel_name', $errors) }}
                                </div>

                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.country')}}</label>
                                    <select   id="country" class="selectpicker form-control" data-size="10" data-live-search="true" autocomplete="off">
                                        <option value="">{{trans('main.live search')}} {{trans('main.country')}} </option>
                                        <?php  
                                        Country::chunk(50, function($countries)
                                        {
                                            foreach($countries as $country)
                                            {
                                                echo "<option value=".$country->id.">".$country->name."</option>";
                                            }
                                        });
                                        ?>                                                              
                                    </select>
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.province')}}</label>
                                    <div id="pprovince">
                                        <select id="provinces" class="selectpicker form-control" data-size="10" data-live-search="true" autocomplete="off">
                                            <option value="">{{trans('main.live search')}} {{trans('main.province')}}</option>
                                        </select>                      
                                    </div>
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.city')}}</label>
                                    <div id="ccity">
                                        <select  name="city"  id="city" class="selectpicker form-control" data-size="10" data-live-search="true" autocomplete="off">
                                            <option value="">{{trans('main.live search')}} {{trans('main.city')}}</option>
                                        </select>
                                        {{ errors_for('city', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.address')}}</label>
                                    {{ Form::text("address_hotel", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.address'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    {{ errors_for('address_hotel', $errors) }}
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.web site')}}</label>
                                    {{ Form::text("web", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.web site'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    {{ errors_for('web', $errors) }}
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">{{trans('main.lang')}}</label>
                                    {{ Form::select('lang', $langs, NULL, ['class' => 'selectpicker form-control'])}}
                                    {{ errors_for('lang', $errors) }}
                                </div>
                                
                                <div class="form-group  col-md-12">
                                    <label class="control-label">Divisa precios</label>
                                    <div>
                                        {{ Form::select('exchange_id', $divisas, NULL, ['class' => 'selectpicker form-control'])}}
                                        {{ errors_for('exchange_id', $errors) }}
                                    </div>
                                </div>
            
                                <div class="form-group  col-md-12">
                                    <label class="control-label">Hora limite</label>
                                    <div>
                                        <input type="text" name="hours" class="form-control timepicker" placeholder="00:00:00">
                                    </div>
                                </div>
            
                                <div class="form-group col-md-12">
                                    <label class="control-label">{{trans('main.logo')}}</label><br>
                                    <div>
                                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                                            <input type="hidden" value="" name="">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                <img src="{{url('/assets/img/no-image.png')}}" />
                                            </div>
                                        <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
                                                <input type="file" name="logo" accept="image/*">
                                            </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
                                        </div>
                                    </div>
                                    <br>
            
                                    <span class="label label-danger ">{{trans('main.note')}}</span>
                                    <span>{{trans('main.you must select single files of')}}</span>
                                    </div>
                                    {{ errors_for('logo', $errors) }}
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-md-12">
                                          <button type="submit"  class="btn btn-theme previous pull-left"> Guardar</button>
                                    </div>
                                </div>

                            {{ Form::close() }}
                            </div>         
                            <!-- //content > row > col-lg-8 -->
                      </section>
                      <!-- //tabbable -->
                  </div>
                  <!-- //main-->
              </div>
              <!-- //main-->
          </div>
          <!-- //main-->
@stop

@section('js-script')
    var now = moment();
    $('.selectpicker').selectpicker();
    $('#birthday').datetimepicker({
        defaultDate:false,
        viewMode: 'years',
        format: 'YYYY/MM/DD'
    });
    
    $('#datetimepicker2').datetimepicker({
        defaultDate:false,
        viewMode: 'years',
        format: 'YYYY/MM/DD'
    });

    $('#datetimepicker1').datetimepicker({
        defaultDate:false,
        viewMode: 'years',
        format: 'YYYY/MM/DD'
    });
    
    $('#datetimepicker3').datetimepicker({
        defaultDate:false,
        viewMode: 'years',
        format: 'YYYY/MM/DD',
        minDate: {{Carbon::now()->addDay()->format('Y/m/d')}}
    });

    function dependencia_ciudades()
    {
        var code = $("#provinces").val();

        if(code){
            $.get("{{url('filter-citys')}}"+"?", { code: code }, function(resultado){
                if(resultado == false)
                {
                  $('#city').selectpicker('deselectAll');
                  $('#city').prop('disabled',true); 
                }
                else
                {
                    document.getElementById("city").options.length=1;
                    $('#city').append(resultado);
                    $('#city').selectpicker('deselectAll');
                    $('#city').prop('disabled',false);
                    $('#city').selectpicker('refresh');
                }
            });
        }

        $('#city').selectpicker('refresh');
    }

    function dependencia_provinces()
    {
        var code = $("#country").val();
        
        if(code){
            $.get("{{url('filter-provinces')}}"+"?", { code: code }, function(resultado){
                if(resultado == false)
                {
                  $('#provinces').selectpicker('deselectAll');
                  $('#city').selectpicker('deselectAll');
                  $('#provinces').prop('disabled',true);
                  $('#city').prop('disabled',true);
                  $('#provinces').selectpicker('refresh');  
                }
                else
                {
                    document.getElementById("provinces").options.length=1;
                    $('#provinces').append(resultado);
                    $('#provinces').selectpicker('deselectAll');
                    $('#city').selectpicker('deselectAll');
                    $('#provinces').prop('disabled',false);
                    $('#provinces').selectpicker('refresh');     
                }
            }); 
        }

        $('#provinces').selectpicker('refresh');
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