@extends('admin.master')
@section('title', 'Hotel Dashboard')
<?php use Carbon\Carbon; ?>
@section('content')
<div id="content">
	<div class="row">

		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>lenguajes Easy Rooms Services</strong>.</h2></div>
				</header>
				<a href="{{url('/admin/languages/create')}}" class="plan-add btn btn-primary" style='margin-top: 10px; margin-left: 10px;'>
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
								<th class="text-center">Bandera</th>
								<th class="text-center">Lenguaje</th>
								<th class="text-center">State</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Eliminar</th>
							</tr>
						</thead>
						<tbody align="center">																				
							@foreach($langs as $lang)
							<tr class="odd gradeX">	
								<td><img src="@if($lang->flag){{$lang->flag}} @else {{url('/assets/img/no-image.png')}} @endif" width="50px" height="35px" style="display: block; margin: 0 auto;"></td>
								<td>{{$lang->language}}</td>
								<td><img src="@if($lang->state==1) {{url('assets/img/active.png')}} @else {{url('assets/img/no-active.png')}} @endif" width="35px" height="35px" style="display: block; margin: 0 auto;">></td>
								<td>
									<a href="{{url('admin/languages/'.$lang->id.'/edit')}}"  class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil-square-o"></i>Editar</a>
                                </td>
                                <td>
                                    {{ Form::open(array('method'=>'PATCH','url' => 'admin/languages/'.$lang->id)) }}
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