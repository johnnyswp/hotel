<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta information -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- Title-->
<title>@yield('title') - {{Helpers::typeU()}} - Easy Room Service</title>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/dark-hive/jquery-ui.css">

<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url()}}/assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url()}}/assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url()}}/assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="{{url()}}/assets/ico/favicon.ico">
<link rel="shortcut icon" href="{{url()}}/assets/ico/favicom.ico">
<!-- CSS Stylesheet-->
{{ HTML::style('assets/css/oxygen/icons.css') }}
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap-themes.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/style.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/hotels.css" />
<link rel="stylesheet" type="text/css" href="{{url('assets/css/pnotify.core.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" />
<script type="text/javascript" src="{{url('assets/plugins/bootstrap-switch-master/dist/css/bootstrap2/bootstrap-switch.css')}}"></script>

<link type="text/css" rel="stylesheet" rel="stylesheet" href="{{url('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.css')}}">

<link type="text/css" rel="stylesheet" href="{{url('assets/css/style_typehead.css')}}" />


<!-- Styleswitch if  you don't chang theme , you can delete -->
<link type="text/css" rel="alternate stylesheet" media="screen" title="style1" href="{{url()}}/assets/css/styleTheme1.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style2" href="{{url()}}/assets/css/styleTheme2.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style3" href="{{url()}}/assets/css/styleTheme3.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="{{url()}}/assets/css/styleTheme4.css" />
</head>

<body class="leftMenu nav-collapse">

<div id="wrapper">
	@include('hotel.partials.header')
	<div id="main" style="margin-top: 55px;">
		@yield('content')
	</div>
	@include('hotel.partials.menu_main')	

</div>
<!-- Jquery Library -->
<script type="text/javascript" src="{{url('assets/js/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{url('assets/plugins/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/datePlagin/jquery-dateFormat.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/moment/locale.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/jquery-timeago/jquery.timeago.js')}}"></script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript" src="{{url('assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js')}}"></script>


<script type="text/javascript" src="{{url('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="{{url('assets/js/modernizr/modernizr.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/mmenu/jquery.mmenu.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/styleswitch.js')}}"></script>
<!-- Library 10+ Form plugins-->
<!-- Datetime plugins -->
<!-- Library Chart-->
<script type="text/javascript" src="{{url('assets/plugins/chart/chart.js')}}"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="{{url('assets/plugins/pluginsForBS/pluginsForBS.js')}}"></script>
<!-- Library 10+ miscellaneous plugins -->
<!-- Library 10+ Form plugins-->
<script src="{{url('assets/plugins/form/form.js')}}" type="text/javascript" ></script>

<script type="text/javascript" src="{{url('assets/plugins/miscellaneous/miscellaneous.js')}}"></script>
<!-- Library datable -->

<script type="text/javascript" src="{{url('assets/plugins/datable/jquery.dataTables.'.Helpers::lang().'.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/datable/dataTables.'.Helpers::lang().'.bootstrap.js')}}"></script>
<script type="text/javascript" src="http://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="{{url('assets/js/pnotify.core.js')}}"></script>
<script type='text/javascript'src="{{url('assets/js/timepicki.js')}}"></script>
<!-- Library Themes Customize--> 
@yield('script')
<script type="text/javascript">
$(function(){	
	$('.change-lang').change(function(){
            $(this).parent().submit();
        });
	//////////     OFF CANVAS MENU      //////////
	// Menu right
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
    @yield('js-script')
});
</script>
</body>
</html>