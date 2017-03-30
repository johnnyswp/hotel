@extends('master')

@section('title', 'Home ')

@section('content')
	<div class="jumbotron" style="position: relative; z-index: 99999999999999999999999;">
    <br>
		 <br><h2>{{trans('main.Gracias por su Registro')}} <span></span> ...</h2><br>
        <p id="mgs">
        	@if(isset($flash_message))
                <label class="label label-success"></label>
                <p id="mgs">{{$flash_message}}.</p> 
                <br>
            @endif
            @if($errors->has())
			<div class="alert-box alert">
				<!--recorremos los errores en un loop y los mostramos-->
				@foreach ($errors->all('<p style="  background-color: rgb(216, 47, 47); color: white;">:message</p>') as $message)
				{{ $message }}
				@endforeach
			</div>
			@endif
		</p> 
        <br>
		@if (!Sentry::check())
		<p>
			<a href="{{url('/')}}" class="btn btn-success btn-lg" role="button" style="background-color: #750e2a;
    color: white;" >{{trans('main.login')}}</a> 
		</p>
		@endif
	</div>
@stop