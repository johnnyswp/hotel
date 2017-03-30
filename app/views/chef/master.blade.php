<!DOCTYPE html>
<html lang="en">
<head>        
    <!-- META SECTION -->
    <title>@yield('title') - Easy Room service</title>              
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
   <!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url('assets/ico/apple-touch-icon-144-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url('assets/ico/apple-touch-icon-114-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url('assets/ico/apple-touch-icon-72-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" href="{{url('assets/ico/apple-touch-icon-57-precomposed.png')}}">
<link rel="shortcut icon" href="{{url('assets/ico/favicom.ico')}}">
    <!-- END META SECTION -->
    
    <!-- CSS INCLUDE -->        
    <link rel="stylesheet" type="text/css" id="theme" href="{{url()}}/chefs/css/theme-default.css"/>
    <link rel="stylesheet" type="text/css"            href="{{url()}}/chefs/css/chef.css"/>
    <link rel="stylesheet" type="text/css"            href="{{url()}}/assets/css/formhelpers.min.css"/>
    <!-- EOF CSS INCLUDE -->      
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/moment.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/formhelpers.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/pnotify.core.css')}}"/>
    {{ HTML::style('assets/css/oxygen/icons.css') }}

</head>
<body>
 	<div class="page-container page-navigation-toggled">
 		<div class="page-content">
            @include('chef.partials.navigation_vertical')
			@yield('content')
		</div> 
	</div>
 
	<!-- START SCRIPTS -->
    <!-- START PLUGINS -->
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{url()}}/assets/plugins/bootstrap/bootstrap.min.js"></script>        
    <!-- END PLUGINS -->

    <!-- START THIS PAGE PLUGINS-->        
    <script type='text/javascript' src="{{url()}}/chefs/js/plugins/icheck/icheck.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/timeago/jquery.timeago.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/countdown/jquery.countdown.js"></script>    
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins/bootstrap/bootstrap-select.js"></script> 
    <script src="{{url('assets/js/pnotify.core.js')}}"></script>
    <script src="{{url('assets/js/isotope.pkgd.min.js')}}"></script>
    <!-- END THIS PAGE PLUGINS-->        

    <!-- START TEMPLATE -->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/TweenMax.min.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/plugins.js"></script>        
    <script type="text/javascript" src="{{url()}}/chefs/js/actions.js"></script>
    <script type="text/javascript" src="{{url()}}/chefs/js/demo_tasks.js"></script>
    <script type="text/javascript">
        $('.change-lang').change(function(){
            $(this).parent().submit();
        });
    </script>

</body>
</html>