@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-12 ">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.Users')}}</strong></h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
                <form class="form-horizontal" data-collabel="3" data-alignlabel="left"  data-label="color">
    
					<div class="form-group">
						<div>
							<a href="{{url('hotel/users/create')}}" class="btn btn-theme">{{trans('main.nuevo')}} {{trans('main.user')}}</a>
						</div>
					</div>
				</form>

				<table class="table table-bordered" id="users_table">
					<thead>
						<tr>
							<td>{{trans('main.user')}}</td>
							<td>{{trans('main.first name')}}</td>
							<td>{{trans('main.last name')}}</td>
							<td>{{trans('main.cocina')}}</td>
							<td>{{trans('main.recepcion')}}</td>
							<td>{{trans('main.Editar')}}</td>
							<td>{{trans('main.delete')}}</td>
						</tr>
					</thead>

					<tbody>
					@foreach($users as $user)
					    @if($user->type_user!=3)
						<tr>
							<td>{{$user->username}} </td>
							<td>{{$user->first_name}} </td>
							<td>{{$user->last_name}} </td>
							<td><img src="@if($user->type_user==0 or $user->type_user==3 or $user->type_user==2) {{url('assets/img/active.png')}} @else {{url('assets/img/no-active.png')}} @endif" width="35px" height="35px" style="display: block; margin: 0 auto;"> </td>
							<td><img src="@if($user->type_user==0 or $user->type_user==3 or $user->type_user==1) {{url('assets/img/active.png')}} @else {{url('assets/img/no-active.png')}} @endif" width="35px" height="35px" style="display: block; margin: 0 auto;"> </td>
							<td><a href="{{url('hotel/users/'.$user->id.'/edit')}}" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color: white;"></span></a></td>
							<td>
								{{ Form::open(array('class'=>'pull-left','url' => 'hotel/users/'.$user->id)) }}
			          			{{ Form::hidden("_method", "DELETE") }}
			          			<button type="submit" class="btn btn-md btn-warning"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			          			{{ Form::close()}}
							</td>
						</tr>
						@endif
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
$('#users_table').dataTable();
});
</script>
@stop