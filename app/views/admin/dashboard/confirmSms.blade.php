@extends('admin.master')
@section('title', 'Hotel Dashboard')
<?php use Carbon\Carbon; ?>
@section('content')
<div id="content">
	<div class="row">

		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>Confirmacion de racargas SMS de Easy Room Services</strong> 
						<br>Total de SMS solicitados : {{$userPaymentSms->sum('sms')}} SMS.</h2></div>
						<a href="{{url('admin/refills-confirmation-sms/all-save')}}" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Confirmar Todos"><i class="fa fa-pencil-square-o"></i>Confirmar Todos</a>
				</header>
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
								<th class="text-center">Centro/Doctor</th>
								<th class="text-center">SMS</th>
								<th class="text-center">Fecha y hora de la solicitud</th>
								<th class="text-center">Confirmar</th>
							</tr>
						</thead>
						<tbody align="center">																				
							@foreach($userPaymentSms as $PaymentSms)
							<?php
                            $user = User::find($PaymentSms->user_id);
							?>
							<tr class="odd gradeX">
								<td>{{$PaymentSms->id}}</td>
								@if($hotel = Hotel::where('user_id', $user->id)->first())
								<td><button type="button" class="datos btn btn-info btn-transparent" code="{{$hotel->id}}" data-toggle="tooltip" data-placement="left" title="Ver Datos"><i class="fa fa-pencil-square-o"></i>{{$hotel->name}}</button></td>
								@elseif($doctor = Doctor::where('user_id', $user->id)->first())
								<td><button type="button" class="datos btn btn-info btn-transparent" code="{{$doctor->id}}" data-toggle="tooltip" data-placement="left" title="Ver datos"><i class="fa fa-pencil-square-o"></i>{{$user->getFullName()}}</button></td>
								@endif
								<td>{{$PaymentSms->sms}}</td>
								<td>{{$PaymentSms->created_at}}</td>
								<td><a href="{{url('admin/refills-confirmation-sms/'.$PaymentSms->id.'/save')}}" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Confirmar Recarga"><i class="fa fa-pencil-square-o"></i>Confirmar Recarga</a></td>
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
<div id="md-data-clinic" class="modal fade md-slideUp" tabindex="-1" data-width="605"  data-header-color="inverse">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos del Usuario</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-user-clinic" style="padding-bottom:3px">
	</div>
	<div class="modal-header">
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos Clinica</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-clinic" style="padding-bottom:0">
	</div>
	<!-- //modal-body-->
</div>
<!-- //modal-->

<!--
///////////////////////////////////////////////////////////////////
//////////     MODAL EDITAR EVENTO     //////////
///////////////////////////////////////////////////////////////
-->
<div id="md-data-doctor" class="modal fade md-slideUp" tabindex="-1" data-width="605"  data-header-color="inverse">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos del Doctor</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-user" style="padding-bottom:3px">
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-doctor" style="padding-bottom:0">
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
        url: "{{url('/admin/clinic')}}/"+ident,
        success: function(data){
           var html ='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.dni')}}:  </strong><label class="col-md-8 control-label"> '+data.dni+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.name')}}:  </strong><label class="col-md-8 control-label"> '+data.name+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.email')}}:  </strong><label class="col-md-8 control-label"> '+data.email+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.username')}}:  </strong><label class="col-md-8 control-label"> '+data.username+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.address')}}:  </strong><label class="col-md-8 control-label"> '+data.address+', '+data.city+'</label></div>';
           html+='<img src="'+data.img+'" style="width: 84px; position: absolute; right: 35px; top: 9px; border: 1px solid;">';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.phone')}}:  </strong><label class="col-md-8 control-label"> '+data.phone+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.fn')}}:  </strong><label class="col-md-8 control-label"> '+data.date+'</label></div>';
           $('#data-user-clinic').html(html);
          var clinic='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.clinic')}}:  </strong><label class="col-md-8 control-label"> '+data.clinic+'</label></div>';
           clinic+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.phone')}}:  </strong><label class="col-md-8 control-label"> '+data.phone1+'</label></div>';
           clinic+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.address')}}:  </strong><label class="col-md-8 control-label"> '+data.address1+', '+data.city1+'</label></div>';
           clinic+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.aseguradora')}}:  </strong><label class="col-md-8 control-label"> '+data.insuran+'</label></div>';
           clinic+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.plan')}}:  </strong><label class="col-md-8 control-label"> '+data.plan+'</label></div>';
           clinic+='<div class="col-md-12"></div>';
           clinic+='<button type="button" style="padding-bottom: 20px;" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Cerrar</button>';

           $('#data-clinic').html(clinic);
           $('#md-data-clinic').modal();
        }
    });    
});

$(".datos").click(function(){
    var ident = $(this).attr('code')
    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{url('/admin/doctor')}}/"+ident,
        success: function(data){
           var html ='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.dni')}}:  </strong><label class="col-md-8 control-label"> '+data.dni+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.name')}}:  </strong><label class="col-md-8 control-label"> '+data.name+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.email')}}:  </strong><label class="col-md-8 control-label"> '+data.email+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.username')}}:  </strong><label class="col-md-8 control-label"> '+data.username+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.address')}}:  </strong><label class="col-md-8 control-label"> '+data.address+', '+data.city+'</label></div>';
           html+='<img src="'+data.img+'" style="width: 84px; position: absolute; right: 35px; top: 9px; border: 1px solid;">';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.phone')}}:  </strong><label class="col-md-8 control-label"> '+data.phone+'</label></div>';
           html+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.fn')}}:  </strong><label class="col-md-8 control-label"> '+data.date+'</label></div>';
           $('#data-user').html(html);
          var doctor='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.specialty')}}:  </strong><label class="col-md-8 control-label"> '+data.specialty+'</label></div>';
           doctor+='<div class="col-md-12"><strong class="col-md-3" style="text-align: right;">{{trans('main.plan')}}:  </strong><label class="col-md-8 control-label"> '+data.plan+'</label></div>';
           doctor+='<div class="col-md-12"></div>';
           doctor+='<button type="button" style="padding-bottom: 20px;" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Cerrar</button>';

           $('#data-doctor').html(doctor);
           $('#md-data-doctor').modal();
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