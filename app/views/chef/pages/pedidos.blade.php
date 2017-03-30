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
			
			<div class="panel-body">
				
				<form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">

					<div class="col-lg-8">
						<h3>Pedidos programados: 10</h3><br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Habitación</td>
									<td>Cantidad de items</td>
									<td>Horario de entrega objetivo</td>
									<td>Horario inicio preparacion</td>
									<td>Estado</td>
									<td>Pasar a preparar</td>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Preparar</button></td>
								</tr>

								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Preparar</button></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-lg-4">
						<h3>Detalle pedido</h3><br>

						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Habitacion</td>
									<td>N° de habitacion</td>
									<td>Estado</td>
									<td>Estado del pedido</td>
								</tr>
							</thead>
						</table>
					</div>
					
					<div>
						<div class="col-lg-8">
						<h3>Pedidos a preparar: 10</h3><br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Habitación</td>
									<td>Cantidad de items</td>
									<td>Horario de entrega objetivo</td>
									<td>Horario inicio preparacion</td>
									<td>Estado</td>
									<td>Pasar a preparar</td>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Preparacion</button></td>
								</tr>

								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Preparacion</button></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-lg-4">
						<h3></h3><br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Foto</td>
									<td>Producto</td>
									<td>Cantidad</td>
									<td>Precio</td>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td><img src="" width="50px"></td>
									<td>Producto 1</td>
									<td>5</td>
									<td>$400.00</td>
								</tr>
							</tbody>
						</table>
					</div>
					</div>
					

					<div class="col-lg-8">
						<h3>Pedidos en preparacion: 10</h3><br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Habitación</td>
									<td>Cantidad de items</td>
									<td>Horario de entrega objetivo</td>
									<td>Horario inicio preparacion</td>
									<td>Estado</td>
									<td>Pasar a preparacion</td>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Entregado</button></td>
								</tr>

								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
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
									<td><button type="submit" class="btn btn-theme">Entregado</button></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-lg-8">
						<h3>Pedidos entregados: 10</h3><br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Habitación</td>
									<td>Cantidad de items</td>
									<td>Horario de entrega objetivo</td>
									<td>Horario inicio preparacion</td>
									<td>Ocultar</td>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
									<td><button type="submit" class="btn btn-theme">Preparar</button></td>
								</tr>

								<tr>
									<td>243</td>
									<td>4</td>
									<td>Horario 1</td>
									<td>45 min</td>
									<td><button type="submit" class="btn btn-theme">Preparar</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop