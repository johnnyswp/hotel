@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.Editar')}}</strong> {{trans('main.room')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($room, ['files' => 'true', 'method' => 'PATCH', 'route' => ['hotel.rooms.update', $room->id]]) }}
					
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

					<label class="control-label">{{trans('main.Numero de Habitacion')}}</label>
					<div class="form-group">
						<div>
							{{ Form::text('number_room', NULL, ['class' => 'form-control','autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false']) }}
                            {{ errors_for('number_room', $errors) }}
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.sector')}}</label>
                        <div>
                            {{ Form::select('sector_id', $sectors, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                            {{ errors_for('sector_id', $errors) }}
                        </div>
                    </div>

                    <div class="form-group">
						<label class="control-label">{{trans('main.state')}}</label>
						<div>
							<div class="row">
								<div class="col-sm-4 iSwitch flat-switch">
									<div class="switch">
									    {{ Form::checkbox('state', 1) }}
									</div>
								</div><!-- //col-sm-4 -->
								{{ errors_for('state', $errors) }}

							</div><!-- //row -->
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