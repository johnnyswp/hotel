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
			<h3>Nombre promocion</h3>
			<div class="panel-body">
				<form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">
					
					<div class="form-group">
						<label class="control-label">Foto</label>
						<div class="col-lg-4">
							<img src="" width="100px">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">Precio</label>
						<div class="col-lg-4">
							<input type="text" id="price" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">Tiempo de entrega</label>
						<div class="col-lg-4">
							<label>45 min</label>
						</div>
					</div>

					<h3>Nombre items 1 en idioma seleccionado</h3>
					<div class="form-group">
						<div>
							<div class="row">
								<div class="col-sm-6">
									<ul class="iCheck"  data-color="red">
										<li>
											<input type="radio" name="name-radio">
											<label>Producto 1</label>
										</li>
										<li>
											<input  type="radio" name="name-radio" checked="checked">
											<label >Producto 2</label>
										</li>
									</ul>
								</div>
									
							</div><!-- //row-->
						</div>
					</div>

					<h3>Nombre items 2 en idioma seleccionado</h3>
					<div class="form-group">
						<div>
							<div class="row">
								<div class="col-sm-6">
									<ul class="iCheck"  data-color="red">
										<li>
											<input type="radio" name="name-radio">
											<label>Producto 1</label>
										</li>
										<li>
											<input  type="radio" name="name-radio" checked="checked">
											<label >Producto 2</label>
										</li>
									</ul>
								</div>
									
							</div><!-- //row-->
						</div>
					</div>

					<h3>Nombre items 3 en idioma seleccionado</h3>
					<div class="form-group">
						<div>
							<div class="row">
								<div class="col-sm-6">
									<ul class="iCheck"  data-color="red">
										<li>
											<input type="radio" name="name-radio">
											<label>Producto 1</label>
										</li>
										<li>
											<input  type="radio" name="name-radio" checked="checked">
											<label >Producto 2</label>
										</li>
									</ul>
								</div>
									
							</div><!-- //row-->
						</div>
					</div>

					<h3>Disponibilidad</h3>

					<table class="table table-bordered">
						<thead>
							<tr>
								<td>Dia</td>
								<td>Desde 1</td>
								<td>Hasta 1</td>
								<td>Desde 2</td>
								<td>Hasta 2</td>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>Lunes</td>
								<td><input type="text" id="desde1" class="form-control"></td>
								<td><input type="text" id="hasta1" class="form-control"></td>
								<td><input type="text" id="desde2" class="form-control"></td>
								<td><input type="text" id="hasta2" class="form-control"></td>
							</tr>
							<tr>
								<td>Martes</td>
								<td><input type="text" id="desde1" class="form-control"></td>
								<td><input type="text" id="hasta1" class="form-control"></td>
								<td><input type="text" id="desde2" class="form-control"></td>
								<td><input type="text" id="hasta2" class="form-control"></td>
							</tr>
							<tr>
								<td>Miercoles</td>
								<td><input type="text" id="desde1" class="form-control"></td>
								<td><input type="text" id="hasta1" class="form-control"></td>
								<td><input type="text" id="desde2" class="form-control"></td>
								<td><input type="text" id="hasta2" class="form-control"></td>
							</tr>
						</tbody>
					</table>

					<div class="form-group offset">
						<div>
							<button type="submit" class="btn btn-theme">Pedir</button>
							<button type="reset" class="btn" >Atras</button>
						</div>
					</div>

				</form>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop