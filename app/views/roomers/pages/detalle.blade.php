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
				<label>Platillo principal</label><br>
				<img src="" width="100px">
				<div class="form-group">
					<label class="control-label">Cantidad</label>
					<div>
						<input type="number" min="1" value="1" class="form-control">
					</div>
				</div>

				<div class="form-group offset">
					<div>
						<button type="submit" class="btn btn-theme">Pedir</button>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Tiempo de entrega</label>
					<div>
						<label>10 min</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Descripcion</label>
					<div>
						<textarea id="descripcion" class="form-control"></textarea>
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