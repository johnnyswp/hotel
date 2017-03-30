@extends('receptionists.master') 
@section('title', trans('main.title_estadias'))
@section('content')
<div id="check_in">	
	<div class="row">
		<div class="col-md-12">
			 <section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.title_estadias')}}</strong></h2>
			</header>
			<div class="panel-body">			  
				<table class="table" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.huesped')}}</td>
							<td>{{trans('main.room')}}</td>
                            <td>{{trans('main.date')}}</td>
							<td>{{trans('main.hour')}}</td>
							<td>{{trans('main.date_end')}}</td>
							<td>{{trans('main.hour_end')}}</td>
                            <td>{{trans('main.order')}}</td>
						</tr>
					</thead>
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
		$('#sector_table').dataTable({
			"processing": true,
            "serverSide": true,
            "ajax": "{{url('receptionist/data-table')}}"
		});
		$('.clic-delete').on('click', function(event) {
			event.preventDefault();
			var notice = new PNotify({
                  text: 'Hola quiere Eliminar este Estadia.',
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