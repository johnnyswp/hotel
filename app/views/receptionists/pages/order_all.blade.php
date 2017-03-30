@extends('receptionists.master') 
@section('title', trans('main.orders'))
<?php
use Carbon\Carbon;
?>
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-md-12">
			 <section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.search pedidos')}}</strong></h2>
			</header>
			<div class="panel-body">			  
				<table class="table" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.huesped')}}</td>
							<td>{{trans('main.room')}}</td>
							<td>{{trans('main.hora de entrega')}}</td>
                            <td>{{trans('main.state')}}</td>
                            <td>{{trans('main.total')}}</td>
                            <td>{{trans('main.action')}}</td>
						</tr>
					</thead>
				</table>
			</div>
		</section>
		</div>
	</div>
</div>


@stop

 

@section('script')
<script type="text/javascript">
	$(function() {
		$('#sector_table').dataTable({
			"processing": true,
            "serverSide": true,
            "ajax": "{{url('receptionist/data-table-order')}}"
		});
		
	});
</script>
@stop