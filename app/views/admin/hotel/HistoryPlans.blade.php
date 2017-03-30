@extends('admin.master')

@section('title', 'Hotel Dashboard')

@section('content')
<?php
use Carbon\Carbon;
$plan = Plan::find($payment->plan_id);
$create =  Carbon::parse($payment->updated_at);
$caducidad = $create->addDays($payment->time);
$user    = Sentry::getUser();
?>
<div id="content">
	<div class="row">

		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>{{trans('main.payments')}}</strong>.</h2></div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|Renovar ahora:</strong><br> | <button type="button" class="plan btn btn-info btn-transparent" code="{{$hotel->id}}" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil-square-o"></i>Renovar</button></div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|Caducidad:</strong><br> | {{$caducidad->toDateString()}}</div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|precio:   </strong><br> | € {{round($payment->price, 2)}}  </div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|No. languages:</strong><br> | {{$plan->languages}}</div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|No. item:</strong><br> | {{$plan->items}}</div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|Plan:</strong><br> | {{$plan->name}}</div>
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
								<th class="text-center">Fecha de Caducidad</th>
								<th class="text-center">languages</th>
								<th class="text-center">Items</th>
								<th class="text-center">Precio</th>
							</tr>
						</thead>
						<tbody align="center">																	
							@foreach($payms as $d)
							<?php 
							$p = Plan::where('id', $d->plan_id)->first(); 
							$c =  Carbon::parse($d->updated_at);
							$ca = $c->addDays($d->time);
							?>
							<tr class="odd gradeX">																		
								<td>{{$p->name}}</td>
								<td>{{$ca->toDateString()}}</td>
								<td>{{$p->languages}} Lenguajes</td>
								<td>{{$p->items}} Items</td>
								<td>€ {{round($d->price, 2)}}</td>
							</tr>
							@endforeach																			
						</tbody>
					</table>
					
				</div>
				{{$payms->links()}}
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
<div id="md-payment-plan" class="modal fade md-slideUp" tabindex="-1" data-width="605"  data-header-color="inverse">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		<h4 class="modal-title"><i class="fa fa-plus"></i> Renovar plan</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" style="padding-bottom:50px">
        {{Form::open(array('method'=>'get','action' => 'AdminPlansController@getPlan'))}}
        {{ Form::hidden("hotel_id", NULL,['class' => 'hotel_id']) }}
        <div class="form-group">
			<label class="control-label">Seleccione un plan</label>
			<div class="row">
				<div class="col-md-12">
                    <select name="plan_id"  class="selectpicker form-control">
                        @foreach($plans as $plan1)
                            @if($plan->id==$plan1->id)
                            <option value="{{$plan1->id}}" selected>{{$plan1->name}}  (€ {{$plan1->price}})</option>
                            @else
                            <option value="{{$plan1->id}}">{{$plan1->name}}  (€ {{$plan1->price}})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label">Fecha de vencimiento</label>
			<div>
				<div class="row">
					<div class=" col-lg-12">
						{{ Form::text("end", NULL, ['class' => 'form-control', 'id'=>'datetimepicker3']) }}
					</div>
				</div>
			</div>
		</div><!-- //form-group-->
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
$('#datetimepicker3').datetimepicker({
        defaultDate:false,
        viewMode: 'years',
        format: 'YYYY/MM/DD',
        minDate: moment().add(1, 'day').format(),
    });
function fnShowHide( iCol , table){
var oTable = $(table).dataTable(); 
var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

$(function() {

$(".plan").click(function(){
    var ident = $(this).attr('code');
    $('.hotel_id').val(ident);        
    $('#md-payment-plan').modal();   
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