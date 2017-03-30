@extends('receptionists.master') 
@section('title', trans('main.title_check_in'))
@section('content')
@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif
<div id="check_in">	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel" style="" >
			<div class="panel-header">
				<h2 class="pull-right">Hotel: {{$hotel->getName()}}</h2>
			</div>
			<div class="panel-body" style="">
				
				@if (Session::has('message'))
				   <div class="alert alert-info">{{ Session::get('message') }}</div>
				@endif
			</div>
		</section>
		</div>

	</div>
	
</div>
@stop

@section('script')

<script type="text/javascript">
	$(function() {
		// Call dataTable in this page only
		//$('.nxa').addClass('nxa')
		$('#entrada_dia').datetimepicker({
		    viewMode: 'years',
            format: 'DD/MM/YYYY',
            defaultDate:moment('{{ date("m-d-Y")}}') ,
            minDate:moment('{{ date("m-d-Y")}}'),       
		});
		$("#entrada_dia").on("dp.change", function (e) {
            $('#salida_dia').data("DateTimePicker").minDate(e.date);
        });
		$('#salida_dia').datetimepicker({
		    viewMode: 'years',
            format: 'DD/MM/YYYY',
            defaultDate:moment('{{ date("m-d-Y")}}')        
		});
		
		$('#entrada_hora').datetimepicker({		   	
            format: 'H:mm',
            defaultDate:moment()
		});
		//console.log(moment('{{ date("m-d-Y")." ".$hotel->limit_time}}'));
		$('#salida_hora').datetimepicker({		   	
             format: 'H:mm',
			defaultDate:moment('{{ date("m-d-Y")." ".$hotel->limit_time}}')
		});
	});
</script>
@stop