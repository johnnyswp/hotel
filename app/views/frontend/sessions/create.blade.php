<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta information -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- Title-->
<title>{{ trans('main.site') }} - {{ trans('main.login') }}</title>
<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url('assets/ico/apple-touch-icon-144-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url('assets/ico/apple-touch-icon-114-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url('assets/ico/apple-touch-icon-72-precomposed.png')}}">
<link rel="apple-touch-icon-precomposed" href="{{url('assets/ico/apple-touch-icon-57-precomposed.png')}}">
<link rel="shortcut icon" href="{{url('assets/ico/favicom.ico')}}">
<!-- CSS Stylesheet-->
<link type="text/css" rel="stylesheet" href="{{url('assets/css/bootstrap/bootstrap.min.css')}}" />
<link type="text/css" rel="stylesheet" href="{{url('assets/css/bootstrap/bootstrap-themes.css')}}" />
<link type="text/css" rel="stylesheet" href="{{url('assets/css/style.css')}}" />
<link type="text/css" rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" />

<!-- Styleswitch if  you don't chang theme , you can delete -->
<link type="text/css" rel="alternate stylesheet" media="screen" title="style1" href="{{url('assets/css/styleTheme1.css')}}" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style2" href="{{url('assets/css/styleTheme2.css')}}" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style3" href="{{url('assets/css/styleTheme3.css')}}" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="{{url('assets/css/styleTheme4.css')}}" />

</head>
<body class="full-lg">
<div id="wrapper">

	<div id="loading-top">
			<div id="canvas_loading"></div>
			<span>{{trans('main.checking')}}</span>
	</div>

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
             {{ Form::select('lang',Language::where('state',1)->lists('language', 'sufijo'), Helpers::lang(), array('class' =>'selectpicker form-control select change-lang')) }}
         {{ Form::close() }}
     </div>

	<div id="main">
		<div class="container">			
			<div class="col-lg-12">
				<div class="account-wall">
					<section class="align-lg-center">
						
					<div class="site-logo" style="  background-size: contain;"></div>
					 @if(Session::has('flash_message'))
                         <label class="label label-success">{{Session::get('flash_message')}}</label>
                     @endif
                     @if($errors->has())
				     <div class="alert-box alert">
				     	<!--recorremos los errores en un loop y los mostramos-->
				     	@foreach ($errors->all('<p style="  background-color: rgb(216, 47, 47); color: white;">:message</p>') as $message)
				     	{{ $message }}
				     	@endforeach
				     </div>
				     @endif
					</section>
					{{ Form::open(['route' => 'sessions.store','class'=>'form-signin','id'=>'form-signin']) }}
						 						
						<section>							
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								{{ Form::text('email', null, ['placeholder' => trans('main.email or username'), 'class' => 'form-control', 'required' => 'required'])}}
								{{ errors_for('email', $errors) }}
							</div>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-key"></i></div>
								{{ Form::password('password', ['placeholder' => trans('main.password'),'class' => 'form-control', 'required' => 'required'])}}
								{{ errors_for('password', $errors) }}
							</div>
							<button class="btn btn-lg btn-theme-inverse btn-block" type="submit" id="sign-in">{{trans('main.sign_in')}}</button>
						</section>
						<section class="clearfix">
							<div class="iCheck pull-left"  data-color="red">
								{{ Form::checkbox('remember', 'remember') }}
								{{ Form::label('remember', trans('main.remember_me'))}}
							</div>
							<a href="{{url('forgot_password')}}" class="pull-right help">{{trans('main.forget_password')}}</a>
						</section>
					{{ Form::close() }}
					<a href="#" class="footer-link">&copy; {{date('Y')}} <span>{{trans('main.title1')}}</span>{{trans('main.title2')}}<small> &trade; </a>
				</div>	
				<!-- //account-wall-->
				
			</div>
				<!-- //col-sm-6 col-md-4 col-md-offset-4-->
		</div>
		<!-- //row-->
	</div>
	<!-- //container-->
	
</div>
<!-- //main-->

		
</div>
<!-- //wrapper-->


<!--
////////////////////////////////////////////////////////////////////////
//////////     JAVASCRIPT  LIBRARY     //////////
/////////////////////////////////////////////////////////////////////
-->
		
<!-- Jquery Library -->
<script type="text/javascript" src="{{url('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/jquery.ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="{{url('assets/js/modernizr/modernizr.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/mmenu/jquery.mmenu.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/styleswitch.js')}}"></script>
<!-- Library 10+ Form plugins-->
<script type="text/javascript" src="{{url('assets/plugins/form/form.js')}}"></script>
<!-- Datetime plugins -->
<script type="text/javascript" src="{{url('assets/plugins/datetime/datetime.js')}}"></script>
<!-- Library Chart-->
<script type="text/javascript" src="{{url('assets/plugins/chart/chart.js')}}"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="{{url('assets/plugins/pluginsForBS/pluginsForBS.js')}}"></script>
<!-- Library 10+ miscellaneous plugins -->
<script type="text/javascript" src="{{url('assets/plugins/miscellaneous/miscellaneous.js')}}"></script>
<!-- Library Themes Customize-->
<script type="text/javascript" src="{{url('assets/js/caplet.custom.js')}}"></script>
<script type="text/javascript">
$(function() {
		   //Login animation to center 
            $('.change-lang').change(function(){
                $(this).parent().submit();
            });
			function toCenter(){
					var mainH=$("#main").outerHeight();
					var accountH=$(".account-wall").outerHeight();
					var marginT=(mainH-accountH)/2;
						   if(marginT>30){
							   $(".account-wall").css("margin-top",marginT-15);
							}else{
								$(".account-wall").css("margin-top",30);
							}
				}
				toCenter();
				var toResize;
				$(window).resize(function(e) {
					clearTimeout(toResize);
					toResize = setTimeout(toCenter(), 500);
				});
				
			//Canvas Loading
			  var throbber = new Throbber({  size: 32, padding: 17,  strokewidth: 2.8,  lines: 12, rotationspeed: 0, fps: 15 });
			  throbber.appendTo(document.getElementById('canvas_loading'));
			  throbber.start();
			  
			 
	
			
			$("#form-signin").submit(function(event){
					event.preventDefault();
					var main=$("#main");
					//scroll to top
							
					
					// send username and password to php check login
					$.ajax({
						url: "{{route('sessions.store')}}", 
						data: $(this).serialize(), 
						type: "POST",
						beforeSend: function(resp){
		                   	main.animate({
								scrollTop: 0
							}, 500);
							main.addClass("slideDown");                      
		                },
		                complete: function(resp){
		                     
		                },						
						success: function (data) {
							 
							if(data.success){
								 setTimeout(function () { $("#loading-top span").text(data.mgs) }, 500);
								 setTimeout( "window.location.href='"+data.url+"'", 1500 );
							}else{
								setTimeout(function () { $("#loading-top span").text(data.mgs)  }, 800);
								setTimeout(function () {  main.removeClass("slideDown"); }, 1000);								 								 
								setTimeout(function () {
									$.notific8("{{trans('main.mgs_invalid_credential')}}",{ 
									 	life:5000,
									 	horizontalEdge:"bottom", 
									 	theme:"danger" ,
									 	heading:" ERROR :); "
									});
									return false;	
								}, 1200);								 
							}
							
						}
					});				
			});
	});
</script>
</body>
</html>