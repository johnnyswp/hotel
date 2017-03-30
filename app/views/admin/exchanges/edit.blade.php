
@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')
<div id="content">
            <div class="row">
                        
                <div class="col-lg-12">
                    <section class="panel corner-flip">
                            <header class="panel-heading sm" data-color="theme-inverse">
                                <div class="pull-letf"><h2><strong>Edicion de Divisas</strong>.</h2></div>
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
                           {{ Form::model($exchanges, ['method' => 'PATCH','files'=>true, 'route' => ['admin.exchanges.update', $exchanges->id]]) }}
                            <div class="form-group">
                                <label class="control-label">Simbolo</label>
                                <div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            {{ Form::text("symbol", NULL, ['class' => 'form-control']) }}
                                            {{ errors_for('symbol', $errors) }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- //form-group-->
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