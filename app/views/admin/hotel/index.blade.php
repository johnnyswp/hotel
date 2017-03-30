@extends('admin.master')
@section('title', 'Hotel Dashboard')
<?php use Carbon\Carbon; ?>
@section('content')
<div id="content">
	<div class="row">

		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>Hoteles Registrados</strong>.</h2></div>
				</header>
				<a href="{{url('/admin/hotels/create')}}" class="btn btn-primary" style='margin-top: 10px; margin-left: 10px;'>
					<i class="fa fa-pencil-square-o"></i> Nuevo
				</a>
				@if (Session::has('flash_message'))
				<div class="form-group">
					<p>{{ Session::get('flash_message') }}</p>
				</div>
				@endif
				@foreach ($errors->all('<p style="  background-color: rgb(216, 47, 47); color: white;">:message</p>') as $message)
				{{ $message }}
				@endforeach
				<div class="panel-body">
					<table class="table table-striped" id="table-example">
						<thead>
							<tr>
								<th class="text-center">id</th>
								<th class="text-center">Hotel</th>
								<th class="text-center">No. Lenguajes</th>
								<th class="text-center">No. Items</th>
								<th class="text-center">Envia SMS</th>
								<th class="text-center">Pagos SMS</th>
								<th class="text-center">Pagos de Planes</th>

							</tr>
						</thead>
						<tbody align="center">																				
							@foreach($hotels as $hotel)
							<?php 
							$langs = LanguageHotel::where('hotel_id', $hotel->id)->count();
							$items = Item::where('hotel_id', $hotel->id)->count();
							$sms      = PaymentSms::where('user_id', $hotel->user_id)->first();
							$payment  = Payment::where('user_id', $hotel->user_id)->first();
							$cad = Carbon::parse($payment->updated_at)->addDays($payment->time)->toDateString();
							?>
							<tr class="odd gradeX">	
								<td>{{$hotel->user_id}}</td>
								<td><button type="button" class="datos btn btn-info btn-transparent" code="{{$hotel->id}}" data-toggle="tooltip" data-placement="left" title="Ver Datos"><i class="fa fa-pencil-square-o"></i>{{$hotel->name}}</button></td>
								<td>{{$langs}}</td>
								<td>{{$items}}</td>
								<td>@if($hotel->sms_state!=0 and $hotel->sms_state!=4) SI @else NO @endif</td>
								<td><a href="{{url('admin/hotel/'.$hotel->id.'/history-payment-sms')}}" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Ver pagos SMS"><i class="fa fa-pencil-square-o"></i>@if($sms){{$sms->sms}} SMS @else 0 SMS @endif</a></td>
								<td><a href="{{url('admin/hotel/'.$hotel->id.'/history-payment-plan')}}" class="btn btn-info btn-transparent"  data-toggle="tooltip" data-placement="left" title="Ver pagos de planes"><i class="fa fa-pencil-square-o"></i>{{$cad}}</a></td>
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
		<h4 class="modal-title"><i class="fa fa-plus"></i> Datos del Hotel</h4>
	</div>
	<!-- //modal-header-->
	<div class="modal-body" id="data-hotel" style="padding-bottom:0">
	</div>
	<!-- //modal-body-->
</div>
<!-- //modal-->
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
                            <option value="{{$plansms->id}}">{{$plansms->name}}</option>                                                                   
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
            <div class=" col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
            </div>
        </div>
		{{ Form::close() }}
	</div>
	<!-- //modal-body-->
</div>
<!-- //modal-->
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
                        <option value="">Seleccione un plan</option> 
                        @foreach($plans as $plan)
                            <option value="{{$plan->id}}">{{$plan->name}}</option>                                                                   
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

$(".sms").click(function(){
    var ident = $(this).attr('code');
    $('.hotel_id').val(ident);
    $('#md-payment-sms').modal();   
});

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

// Call dataTable in this page only
$('#table-example').dataTable();
$('table[data-provide="data-table"]').dataTable();
});
@stop