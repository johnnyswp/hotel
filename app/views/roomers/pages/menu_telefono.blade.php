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
			<div class="col-lg-4">
				<a href="#"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a>
				<label>Producto 1</label>
			</div>
			<div class="col-lg-4 col-lg-offset-4">
				<select class="form-control">
					<option>Español</option>
					<option>Ingles</option>
				</select>
			</div>
			<label>Hotel 1</label><br>
			<label>Calle principal</label>
			<div class="panel-body">
			
				<h3>Telefonos</h3>

				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Num</td>
							<td>Nombre</td>
							<td>Telefono</td>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>Juan Perez</td>
							<td>7766-3345</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Juan Perez</td>
							<td>7766-3345</td>
						</tr>
					</tbody>
				</table>
				
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
