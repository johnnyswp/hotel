
@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')
<div id="content">
            <div class="row">
                        
                <div class="col-lg-12">
                    <section class="panel corner-flip">
                            <header class="panel-heading sm" data-color="theme-inverse">
                                <div class="pull-letf"><h2><strong>Registro de lenguajes</strong>.</h2></div>
                            </header>
                            @if (Session::has('flash_message'))
                              <div class="form-group">
                                  <p>{{ Session::get('flash_message') }}</p>
                              </div>
                            @endif
                            @if (Session::has('error'))
                              <label class="label label-danger">{{ Session::get('error') }}</label>
                            @endif
                            <div class="panel-body">
                           {{ Form::model(Language::where('sufijo', 'es')->first(), array('action' => 'AdminLanguagesController@store','files'=>true))}}
                           <div class="form-group col-md-12">
                                <div class="col-md-12">
                                      <button type="submit"  class="btn btn-theme previous pull-left"> Guardar</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Sufijo</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("sufijo", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('sufijo', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Lenguaje</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("language", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('language', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <div class="iSwitch flat-switch">
                                <div class="switch">
                                    <input name="state" class="state" value="1" type="checkbox">
                                </div>
                            </div>
                            </div><!-- //form-group-->

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
                                            {{ Form::file("flag") }}
                                        </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
                                    </div>
                                </div>
                                <br>
        
                                <span class="label label-danger ">{{trans('main.note')}}</span>
                                <span>{{trans('main.you must select single files of')}}</span>
                                </div>
                                {{ errors_for('flag', $errors) }}
                            </div>

                            @foreach($txts as $txt)
                            <div class="form-group">
                                <label class="control-label">{{$txt}}</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text($txt, NULL, ['class' => 'form-control']) }}
                                            {{ errors_for($txt, $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            @endforeach

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