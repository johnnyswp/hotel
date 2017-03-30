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
			<img src="" width="75px">
			<label>Hotel 1</label><br>
			<div class="panel-body">
			<label>Carrito de compras</label>	

			<div class="form-group">
				<label class="control-label">Habitación</label>
				
				<label class="control-label">2</label>

				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Foto</td>
							<td>Producto</td>
							<td>Cantidad</td>
							<td>Precio</td>
							<td></td>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td><img src="" width="40px"></td>
							<td>Platillo principal</td>
							<td>2</td>
							<td>$20.00</td>
							<td><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
						</tr>
						<tr>
							<td><img src="" width="40px"></td>
							<td>Platillo principal</td>
							<td>2</td>
							<td>$20.00</td>
							<td><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
						</tr>
					</tbody>
				</table>

				<div class="form-group offset">
					<div>
						<button type="submit" class="btn btn-theme">Seguir comprando</button>
					</div>
				</div>

				<label class="control-label">Horario de entrega</label>

				<div class="form-group">
					<div>
						<div class="row">
							<div class="col-sm-6">
								<ul class="iCheck"  data-color="red">
									<li>
										<input type="radio" name="name-radio">
										<label>Entrega Inmediata</label>
										<label>10:00AM</label>
									</li>
									<li>
										<input  type="radio" name="name-radio" checked="checked">
										<label >Entrega Programada</label>
									</li>
								</ul>
							</div>
								
						</div><!-- //row-->
					</div>
				</div><!-- //form-group-->

				<div class="form-group offset">
					<div>
						<button type="submit" class="btn btn-theme">Enviar Pedido</button>
						<button type="reset" class="btn" >Cancelar</button>
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
