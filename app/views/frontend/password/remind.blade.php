@extends('master')

@section('title', trans('main.reset password'))

@section('content')


		<div class="container" style="margin-top: 100px;">
	        <div class="row">
            <style type="text/css">
                #language {
                display: block;
                height: 38px;
                width: 125px;
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 999;
            }
            </style>
            <div id="language">         
                {{ Form::open(array('url' =>'/lang', 'class' => 'filters', 'method' => 'GET')) }}
                    {{ Form::select('lang',Language::where('state',1)->lists('language', 'sufijo'), Helpers::lang(), array('class' =>             'selectpicker form-control select change-lang')) }}
                {{ Form::close() }}
            </div>
			<div class="col-md-6 col-md-offset-2">
	    		<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">{{trans('main.password reminder')}}</h3>
				 	</div>
				  	<div class="panel-body">
				    	{{ Form::open(['action' => 'RemindersController@postRemind']) }}
	                    <fieldset>

	                    	@if (Session::has('flash_message'))
								<p style="padding:5px" class="bg-success text-success">{{ Session::get('flash_message') }}</p>
							@endif

							@if (Session::has('error_message'))
								<p style="padding:5px" class="bg-danger text-danger">{{ Session::get('error_message') }}</p>
							@endif

				    	  	<!-- Email field -->
							<div class="form-group">
								{{ Form::text('email', null, ['placeholder' => trans('main.email'), 'class' => 'form-control', 'required' => 'required'])}}
								{{ errors_for('email', $errors) }}
							</div>

				    		<!-- Submit field -->
							<div class="form-group">
								{{ Form::submit(trans('main.send reminder'), ['class' => 'btn btn btn-lg btn-primary btn-block', 'style'=>'background-color: #750e2a; color: white;']) }}
							</div>
				    	</fieldset>
				      	{{ Form::close() }}
				    </div>
				</div>

			</div>
		</div>
	</div>



@stop




