@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-12 ">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.sectores')}}</strong></h2>
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
							<a href="{{url('hotel/sectors/create')}}" class="btn btn-theme">{{trans('main.nuevo')}} {{trans('main.sector')}}</a>
						</div>
					</div>
				</form>

				<table class="table table-bordered" id="sector_table">
					<thead>
						<tr>
							<td>{{trans('main.name')}}</td>
							<td>{{trans('main.Editar')}}</td>
							<td>{{trans('main.delete')}}</td>
						</tr>
					</thead>

					<tbody>
					@foreach($sectors as $sector)
						<tr>
							<td>{{$sector->name}} </td>
							<td><a href="{{url('hotel/sectors/'.$sector->id.'/edit')}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a></td>
							<td>
								{{ Form::open(array('class'=>'pull-left','url' => 'hotel/sectors/'.$sector->id)) }}
			          			{{ Form::hidden("_method", "DELETE") }}
			          			<button type="submit" class="btn btn-md btn-warning"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			          			{{ Form::close()}}
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
$('#sector_table').dataTable();
});
</script>
@stop