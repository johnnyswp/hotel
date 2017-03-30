@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
		<section class="panel">
			<h3></h3>
			<div class="panel-body">
				<h2>Hotel 1</h2>
				<h3>Calle Principal, Madrid</h3>
				<h3>77889933</h3>
				<br>

				<h3>Bienvenido Juan Perez</h3>

				<label>Favor ingrese su contraseña para ingresar al mení de servicio de habitaciones</label>
				<div class="form-group">
					<label class="control-label">Contraseña</label>
					<div>
						<input type="password" id="pass" class="form-control">
					</div>
				</div>

				<div class="form-group offset">
					<div>
						<button type="submit" class="btn btn-theme">Ingresar</button>
					</div>
				</div>

				<div class="col-lg-4 col-lg-offset-4">
					<select class="form-control">
						<option>Español</option>
						<option>Ingles</option>
					</select>
				</div>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop

@section('script')
<script type="text/javascript" src="{{url()}}/assets/plugins/datable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/datable/dataTables.bootstrap.js"></script>


<script type="text/javascript">
	$(function() {
		


		// Call dataTable in this page only
		$('#table-example').dataTable();
	});
</script>
@stop