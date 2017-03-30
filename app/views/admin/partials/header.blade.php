<header>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Ok</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="{{ set_active('/') }}"><a href="/">Home</a></li>
					<li class="{{ set_active('about') }}"><a href="/about">About</a></li>
					<li class="{{ set_active('contact') }}"><a href="/contact">Contact</a></li>
					<li class="{{ set_active('userProtected') }}"><a href="/userProtected">Registered Users Only</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (!Sentry::check())
					<li class="{{ set_active('register') }}"><a href="/register">Register</a></li>
					<li class="{{ set_active('login') }}"><a href="/login">Login</a></li>
					@else
					<li class="{{ set_active('profiles') }}"><a href="/profiles/{{Sentry::getUser()->id}}">My Profile</a></li>
					<li><a href="/logout">Logout</a></li>
					@endif
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>