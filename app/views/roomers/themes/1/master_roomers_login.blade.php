<?php use Carbon\Carbon;?>
<!DOCTYPE html>
<html>
<head>
	<title>@yield('title') - Easy Room Service</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--Import materialize.css {{$hotel->limit_time}} -->
	<?php
		$a = explode(":",$hotel->limit_time);
		$hour= $a[0];
		$min= $a[1];
	?>
	

	<link type="text/css" rel="stylesheet" href="{{ asset('roomers/plugins/materialize/css/materialize.css') }}"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="{{ asset('roomers/css/style.css') }}"  media="all"/>
	<link type="text/css" rel="stylesheet" href="{{ asset('roomers/css/theme_1.css') }}"  media="all"/>
	<link type="text/css" rel="stylesheet" href="{{ asset('roomers/plugins/pickadate/lib/compressed/themes/default.date.css')}}"  media="all"/>
	<link type="text/css" rel="stylesheet" href="{{ asset('roomers/plugins/pickadate/lib/compressed/themes/default.time.css')}}"  media="all"/>
	<script type="text/javascript" src="{{ asset('roomers/plugins/jquery/jquery-2.1.1.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/materialize/js/bin/materialize.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/nicescroll/jquery.nicescroll.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/legacy.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/picker.date.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/picker.time.js')}}"></script>

	<script type="text/javascript" src="{{ asset('roomers/plugins/nicescroll/jquery.nicescroll.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/plugins/moment/moment.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/plugins/store/store.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('roomers/js/roomers.js')}}"></script>

	<script type="text/javascript">
		if(window.location.pathname=="/roomer"){
			window.onbeforeunload = function(e) {
			  return '{{trans("main.mensaj_roomer_inicio")}}';
			};			
			
		}

		if(window.location.hash=="#mgs"){
			Materialize.toast("{{$lang->txt_message_pedido_ok}}",3000);
		}
		
		 
			var a =  window.location.search;
			var url = window.location.origin+""+window.location.pathname;			
			var b =  a.split("?");
			var search=window.location.search;
			var type = store.get('item_type');
			if(type=='inmediato')
        	{
        		if(search!="?lang=1" || search!="?dt=&a=1"){
        			if(b[0]!=""){
						window.location.href=url;
					}
        		}
				
			}
	</script>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
	@yield('link')
	@yield('style')
</head>

<body class="">
	<div class="row">@yield("container")</div>
	@yield("script")
	<script type="text/javascript" charset="utf-8" async defer>
		(function($){
			$(function(){
				$('select').material_select();
				$("body").niceScroll({
					cursorcolor:"#fb0000", 
					cursorborder:"1px solid #fb0000", 
					cursorborderradius:"0px",
					zindex :9999999999,
					scrollspeed :70,
					cursorwidth:"9px"});
				 

				@yield("jquery")
				$('#lang').on('change', function(event) {
					event.preventDefault();
					/* Act on the event */
					window.onbeforeunload = false;
					window.location.href="{{url('roomers/lang/')}}/"+$(this).val();
				});
				$('.modal-trigger').leanModal();
			});
		})(jQuery);
	</script>
	<script  type="text/javascript" charset="utf-8">
		var $time = $('#qwe').pickatime({
			interval:10,
			min:true,
			onSet: function(context) {
				$('#box_w').show();
				var picker = $time.pickatime('picker');
				picker.close();					
				$('#okC').attr('time',moment('12/01/2016 '+$('#qwe').val()).format('H:m:ss')); 
				
				//Arreglar esto
				console.log($('#okC').attr('time'));
				if($('#okC').attr('time')!='0:0:00')
				{
					var t = "programado";
				store.set('item_type',t);
				store.set('item_type_date',$('#okC').attr('date')+" "+$('#okC').attr('time'));  
					window.onbeforeunload = false;
					$.post(shopcar.url+'/roomer/key', {key: $('#okC').attr('date')+" "+$('#okC').attr('time')}, function(data, textStatus, xhr) {
						window.location.href= '/roomer/catalog?dt='+data;
					});
				}
			}
		});


		

		$('#bt_pi').on('click',function(event) {
			event.preventDefault();
			var t = "inmediato";
			store.set('item_type',t);
			window.onbeforeunload = false;
			window.location.href= '/roomer/catalog';
		});

		$('#okC').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
			if( $('this').attr('date')=="0" || $('this').val('time')=="0" ){
				return alert("Ok");
			}else{
				var da=$('this').attr('date')+" "+$('this').attr('time');
				var kl;
				store.set('item_type_date',$('this').attr('date')+" "+$('this').attr('time')); 
				$.post(shopcar.url+'/roomer/key', {key: da}, function(data, textStatus, xhr) {
					/*optional stuff to do after success */
					window.onbeforeunload = false;	
					window.location.href= '/roomer/catalog?dt='+data;
				});
				

			}
		});
	</script>  

</body>
</html>