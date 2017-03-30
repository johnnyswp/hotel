@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-12 ">
		<section class="panel">
			<h3>Detalle de pedido</h3>
			<div class="panel-body">
				<form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">
					
					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Nombre</label>
							<div class="col-lg-4">
								<label>Miguel Perez</label>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Habitacion</label>
							<div class="col-lg-4">
								<label>1</label>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Horario Pedido</label>
							<div class="col-lg-4">
								<label>7:00 AM</label>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Horario Objetivo</label>
							<div class="col-lg-4">
								<label>7:40 AM</label>
							</div>
						</div>
					</div>

					<table class="table table-bordered">
						<thead>
							<tr>
								<td>Foto</td>
								<td>Producto</td>
								<td>Cantidad</td>
								<td>Precio</td>
								<td>Subtotal</td>
								<td></td>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<img src="" width="50px">
								</td>
								<td>Producto 1</td>
								<td>10</td>
								<td>$25.00</td>
								<td>$250.00</td>
								<td>
					  				<a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					  			</td>
							</tr>

							<tr>
								<td>
									<img src="" width="50px">
								</td>
								<td>Producto 2</td>
								<td>10</td>
								<td>$25.00</td>
								<td>$250.00</td>
								<td>
					  				<a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					  			</td>
							</tr>

							<tr>
								<td>
									<img src="" width="50px">
								</td>
								<td>Producto 3</td>
								<td>10</td>
								<td>$25.00</td>
								<td>$250.00</td>
								<td>
					  				<a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					  			</td>
							</tr>

							<tr>
								<td>SUMA</td>
								<td></td>
								<td>30</td>
								<td></td>
								<td>$750.00</td>
							</tr>

						</tbody>
					</table>

					<button type="submit" class="btn btn-theme">Agregar producto</button>

					<div class="form-group offset">
						<div>
							<button type="submit" class="btn btn-theme">Aceptar</button>
							<button type="reset" class="btn" >Cancelar</button>
						</div>
					</div>

				</form>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop