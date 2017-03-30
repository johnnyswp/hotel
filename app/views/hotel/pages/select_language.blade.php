@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.languages')}}</strong></h2>
				<h5><strong>{{trans('main.lang')}}:</strong> {{$lang_main->language->language}}</h5>
				@if (Session::has('flash_message'))
        <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
        @endif

			</header>
			<div class="panel-body">
				<div class="form-group">
					<div>
						<button type="button" class="btn btn-theme" onclick="$('#md-ajax').modal();">{{trans('main.add language')}}</button>
					</div>
				</div>

				<div class="panel panel-default">
				  <!-- Default panel contents -->

				  <!-- Table -->
				  <table class="table table-striped" id="table-example">
				  	<thead>
				  		<tr>
					    	<td>{{trans('main.language')}}</td>
					    	<td>{{trans('main.state')}}</td>
					    	<td>{{trans('main.completado')}}</td>
					    	<td>{{trans('main.delete')}}</td>
					    </tr>
				  	</thead>

				  	<tbody>
				  	    @foreach($langs_actives as $lang)
				  	    @if($lang_main->id!=$lang->id)
				  		<tr>
				  			<td>{{$lang->language->language}}</td>
				  			<td>
								  <div class=" iSwitch flat-switch">
								  	<div class="switch switch-small">
								  		<input type="checkbox" class="checkAjax lang_state" data-toggle="tooltip" data-placement="left"  title="  Activado" state="{{$lang->id}}" @if($lang->state==1) checked @endif @if(LanguageHotel::langstate($lang->  id)!=true) disabled @endif>
								  	</div>
								  </div>
				  			</td>
				  			<td>
				  			    <img src="@if(LanguageHotel::langstate($lang->id)==true) {{url('assets/img/active.png')}} @else {{url('assets/img/no-active.png')}} @endif" width="35px" height="35px" >
				  			</td>
				  			<td>
                      <button type="submit" class="btn btn-md btn-warning"  onclick="var notice = new PNotify({text: $('#form_notice_{{$lang->id}}').html(), icon: false, width: 'auto', hide: false, addclass: 'custom', icon: 'picon picon-32 picon-edit-delete', opacity: .8, nonblock: {nonblock: true }, animation: {effect_in: 'show', effect_out: 'slide'}, buttons: {closer: false, sticker: false }, insert_brs: false }); notice.get().find('form.pf-form').on('click', '[name=cancel]', function(){notice.remove(); }).submit(function(){$('#form_notice').submit(); });"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                      <div id="form_notice_{{$lang->id}}" style="display: none;">
                        {{ Form::open(array('class'=>'pf-form pform_custom','url' => url('hotel/language-delete').'/'.$lang->id)) }}
                          {{ Form::hidden("_method", "DELETE") }}
                          <div class="pf-element pf-heading">
                            <h3>{{trans('main.confirm delete lang')}}</h3>
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
				  		@endif
				  		@endforeach
				  	</tbody>
				    
				  </table>
				</div>

			</div>
		</section>
		</div>

	</div>
	
</div>
<div id="md-ajax" class="modal fade" tabindex="-1">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>{{trans('main.Alta de Lenguaje')}}</h3>
		</div>
		<div class="modal-body">
		{{ Form::open(array('id'=>'add_lang', 'url' => url('hotel/language-create'), 'method'=>'POST')) }}
			<div class="form-group">
                <label class="control-label">{{trans('main.language')}}</label>
                <div>
                    {{ Form::select('lang', $langs, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                    <div class="lang errors_form" style="color: red;"></div>
                </div>
            </div>
            <div class="form-group">
				<div>
					<button type="submit" class="btn btn-theme save">{{trans('main.save')}}</button>
				</div>
			</div>		
		{{ Form::close()}}
		</td>
		</div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $('.selectpicker').selectpicker();
	$(function() {
		$('.lang_state').change(function() {
            var $input = $(this);  
            var check = $input.prop("checked");
            if(check){
                $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: "{{url('hotel/language-state')}}",
                    data: {id: $input.attr("state")},
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
            }else{
               $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: "{{url('hotel/language-state')}}",
                    data: {id: $input.attr("state")},
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
            }
        });
		// Call dataTable in this page only
		$('#table-example').dataTable();
		//petición al enviar el formulario de registro de citas
	    $('#add_lang').bind('submit',function () {
	    	var form = $(this); 
	        $('.save').prop('disabled', true);
	        $.ajax({
	            type: form.attr('method'),
	            url: form.attr('action'),
	            data: form.serialize(),
	            success: function (data){
                  
	            	if(data.success == false){

	                	if(!data.errors['lang']){$('.lang').html('');}
	                	else{$('.lang').html(data.errors['lang']);}	  

	                	if(data.error)
	                	{
	                		$('.lang').html(data.error);
	                	}              	
	                	$('.save').prop('disabled', false);

	                }else{
	                    window.location.reload();
	                }
	            }
	        });
	        return false;
	    });

	});

   
</script>
@stop