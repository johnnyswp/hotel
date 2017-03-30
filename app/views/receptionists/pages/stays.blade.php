@extends('receptionists.master') 
<?php use Carbon\Carbon; ?>
@section('title', trans('main.title_estadias'))
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-md-12">
			 <section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.title_estadias')}}</strong></h2>
        @if(Sentry::getUser()->type_user==3)
          @if(Payment::VeryPaymentMessage()==false)
             <label class="label label-danger">{{trans('main.message end plans')}}.  {{trans('main.date end')}} {{Carbon::parse(Payment::PaymentsDate())->format('d-m-Y')}}</label>
          @endif
        @endif
				@if (Session::has('flash_message'))
          <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
        @endif
        @if (Session::has('error'))
        <label class="color" style="font-size: 12px; color: red;">{{ Session::get('error') }}</label>
        @endif
			</header>
			<div class="panel-body">		
      @if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)	  
        <form class="form-horizontal"  data-collabel="3" data-alignlabel="left"  data-label="color">
					<div class="form-group">
						<div>
							<a href="{{url('receptionist')}}" class="btn btn-theme">{{trans('main.nuevo check_in')}}</a>
						</div>
					</div>
				</form>
      @endif

				<table class="table" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.huesped')}}</td>
							<td>{{trans('main.room')}}</td>
              <td>{{trans('main.date')}}</td>
							<td>{{trans('main.hour')}}</td>
							<td>{{trans('main.date_end')}}</td>
							<td>{{trans('main.hour_end')}}</td>
              @if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)
              <td>{{trans('main.check out')}}</td>
              @endif
              <td>{{trans('main.order')}}</td>
              @if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)
							<td>{{trans('main.action')}}</td>
              @endif
						</tr>
					</thead>

					<tbody>
					@foreach($stays as $stay)
					 
						<tr>
							<td>{{$stay->nombre_huesped}} </td>						
							<td>{{$stay->numero_habitacion}} </td>
							<td>{{Helpers::date_bd($stay->date_start);}} </td>
							<td>{{Helpers::hora_min($stay->hour_start)}} </td>
							<td>{{Helpers::date_bd($stay->date_end);}} </td>
							<td>{{Helpers::hora_min($stay->hour_end)}} </td>
              @if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)
              <td>
                  <button class="btn btn-info btn-transparent" type="submit" data-toggle="tooltip" data-placement="left" title="{{trans('main.delete')}}" onclick="var notice = new PNotify({
                            text: $('#form_notice_{{$stay->id}}').html(),
                            icon: false,
                            width: 'auto',
                            hide: false,
                            addclass: 'custom',
                            icon: 'picon picon-32 picon-edit-delete',
                            opacity: .8,
                            nonblock: {
                                nonblock: true
                            },
                            animation: {
                                effect_in: 'show',
                                effect_out: 'slide'
                            },
                            buttons: {
                              closer: false,
                              sticker: false
                            },
                            insert_brs: false
                              });
                              notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){
                                notice.remove();
                              }).submit(function(){
                                       $('#form_notice').submit();
                                      });">{{trans('main.check out')}}</button>
                              <div id="form_notice_{{$stay->id}}" style="display: none;">
                                {{ Form::open(array('method'=>'get', 'class'=>'pf-form pform_custom','url' => 'receptionist/stay-check-out/')) }}
                                  {{ Form::hidden("id", $stay->id) }}
                                  <div class="pf-element pf-heading">
                                    <h3>{{trans('main.confirme el check out')}}</h3>
                                    <p></p>
                                  </div>
                                  <div class="pf-element pf-buttons pf-centered">
                                    <input class="pf-button btn btn-primary" type="submit" name="submit" value="{{trans('main.confirmar')}}" />
                                    <input class="pf-button btn btn-default" type="button" name="cancel" value="{{trans('main.cancelar')}}" />
                                  </div>
                                {{ Form::close() }}
                              </div>
              </td>
              @endif
              <td><a class="btn btn-info btn-transparent" href="{{url('receptionist/orders/'.$stay->id)}}" data-toggle="tooltip" data-placement="left" title="{{trans('main.orders')}}"> {{trans('main.pedidos')}}</a> </td>
			        @if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)
              <td>	 
			        	 
			        	 <a href="{{url('receptionist/stay-edit/'.$stay->id)}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a>
			        	 <button class="btn btn-info btn-transparent" type="submit" data-toggle="tooltip" data-placement="left" title="{{trans('main.delete')}}" onclick="var notice = new PNotify({
                            text: $('#form_notice_{{$stay->id}}').html(),
                            icon: false,
                            width: 'auto',
                            hide: false,
                            addclass: 'custom',
                            icon: 'picon picon-32 picon-edit-delete',
                            opacity: .8,
                            nonblock: {
                                nonblock: true
                            },
                            animation: {
                                effect_in: 'show',
                                effect_out: 'slide'
                            },
                            buttons: {
                              closer: false,
                              sticker: false
                            },
                            insert_brs: false
                              });
                              notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){
                                notice.remove();
                              }).submit(function(){
                                       $('#form_notice').submit();
                                      });"><i class="glyphicon glyphicon-remove"></i></button>
                              <div id="form_notice_{{$stay->id}}" style="display: none;">
                                {{ Form::open(array('method'=>'get', 'class'=>'pf-form pform_custom','url' => 'receptionist/stay-delete/'.$stay->id)) }}
                                  {{ Form::hidden("_method", "DELETE") }}
                                  <div class="pf-element pf-heading">
                                    <h3>{{trans('main.confirme borrar estadia')}}</h3>
                                    <p></p>
                                  </div>
                                  <div class="pf-element pf-buttons pf-centered">
                                    <input class="pf-button btn btn-primary" type="submit" name="submit" value="{{trans('main.confirmar')}}" />
                                    <input class="pf-button btn btn-default" type="button" name="cancel" value="{{trans('main.cancelar')}}" />
                                  </div>
                                {{ Form::close() }}
                              </div>
			         </td>
               @endif
							 
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</section>
		</div>

	</div>
	
</div>
@stop

 

@section('script')

<script type="text/javascript">
	$(function() {
		$('#sector_table').dataTable();
		$('.clic-delete').on('click', function(event) {
			event.preventDefault();
			var notice = new PNotify({
                  text: '{{trans('main.confirme borrar estadia')}}',
                  icon: false,
                  width: 'auto',
                  hide: false,
                  addclass: 'custom',
                  icon: 'picon picon-32 picon-edit-delete',
                  opacity: .8,
                  nonblock: {
                      nonblock: true
                  },
                  animation: {
                      effect_in: 'show',
                      effect_out: 'slide'
                  },
                  buttons: {
                    closer: false,
                    sticker: false
                  },
                  insert_brs: false
             });  
			notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){
              notice.remove();
            }).submit(function(){
                console.log('Dale');
            });
			/* Act on the event */
		});
	});
</script>
@stop