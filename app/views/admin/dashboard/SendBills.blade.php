@extends('admin.master')
@section('title', 'Hotel Dashboard')
<?php use Carbon\Carbon; ?>
@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>Confirmacion de Pagos de Easy Room Services</strong> 			</header>
				@if (Session::has('flash_message'))
				<label class="label label-success">
					<p>{{ Session::get('flash_message') }}</p>
				</label>
				@endif
				<div class="panel-body">
					<table class="table table-striped" id="table-example">
						<thead>
							<tr>
								<th class="text-center">id</th>
								<th class="text-center">Hotel</th>
								<th class="text-center">Plan</th>
								<th class="text-center">Fecha y hora de la solicitud</th>
								<th class="text-center">Pago</th>
								<th class="text-center">Confirmar</th>
							</tr>
						</thead>
						<tbody align="center">																				
							@foreach($userPayments as $Payment)
							<?php
                            $user = User::find($Payment->user_id);
                            $plan = Plan::find($Payment->plan_id);
                            $hotel = Hotel::where('user_id', $user->id)->first();
							?>
							<tr class="odd gradeX">
								<td>{{$Payment->id}}</td>
								<td><button type="button" class="datos btn btn-info btn-transparent" code="{{$hotel->id}}" data-toggle="tooltip" data-placement="left" title="Ver Datos"><i class="fa fa-pencil-square-o"></i>{{$hotel->name}}</button></td>
								<td>{{$plan->name}}</td>
								<td>{{$Payment->created_at}}</td>
								<td>€ {{round($Payment->price,2)}}</td>
								<td><a href="{{url('admin/refills-confirmation-payment/'.$Payment->id.'/save')}}" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Factura enviada"><i class="fa fa-pencil-square-o"></i>Factura enviada</a></td>
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

<!--
///////////////////////////////////////////////////////////////////
//////////     MODAL EDITAR EVENTO     //////////
///////////////////////////////////////////////////////////////
-->
<div id="md-data-hotel" class="modal fade md-slideUp" tabindex="-1" data-width="605"  data-header-color="inverse">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos del Usuario</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-user" style="padding-bottom:3px">
	</div>
	<div class="modal-header">
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos Hotel</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-hotel" style="padding-bottom:0">
	</div>
	<!-- //modal-body-->
</div>
<!-- //modal-->

@stop
@section('js-script')
$(".datos").click(function(){
    var ident = $(this).attr('code')
    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{url('/admin/hotels')}}/"+ident,
        success: function(data){
           var html ='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.name')}}:  </strong><label class="col-md-8 control-label"> '+data.name+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.email')}}:  </strong><label class="col-md-8 control-label"> '+data.email+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.username')}}:  </strong><label class="col-md-8 control-label"> '+data.username+'</label></div>';
           html+='<img src="'+data.img+'" style="width: 84px; position: absolute; right: 35px; top: 9px; border: 1px solid;">';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.phone')}}:  </strong><label class="col-md-8 control-label"> '+data.phone+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.fn')}}:  </strong><label class="col-md-8 control-label"> '+data.date+'</label></div>';
           $('#data-user').html(html);
          var hotel='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.hotel')}}:  </strong><label class="col-md-8 control-label"> '+data.hotel+'</label></div>';
           hotel+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.phone')}}:  </strong><label class="col-md-8 control-label"> '+data.phone1+'</label></div>';
           hotel+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.plan')}}:  </strong><label class="col-md-8 control-label"> '+data.plan+'</label></div>';
           hotel+='<div class="col-md-12"></div>';
           hotel+='<button type="button" style="padding-bottom: 20px;" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Cerrar</button>';

           $('#data-hotel').html(hotel);
           $('#md-data-hotel').modal();
        }
    });    
});


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