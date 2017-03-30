@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')
<div id="content">
            <div class="row">
                        
                <div class="col-lg-12">
                    <section class="panel corner-flip">
                            <header class="panel-heading sm" data-color="theme-inverse">
                                <div class="pull-letf"><h2><strong>Editar configuracion</strong>.</h2></div>
                            </header>
                            @if (Session::has('flash_message'))
                              <div class="form-group">
                                  <p>{{ Session::get('flash_message') }}</p>
                              </div>
                            @endif
                            <div class="panel-body">
                            {{ Form::model($option, ['method' => 'POST', 'url' => 'admin/configuration/'.$option->id.'/update']) }}
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("name", NULL, ['class' => 'form-control','disabled'=>"true"]) }}
                                            {{ errors_for('name', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            @if($option->code=="pay_ava_opt")
                            <div class="form-group">
                                <label class="control-label">Valor</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                        <select parsley-required="true"  name="value" id="value" class="selectpicker form-control" data-size="10" data-live-search="true">
                                        <option value="sandbox">sandbox</option>
                                        <option value="live">live</option>                                                                
                                        </select>
                                        {{ errors_for('value', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            @elseif($option->code=="policy" or $option->code=="term")
                            <div class="panel-tools fully color" align="right" data-toolscolor="#CCC">
                                <ul class="tooltip-area">
                                    <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                                    <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label"> Valor</label>
                                    <div>
                                        <textarea cols="80" id="editorCk" name="value" rows="10">{{$option->value}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label class="control-label">Valor</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("value", NULL, ['class' => ' form-control']) }}
                                            {{ errors_for('value', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            @endif
                            <div class="form-group col-md-12">
                                <div class="col-md-12">
                                      <button type="submit"  class="btn btn-theme previous pull-left"> Guardar</button>
                                </div>
                            </div>
                            <footer class="row">
                                <div class="col-sm-12">
                                    <section class="wizard">
                                    </section>
                                </div>
                            </footer>
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