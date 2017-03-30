@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')
<div id="content">
            <div class="row">
                        
                <div class="col-lg-12">
                    <section class="panel corner-flip">
                            <header class="panel-heading sm" data-color="theme-inverse">
                                <div class="pull-letf"><h2><strong>Registro de Planes</strong>.</h2></div>
                            </header>
                            @if (Session::has('flash_message'))
                              <div class="form-group">
                                  <p>{{ Session::get('flash_message') }}</p>
                              </div>
                            @endif
                            @foreach ($errors->all('<label class="label label-danger">:message</label>') as $message)
                            {{ $message }}
                            @endforeach
                            <div class="panel-body">
                           {{ Form::model($plan, ['method' => 'PATCH', 'route' => ['admin.planes.update', $plan->id]]) }}
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("name", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('name', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">codigo</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("code", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('code', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                           <div class="form-group">
                                <label class="control-label">Numero de Habitaciones</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::number("rooms", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('rooms', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Numero de Items</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::number("items", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('items', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Tiempo (Días que durara la membresia)</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::number("time", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('time', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Tiempo de prueba (Días que durara la prueba)</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::number("time_test", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('time_test', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Precio €</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("price", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('price', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <div>       
                                    <ul class="iCheck"  data-color="red">
                                        <li>
                                            <input type="checkbox"  value="1" name="state" parsley-mincheck="2" parsley-error-container="div#check-com-error" @if($plan->state==1) checked @endif>
                                        </li>
                                    </ul>
                                    <div id="check-com-error"></div>
                                </div>
                            </div>
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