@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-12 ">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.rooms')}}</strong></h2>
				@if (Session::has('flash_message'))
        <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
        @endif
        @if (Session::has('error'))
        <label class="color" style="color: red;">{{ Session::get('error') }}</label>
        @endif
			</header>
			<div class="panel-body">
                <form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">
    
					<div class="form-group">
						<div>
							<a href="{{url('hotel/rooms/create')}}" class="btn btn-theme">{{trans('main.nueva')}} {{trans('main.room')}}</a>
						</div>
					</div>
				</form>

				<table class="table table-bordered" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.Numero de Habitacion')}}</td>
							<td>{{trans('main.sector')}}</td>
              <td>{{trans('main.state')}}</td>
							<td>{{trans('main.Editar')}}</td>
							<td>{{trans('main.delete')}}</td>
						</tr>
					</thead>

					<tbody>
					@foreach($rooms as $room)
					<?php $sector = Sector::find($room->sector_id) ?>
						<tr>
							<td>{{$room->number_room}} </td>
							<td>{{$sector->name}} </td>
							<td>
							    <div class="iSwitch flat-switch">
									<div class="switch">
										<input name="state" class="state" value="{{$room->id}}" type="checkbox" @if($room->state==1) checked @endif>
									</div>
								</div>
							</td>
							<td><a href="{{url('hotel/rooms/'.$room->id.'/edit')}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a></td>
							<td>
                <button type="submit" class="btn btn-md btn-warning"  onclick="var notice = new PNotify({text: $('#form_notice_{{$room->id}}').html(), icon: false, width: 'auto', hide: false, addclass: 'custom', icon: 'picon picon-32 picon-edit-delete', opacity: .8, nonblock: {nonblock: true }, animation: {effect_in: 'show', effect_out: 'slide'}, buttons: {closer: false, sticker: false }, insert_brs: false }); notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){notice.remove(); }).submit(function(){$('#form_notice').submit(); });"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <div id="form_notice_{{$room->id}}" style="display: none;">
                  {{ Form::open(array('class'=>'pf-form pform_custom','url' => 'hotel/rooms/'.$room->id)) }}
                    {{ Form::hidden("_method", "DELETE") }}
                    <div class="pf-element pf-heading">
                      <h3>{{trans('main.confirm delete room')}}</h3>
                      <p></p>
                    </div>
                    <div class="pf-element pf-buttons pf-centered">
                      <input class="pf-button btn btn-primary" type="submit" name="submit" value="{{trans('main.confirm')}}" />
                      <input class="pf-button btn btn-default" type="button" name="cancel" value="{{trans('main.cancel')}}" />
                    </div>
                  {{ Form::close() }}
                </div>
							</td>
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
	$('.state').change(function() {
        var $input = $(this);
        $.ajax({
            type: 'get',
            dataType: "json",
            url: "{{url('hotel/room-state')}}",
            data: {id: $input.val()},
            success: function(data){
              if(data.success==true){
                new PNotify({
                    title: "<p>{{trans('main.state')}}</p>",
                    text: "<p>"+data.message+"</p>",
                    addclass: 'custom',
                    icon: 'picon picon-32 picon-mail-mark-notjunk',
                    opacity: .8,
                    nonblock: {
                      nonblock: true
                    },
                    before_close: function(PNotify){
                      // You can access the notice's options with this. It is read only.
                      //PNotify.options.text;
            
                      // You can change the notice's options after the timer like this:
                      PNotify.update({
                        title: PNotify.options.title+" - Enjoy your Stay",
                        before_close: null
                      });
                      PNotify.queueRemove();
                      return false;
                    }
                });
            }else{
              new PNotify({
                    title: "<p>{{trans('main.state')}}</p>",
                    text: "<p>"+data.message+"</p>",
                    addclass: 'custom',
                    icon: 'picon picon-32 picon-list-remove',
                    opacity: .8,
                    nonblock: {
                      nonblock: true
                    },
                    before_close: function(PNotify){
                      // You can access the notice's options with this. It is read only.
                      //PNotify.options.text;
            
                      // You can change the notice's options after the timer like this:
                      PNotify.update({
                        title: PNotify.options.title+" - Enjoy your Stay",
                        before_close: null
                      });
                      PNotify.queueRemove();
                      return false;
                    }
                });
            }
          }
        });
    });

$('#sector_table').dataTable();
});
</script>
@stop