@extends('hotel.master')

@section('title', 'Hotel Dashboard')

@section('content')
<?php
use Carbon\Carbon;
$plan = Plan::find($payment->plan_id);
$create =  Carbon::parse($payment->updated_at);
$caducidad = $create->addDays($payment->time);
$date = new DateTime($caducidad);
$user    = Sentry::getUser();
?>
<div id="content">
		  	<div class="row">
		  				
		  		<div class="col-lg-12">
		  			<section class="panel corner-flip">
                          <header class="panel-heading sm" data-color="theme-inverse">
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <div class="pull-letf"><h3><strong>{{trans('main.payments')}}</strong>.</h3></div>
                            </div>
                            <div class="col-lg-7 col-md-12 col-sm-12">
                                <div class="col-lg-3 col-md-6 col-sm-6" style="padding-left: 0; padding-right: 0;"><strong>|{{trans('main.plan')}}:</strong><br> | {{$plan->name}}</div>
                                <div class="col-lg-3 col-md-6 col-sm-6" style="padding-left: 0; padding-right: 0;"><strong>|{{trans('main.rooms')}}/{{trans('main.items')}}:</strong><br> |{{$plan->rooms}} / {{$plan->items}}</div>
                                <div class="col-lg-3 col-md-6 col-sm-6" style="padding-left: 0; padding-right: 0;"><strong>|{{trans('main.expiration')}}:</strong><br> |{{$date->format('d-m-Y')}}</div>
                                <div class="col-lg-3 col-md-6 col-sm-6" style="padding-left: 0; padding-right: 0; z-index: 999; position: relative;"><strong>|{{trans('main.renew now')}}:  </strong><br> | @if(Payment::VeryPaymentMessage()==false) {{Form::open(array('method'=>'post', 'style'=>'float: right;', 'action' => 'PaymentsController@postPayment'))}} {{Form::hidden("plan_id", $plan->id)}} <button type="submit" class="label label-success" style="height: 21px; margin-left: 3px;">{{trans('main.renew now')}} € {{$plan->price}}</button> {{ Form::close() }}  <a href="{{url('hotel/payment/plans')}}" class="label label-success">{{trans('main.view plans')}}</a> @else <a href="{{url('hotel/payment/change')}}" class="label label-success" >{{trans('main.change plan')}}</a> @endif</div>
                                
                            </div>
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
										<th class="text-center">{{trans('main.plan name')}}</th>
										<th class="text-center">{{trans('main.date of expiry')}}</th>
										<th class="text-center">{{trans('main.rooms')}}</th>
										<th class="text-center">{{trans('main.items')}}</th>
										<th class="text-center">{{trans('main.pago')}}</th>
									</tr>
								</thead>
								<tbody align="center">	
								<?php 
                                    $payms = Userpayment::where('user_id', $user->id)->orderby('id','desc')->paginate(10);
                                    
								?>																		
									@foreach($payms as $d)
									<?php 
									$p = Plan::where('id', $d->plan_id)->first(); 
                                    $c =  Carbon::parse($d->updated_at);
                                    $ca = $c->addDays($d->time);
                                    $dt = new DateTime($ca);
									?>
									<tr class="odd gradeX">																		
										<td>{{$p->name}}</td>
										<td>{{$dt->format('d-m-Y')}}</td>
										<td>{{$p->rooms}} {{trans('main.rooms')}}</td>
										<td>{{$p->items}} {{trans('main.items')}}</td>
										<td>€ {{round($d->price, 2)}}</td>
									</tr>
									@endforeach																			
								</tbody>
							</table>
							{{$payms->links()}}
					</div>
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