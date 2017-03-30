@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel">
			<label>Detalle pedido</label><br>
			<div class="panel-body">	

			<div class="form-group">

				<div class="col-lg-4">
					<label class="control-label">Estado del pedido</label>
				</div>

				<div class="col-lg-4">
					<label class="control-label">Habitación</label>
					<label class="control-label">2</label>
				</div>

				<div class="col-lg-4">
					<label class="control-label">Fecha</label>
					<label class="control-label">Hora</label>
				</div>

				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Foto</td>
							<td>Producto</td>
							<td>Cantidad</td>
							<td>Precio</td>
							<td>Subtotal</td>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td><img src="" width="40px"></td>
							<td>Platillo principal</td>
							<td>2</td>
							<td>$20.00</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td><img src="" width="40px"></td>
							<td>Platillo principal</td>
							<td>2</td>
							<td>$20.00</td>
							<td>$40.00</td>
						</tr>

						<tr>
							<td><label class="control-label">Total</label></td>
							<td></td>
							<td></td>
							<td></td>
							<td><label class="control-label">$80.00</label></td>
						</tr>
					</tbody>
				</table>


				<div class="col-lg-6">
					<label class="control-label">Horario solicitado de entrega</label>
				</div>

				<div class="col-lg-6">
					<label class="control-label">Horario que se solicito</label>
				</div>
				
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
