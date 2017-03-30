<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta information -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- Title-->
<title>@yield('title') - Easy Room Service</title>
<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url()}}/assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url()}}/assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url()}}/assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="{{url()}}/assets/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="{{url()}}/assets/ico/favicom.ico">
<!-- CSS Stylesheet-->
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap-themes.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" />

<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/style.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/receptionists.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/formhelpers.min.css"/>
<!-- Styleswitch if  you don't chang theme , you can delete -->
<link type="text/css" rel="alternate stylesheet" media="screen" title="style1" href="{{url()}}/assets/css/styleTheme1.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style2" href="{{url()}}/assets/css/styleTheme2.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style3" href="{{url()}}/assets/css/styleTheme3.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="{{url()}}/assets/css/styleTheme4.css" />
<link rel="stylesheet" type="text/css" href="{{url('assets/css/pnotify.core.css')}}"/>
{{ HTML::style('assets/css/oxygen/icons.css') }}
</head>

<body class="leftMenu nav-collapse">

<div id="wrapper">

    @include('hotel.partials.header')
	<div id="main">
		@yield('content')
	</div>
	@include('hotel.partials.menu_main')	
</div>
<!-- Jquery Library -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="{{url()}}/assets/js/jquery.ui.min.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url()}}/chefs/js/plugins/formhelpers.min.js"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="{{url()}}/assets/js/modernizr/modernizr.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/mmenu/jquery.mmenu.js"></script>
<script type="text/javascript" src="{{url()}}/assets/js/styleswitch.js"></script>
<!-- Library 10+ Form plugins-->
<script type="text/javascript" src="{{url()}}/assets/plugins/form/form.js"></script>
<!-- Datetime plugins  -->
<script type="text/javascript" src="{{url()}}/assets/plugins/datetime/datetime.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/moment/moment.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="{{url('assets/plugins/datable/jquery.dataTables.'.Helpers::lang().'.min 1.10.11.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/datable/dataTables.'.Helpers::lang().'.bootstrap.js')}}"></script>
 <!-- Library Chart-->
<script type="text/javascript" src="{{url()}}/assets/plugins/chart/chart.js"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="{{url()}}/assets/plugins/pluginsForBS/pluginsForBS.js"></script>
<!-- Library 10+ miscellaneous plugins -->
<script type="text/javascript" src="{{url()}}/assets/plugins/miscellaneous/miscellaneous.js"></script>
<!-- Library Themes Customize--> 
<script type="text/javascript" src="http://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="{{url('assets/js/pnotify.core.js')}}"></script>
<script src="{{url('assets/js/isotope.pkgd.min.js')}}"></script>
<script type="text/javascript">
	$(function() {		
	$('.change-lang').change(function(){
         $(this).parent().submit();
     });	 	
	 $('nav#menu').mmenu({
		searchfield   :  false,
		slidingSubmenus	: false
	}).on( "closing.mm", function(){
		setTimeout(function () { closeSub() }, 200);
		function closeSub(){
			var nav=$('nav#menu');
				nav.find("li").each(function(i) {
					$(this).removeClass("mm-opened");	
				});
		}
	});
	});
</script>
@yield('script')
</body>
</html>