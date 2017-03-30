@extends('hotel.master')

@section('title', 'Hotel Dashboard')

@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-12">
			<section class="panel corner-flip">
				<header class="panel-heading sm" data-color="theme-inverse">
					<div class="pull-letf"><h2><strong>{{trans('main.payments sms')}}</strong>.</h2></div>
					
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|{{trans('main.package')}}:</strong><br> | <a href="{{url('hotel/payment/sms/plans')}}" class="label label-success">{{trans('main.packages')}}</a></div>
					<div class="pull-right" style="display: block; margin-top: -37px;"><strong>|{{trans('main.sms Number Available')}}:</strong><br> | @if(isset($payment)) {{$payment->sms}} @else 0 @endif SMS</div>
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
								<th class="text-center">{{trans('main.package')}}</th>
								<th class="text-center">{{trans('main.number sms')}}</th>
								<th class="text-center">{{trans('main.payments')}}</th>
								<th class="text-center">{{trans('main.state')}}</th>
							</tr>
						</thead>
						<tbody align="center">
						@if(isset($payms))																	
							@foreach($payms as $d)
							<?php $p = PlanSms::where('id', $d->plan_id)->first(); ?>
							<tr class="odd gradeX">																		
								<td>@if($p) {{$p->name}} @else {{trans('main.special package')}} @endif</td>
								<td>{{$d->sms}} SMS</td>
								<td>€ {{$d->price}}</td>
								<td>
									@if($d->state==1) 
									<label class="label label-success">{{trans('main.refill Completed')}}</label> 
									@else
									<label class="label label-danger">{{trans('main.Pending refill')}} </label>
									@endif
								</td>
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



});
@stop