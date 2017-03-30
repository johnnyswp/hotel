@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.alta de')}}</strong> {{trans('main.phones')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::open(array('action' => 'HotelPhonesController@store','files'=>true))}} 
					
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

					 <div class="form-group">
					    <label class="control-label">{{trans('main.phone')}}</label>
						<div>
						    <div class="col-md-3">
						    	{{ Form::text('prefix', $prefix, ['class' => 'form-control', 'disabled' => 'disabled']) }}
						    </div>
						    <div class="col-md-9">
						    	{{ Form::text('number', NULL, ['class' => 'form-control', 'placeholder'=>'88888888', 'autocomplete'=>'off', 'required'=>'required']) }}
                                {{ errors_for('number', $errors) }}
						    </div>
						</div>
					</div>

					<label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
					<?php $x=0; ?>
					@foreach($langs as $lang)
					    @if($lang->main==1)
					    <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}} ({{trans('main.lang')}})</label>
					    <div class="form-group">
					    	<div>
					    		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                {{ errors_for($lang->language->language, $errors) }}
					    	</div>
					    </div>
					    @else
                            @if($lang->state==0 and $x==0)
                            <label class="control-label">{{trans('main.Nombre en idiomas no activos')}} </label><br/>
                            <?php $x=1; ?>
                            @endif
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					        
					    @endif
					@endforeach

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