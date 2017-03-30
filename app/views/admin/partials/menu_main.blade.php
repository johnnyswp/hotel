<!--
	//////////////////////////////////////////////////////////////
	//////////     LEFT NAV MENU     //////////
	///////////////////////////////////////////////////////////
-->
<nav id="menu"  data-search="close">
	<ul>
		<li><a href="{{url('admin')}}"><span><i class="icon  fa fa-laptop"></i> Dashboard</span></a> </li>
		<li><a href="{{url('admin/hotels')}}"><span><i class="icon  fa fa-th-list"></i> {{trans('ad.Hotels')}}</span></a></li>
		<li><a href="{{url('admin/languages')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.Lenguajes')}}</span></a></li>
		<li><a href="{{url('admin/exchanges')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.Divisas')}}</span></a></li>
		<!--<li><a href="{{url('admin/phrases-languages')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.Fraces-Lenguajes')}}</span></a></li>-->

		<li><a href="{{url('admin/planes')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.planes')}}</span></a></li>
		<li><a href="{{url('admin/paquetes-sms')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.paquetes sms')}}</span></a></li>
		<li><a href="{{url('admin/refills-confirmation-sms')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.confirmacion de recargas sms')}}</span></a></li>
		<li><a href="{{url('admin/confirmation-payment')}}"> <span><i class="icon  fa fa-th-list"></i> {{trans('ad.confirmacion de pagos de planes')}}</span></a></li>
		<li><a href="{{url('admin/configuration')}}"><span><i class="icon  fa fa-th-list"></i> {{trans('ad.configuration')}}</span></a></li>
		<li><em><strong>{{trans('main.hi')}}</strong>, Admin </em> </span> </li>
		<li><a href="{{url('/logout')}}"><i class="fa fa-sign-out"></i> {{trans('main.sign_out')}} </a> </li> 
	</ul>
</nav>
<!-- //nav left menu-->
