<!--
	//////////////////////////////////////////////////////////////
	//////////     LEFT NAV MENU     //////////
	/////////////////////////////////////////////////////////// {{trans('main.')}}
-->

<nav id="menu"  data-search="close">
	<ul>	
	@if(Helpers::typeU()==1 or Helpers::typeU()==3 or Helpers::typeU()==0)
	    <li><span><i class="icon fa fa-bars"></i>{{trans('main.recepcion')}}</span>
	    	<ul>
	    		<li><a href="{{url('receptionist/stays')}}"><span> {{trans('main.estadias')}}</span></a></li>
	    		<li><a href="{{url('receptionist/all-stays')}}"><span> {{trans('main.busqueda de estadias')}}</span></a></li>
	    		<li><a href="{{url('receptionist/all-order')}}"><span> {{trans('main.busqueda de peidos')}}</span></a></li>
	    	</ul>
	    </li>
    @endif
    @if(Helpers::typeU()==2 or Helpers::typeU()==3 or Helpers::typeU()==0)
	    <li><a href="{{url('chef')}}"><span><i class="icon fa fa-bars"></i> {{trans('main.cocina')}}</span></a></li>
	@endif
	@if(Helpers::typeU()==3)
	    <li><span><i class="icon fa fa-bars"></i>{{trans('main.menu')}}</span>
	    	<ul>
	    	    <li><a href="{{url('hotel/language')}}"><span>{{trans('main.languages')}}</span></a></li>
	    	    <li><a href="{{url('hotel/category')}}"><span>{{trans('main.categories')}}</span></a></li>
	    	    <li><a href="{{url('hotel/menu')}}"><span>{{trans('main.Productos')}} </span></a></li>
	    	</ul>
	    </li>
	@endif
	    <li><span><i class="icon  fa fa-cogs"></i> {{trans('main.Configuracion')}}</span>
	    	<ul>
	    		<li><a href="{{url('hotel/profile')}}"><span> {{trans('main.Mi Perfil')}}</span></a></li>
	    	    @if(Helpers::typeU()==3)
				<li><a href="{{url('hotel/edit')}}"> <span>{{trans('main.Hotel')}}</span></a></li>
				<li><a href="{{url('hotel/schedule')}}"> <span>{{trans('main.Horario')}}</span></a></li>
				<li><a href="{{url('hotel/phones')}}"> <span>{{trans('main.Telefonos')}}</span></a></li>
				<li><a href="{{url('hotel/sectors')}}"> <span>{{trans('main.Sectores')}}</span></a></li>
				<li><a href="{{url('hotel/rooms')}}"> <span>{{trans('main.Habitaciones')}}</span></a></li>
				<li><a href="{{url('hotel/users')}}"> <span>{{trans('main.Users')}}</span></a></li>
				<li><a href="{{url('hotel/payment/history')}}"><span>{{trans('main.Plan')}}</span></a></li>
				@endif
				
	    	</ul>
	    </li>
	    <!--<li><span><i class="icon  fa fa-bar-chart-o"></i> {{trans('main.Estadisticas')}} </span></li>-->
	    @if (Sentry::check())
		<li><a href="{{url('logout')}}"><span><i class="icon  fa fa-times"></i> {{trans('main.Salir')}} </span></a> </li>
		@endif
		<li><a href="{{url('help/easyroomservice.help.'.Helpers::lang().'.pdf')}}"><span><i class="icon  fa fa-question-circle"></i> {{trans('main.help')}} </span></a> </li>
	</ul>
</nav>
<!-- //nav left menu-->

<style type="text/css">
    #language {
    display: block;
    height: 38px;
    width: 125px;
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 999;
}
</style>
<div id="language">         
    {{ Form::open(array('url' =>'/lang', 'class' => 'filters', 'method' => 'GET')) }}
        {{ Form::select('lang',Language::where('state',1)->lists('language', 'sufijo'), Helpers::lang(), array('class' =>             'selectpicker form-control select change-lang')) }}
    {{ Form::close() }}
</div>
