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
			<h3>Estadias Activas</h3>
			<div class="panel-body">
				<form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">
					
					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Nombre</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="name">
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Habitacion</label>
							<div class="col-lg-4">
								<input class="form-control" id="number" type="text">
							</div>
						</div>
					</div>

					

					<table class="table table-bordered">
						<thead>
							<tr>
								<td>Habitacion</td>
								<td>Huesped</td>
								<td>Check In</td>
								<td>Check Out programado</td>
								<td>Estado</td>
								<td>N° de pedidos realizado</td>
								<td>Valor consumido</td>
								<td>Ver pedidos</td>
								<td>Editar</td>
								<td>Check Out</td>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>243</td>
								<td>Miguel perez</td>
								<td>10:00 AM</td>
								<td>10:30 AM</td>
								<td>
									<div>
										<div class="row">
											<div class="col-sm-4 iSwitch flat-switch">
												<div class="switch">
													<input type="checkbox">
												</div>
											</div><!-- //col-sm-4 -->

										</div><!-- //row -->
									</div>
								</td>
								<td>12</td>
								<td>$300.00</td>
								<td>
									<button type="submit" class="btn btn-theme">Ver pedidos</button>
								</td>
								<td>
					  				<a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					  			</td>
					  			<td></td>
							</tr>



						</tbody>
					</table>

				</form>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop