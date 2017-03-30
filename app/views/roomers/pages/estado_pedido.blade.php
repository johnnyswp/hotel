@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-12">
		<section class="panel">
			<div class="panel-body">
			
				<h3>Estado de pedidos</h3>

				<table class="table table-striped" id="table-example">
					<thead>
						<tr>
							<td>Num</td>
							<td>Fecha</td>
							<td>Hora</td>
							<td>Productos pedidos</td>
							<td>Total</td>
							<td>Estado</td>
							<td>Ver detalle</td>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>11/11/2015</td>
							<td>10:30 AM</td>
							<td>4</td>
							<td>$65.00</td>
							<td>En espera</td>
							<td></td>
						</tr>
					</tbody>
				</table>

				<div class="col-lg-6">
					<div class="form-group">
						<label class="control-label">Total comisiones</label>
						<div>
							<label class="control-label">$400.00</label>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="control-label">Suma de precios totales</label>
						<div>
							<label class="control-label">$400.00</label>
						</div>
					</div>
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
