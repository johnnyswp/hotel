@extends('admin.master')
@section('title', 'Hotel Dashboard')
<?php use Carbon\Carbon; ?>
@section('content')
<div id="content">
	<div class="row">

		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>Divisas DE  Easy Rooms Services</strong>.</h2></div>
				</header>
				<a href="{{url('/admin/exchanges/create')}}" class="plan-add btn btn-primary" style='margin-top: 10px; margin-left: 10px;'>
					<i class="fa fa-pencil-square-o"></i> Nuevo
				</a>
				@if (Session::has('flash_message'))
				<label class="label label-success">
					<p>{{ Session::get('flash_message') }}</p>
				</label>
				@endif
				<div class="panel-body">
					<table class="table table-striped" id="table-example">
						<thead>
							<tr>
								<th class="text-center">Simbolo</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Eliminar</th>
							</tr>
						</thead>
						<tbody align="center">																				
							@foreach($exchanges as $exchange)
							<tr class="odd gradeX">	
								<td>{{$exchange->symbol}}</td>
								<td>{{$exchange->name}}</td>
								<td>
									<a href="{{url('admin/exchanges/'.$exchange->id.'/edit')}}"  class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil-square-o"></i>Editar</a>
                                </td>
                                <td>
                                    {{ Form::open(array('method'=>'PATCH','url' => 'admin/exchanges/'.$exchange->id)) }}
                                      {{ Form::hidden("_method", "DELETE") }}
                                      <button type="submit" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil-square-o"></i>Eliminar</button>
                                    {{ Form::close() }}
								</td>
							</tr>
							@endforeach															
						</tbody>
					</table>
				</div>
				<!-- //content > row > col-lg-8 -->
			</section>
			<!-- //tabbable -->
		</div>
		<!-- //main-->
	</div>
	<!-- //main-->
</div>
<!-- //main-->


@stop
@section('js-script')
function fnShowHide( iCol , table){
var oTable = $(table).dataTable(); 
var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

$(function() {
//////////     DATA TABLE  COLUMN TOGGLE    //////////
$('[data-table="table-toggle-column"]').each(function(i) {
var data=$(this).data(), 
table=$(this).data("table-target"), 
dropdown=$(this).parent().find(".dropdown-menu"),
col=new Array;
$(table).find("thead th").each(function(i) {
$("<li><a  class='toggle-column' href='javascript:void(0)' onclick=fnShowHide("+i+",'"+table+"') ><i class='fa fa-check'></i> "+$(this).text()+"</a></li>").appendTo(dropdown);
});
});

//////////     COLUMN  TOGGLE     //////////
$("a.toggle-column").on('click',function(){
$(this).toggleClass( "toggle-column-hide" );  				
$(this).find('.fa').toggleClass( "fa-times" );  			
});

// Call dataTable in this page only
$('#table-example').dataTable();
$('table[data-provide="data-table"]').dataTable();
});
@stop