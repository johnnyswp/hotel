@extends('admin.master')

@section('title', 'Hotel Dashboard')

@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>{{trans('main.payments sms')}}</strong>, {{$hotel->name}}.</h2></div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|Renovar ahora:</strong><br> | <button type="button" class="sms btn btn-info btn-transparent" code="{{$hotel->id}}" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil-square-o"></i>Renovar</button></div>
					@if(isset($payment))
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|No. SMS Disponibles:</strong><br> | {{$payment->sms}} SMS</div>
					@endif
					@if(Session::has('error'))
					<label class="label label-danger">{{Session::get('error')}}</label>
					@endif

					@if(Session::has('success'))
					<label class="label label-success">{{Session::get('success')}}</label>
					@endif
				</header>
				<div class="panel-body">
					<table class="table table-striped" id="table-example2">
						<thead>
							<tr>
								<th class="text-center">Nombre del plan</th>
								<th class="text-center">No. SMS</th>
								<th class="text-center">Precio</th>
							</tr>
						</thead>
						<tbody align="center">
						@if(isset($payms))																	
							@foreach($payms as $d)
							<?php $p = PlanSms::where('id', $d->plan_id)->first(); ?>
							<tr class="odd gradeX">																		
								<td>@if($p) {{$p->name}} @else Paquete especial @endif</td>
								<td>{{$d->sms}} SMS</td>
								<td>€ {{$d->price}}</td>
							</tr>
							@endforeach
						@endif																		
						</tbody>
					</table>
				</div>
				@if(isset($payms))
				{{$payms->links()}}
				@endif
			</section>

		</div>
	</div>
	<!-- //content > row-->
</div>
<!-- //content-->
<!--
///////////////////////////////////////////////////////////////////
//////////     MODAL EDITAR EVENTO     //////////
///////////////////////////////////////////////////////////////
-->
<div id="md-payment-sms" class="modal fade md-slideUp" tabindex="-1" data-width="605"  data-header-color="inverse">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		<h4 class="modal-title"><i class="fa fa-plus"></i> Regargar sms</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" style="padding-bottom:50px">
        {{Form::open(array('method'=>'get','action' => 'AdminPlansController@getSms'))}}
        {{ Form::hidden("hotel_id", NULL,['class' => 'hotel_id']) }}
        <div class="form-group">
			<div class="row">
				<div class="col-md-5">
					<label class="control-label">Seleccione un plan</label>
                    <select name="plan_id"  class="selectpicker form-control">
                        <option value="">Seleccione un plan</option> 
                        @foreach($plansmss as $plansms)
                            <option value="{{$plansms->id}}">{{$plansms->name}}  (€ {{$plansms->price}})</option>                                                                   
                        @endforeach                                                                 
                    </select>				
                </div>
                <div class="col-md-2">
					<label class="control-label" style="margin: 0 26px;">o</label>			
                </div>
                <div class="col-md-5">
                	<label class="control-label">SMS ha recargar</label>
                   {{ Form::number("sms", NULL, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">Pago</label>
			<div>
				<div class="row">
					<div class=" col-lg-12">
						{{ Form::number("Price", NULL, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>
		</div><!-- //form-group-->
		<div class="form-group">
            <div class=" col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
            </div>
        </div>
		{{ Form::close() }}
	</div>
	<!-- //modal-body-->
</div>
<!-- //modal-->

@stop
@section('js-script')
function fnShowHide( iCol , table){
var oTable = $(table).dataTable(); 
var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

$(function() {
$(".sms").click(function(){
    var ident = $(this).attr('code');
    $('.hotel_id').val(ident);
    $('#md-payment-sms').modal();   
});


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



});
@stop