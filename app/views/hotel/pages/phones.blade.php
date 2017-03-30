@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="category">
	<div class="row">
		<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>Telefonos</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body" style="padding-left: 62px; padding-right: 128px;">
				<form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">

					<div class="form-group">
						<div>
							<a href="{{url('hotel/phones/create')}}" class="btn btn-theme">{{trans('main.nuevo')}} {{trans('main.phone')}}</a>
						</div>
					</div>
				</form>

				<div class="panel panel-default">
				    <div class="panel-body">
				      <ul class="col-md-12">
			          	<li class="col-md-12 header-category">
			          		<div class="col-md-2" style="text-align: center;">{{trans('main.phone')}}</div>
			          		<div class="col-md-5" style="text-align: center;">{{trans('main.name')}}</div>
			          		<div class="col-md-2" style="text-align: center;">{{trans('main.state')}}</div>
			          		<div class="col-md-1" style="text-align: center;">{{trans('main.Editar')}}</div>
			          		<div class="col-md-1" style="text-align: center;">{{trans('main.delete')}}</div>
			          		<div class="col-md-1" style="text-align: center;">{{trans('main.language')}}</div>
			          	</li>
                    </ul>
			        <ul id="sortable" class="col-md-12 list">
			          	@foreach ($phones as $phone)
			          	<?php 
                             $name = NamePhone::where('phone_id', $phone->id)->where('language_id', $lang->language_id)->first();
				  	    ?>
			          	<li id="listItem_{{$phone->id}}" class="col-md-12 item-category" style="padding-bottom: 5px; padding-top: 5px;">
			          		<div class="col-md-2">{{$phone->number}}</div>
			          		<div class="col-md-5" style="text-align: center;">{{$name->name}}</div>
			          		<div class="col-md-2" >
			          			<div class="row" style="display: block; width: 75px; margin: 0 auto; height: 25px;">
									<div class="col-sm-4 iSwitch flat-switch">
										<div class="switch">
											<input name="state" class="state" value="{{$phone->id}}" type="checkbox" @if($phone->state==1) checked @endif @if(Phone::phoneState($phone->id)!=true) Disabled @endif>
										</div>
									</div>
								</div>
			          		</div>
			          		<div class="col-md-1">
			          		    <a href="{{url('hotel/phones/'.$phone->id.'/edit')}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a>
			          		</div>
			          		<div class="col-md-1">
			          			<button type="submit" class="btn btn-md btn-warning"  onclick="var notice = new PNotify({text: $('#form_notice_{{$phone->id}}').html(), icon: false, width: 'auto', hide: false, addclass: 'custom', icon: 'picon picon-32 picon-edit-delete', opacity: .8, nonblock: {nonblock: true }, animation: {effect_in: 'show', effect_out: 'slide'}, buttons: {closer: false, sticker: false }, insert_brs: false }); notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){notice.remove(); }).submit(function(){$('#form_notice').submit(); });"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                      <div id="form_notice_{{$phone->id}}" style="display: none;">
                        {{ Form::open(array('class'=>'pf-form pform_custom','url' => 'hotel/phones/'.$phone->id)) }}
                          {{ Form::hidden("_method", "DELETE") }}
                          <div class="pf-element pf-heading">
                            <h3>{{trans('main.confirm delete phone')}}</h3>
                            <p></p>
                          </div>
                          <div class="pf-element pf-buttons pf-centered">
                            <input class="pf-button btn btn-primary" type="submit" name="submit" value="{{trans('main.confirm')}}" />
                            <input class="pf-button btn btn-default" type="button" name="cancel" value="{{trans('main.cancel')}}" />
                          </div>
                        {{ Form::close() }}
                      </div>
			          		</div>
			          		<div class="col-md-1">
			          		    <img src="@if(Phone::phoneState($phone->id)==true) {{url('assets/img/active.png')}} @else {{url('assets/img/no-active.png')}} @endif" width="35px" height="35px" style="display: block; margin: 0 auto;">
			          		</div>
			          	</li>
			          	@endforeach					
			          </ul>
			        </div>
				</div>

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
            url: "{{url('hotel/phone-state')}}",
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


    $("#sortable").sortable({
    	axis: "y",
        update : function () {
    	var order = $("#sortable").sortable('serialize');
    	$.ajax({
            type: 'GET',
            url: "{{url('hotel/phone-position')}}",
            data: order,
            success: function (data) {
                new PNotify({
                    title: "<p>Orden</p>",
                    text: "<p>Movido con exito</p>",
                    addclass: 'custom',
                    icon: 'picon picon-32 picon-mail-mark-notjunk',
                    opacity: .8,
                    nonblock: {
                      nonblock: true
                    },
                    before_close: function(PNotify){
                      PNotify.update({
                        title: PNotify.options.title+" - Enjoy your Stay",
                        before_close: null
                      });
                      PNotify.queueRemove();
                      return false;
                    }
                });
            }
        });
    	}  	   
    });
    $("#sortable").disableSelection();
});
</script>
@stop