<!--
	//////////////////////////////////////////////////////////////
	//////////     LEFT NAV MENU     //////////
	///////////////////////////////////////////////////////////
-->
<nav id="menu"  data-search="close">
	<ul>
		<li><span>Hola:  </span></li>		
		<li><a href="{{url('receptionist/stays')}}"><span><i class="icon  fa fa-phone"></i> {{trans('main.estadias')}}</span></a></li>
		<li><span><i class="icon  fa fa-folder"></i>  {{trans('main.pedidos')}}</span>
			<ul>
				<li><a href="hideUserPanel.html"> Hide User Panel </a></li>
				<li><a href="footerMenu.html"> Footer with menu</a></li>
			</ul>
		</li>
		
		<li><span><i class="icon  fa fa-suitcase"></i> {{trans('main.check out')}} </span>
			<ul>
				<li><a href="chartOther.html"> Other Chart</a></li>
			</ul>
		</li>		
		@if (Sentry::check())
		<li>
		<a href="/profiles/{{Sentry::getUser()->id}}"><span><i class="icon  fa fa-user"></i> 
		{{trans('main.mi perfil')}} </span></a>
		</li>
		<li><a href="/logout"><span><i class="icon  fa fa-times"></i> {{trans('main.salir')}} </span></a> </li>
		@endif
	</ul>
</nav>
<!-- //nav left menu-->
