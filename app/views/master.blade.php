<?php use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta information -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- Title-->
<title>@yield('title') -</title>
<!-- Favicons -->
<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url()}}/assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url()}}/assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url()}}/assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="{{url()}}/assets/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="{{url()}}/assets/ico/favicom.ico">
<!-- CSS Stylesheet-->
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/bootstrap/bootstrap-themes.css" />
<link type="text/css" rel="stylesheet" href="{{url()}}/assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="{{url('assets/css/pnotify.core.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" />

<!-- Styleswitch if  you don't chang theme , you can delete -->
<link type="text/css" rel="alternate stylesheet" media="screen" title="style1" href="{{url()}}/assets/css/styleTheme1.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style2" href="{{url()}}/assets/css/styleTheme2.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style3" href="{{url()}}/assets/css/styleTheme3.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="{{url()}}/assets/css/styleTheme4.css" />

</head>


<body style="background: rgba(187, 167, 167, 0.25); margin-right: 227px;">
<div id="wrapper" style="background: transparent; margin-left: 0px; overflow: auto; overflow-x: hidden;">
	<div  style="background: transparent; margin-right: 300px; margin-left: 300px;">
        @yield('content')
	</div>
</div>

<!-- Jquery Library -->
<script type="text/javascript" src="{{url('assets/js/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{url('assets/plugins/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/datePlagin/jquery-dateFormat.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/moment/locale.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/moment/moment-timezone.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/jquery-timeago/jquery.timeago.js')}}"></script>

<script type="text/javascript" src="{{url('assets/js/jquery.ui.min.js')}}"></script>

<script type="text/javascript" src="{{url('assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>


<script type="text/javascript" src="{{url('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="{{url('assets/js/modernizr/modernizr.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/mmenu/jquery.mmenu.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/styleswitch.js')}}"></script>
<!-- Library 10+ Form plugins-->
<script type="text/javascript" src="{{url('assets/plugins/form/form.js')}}"></script>
<!-- Datetime plugins -->
<!-- Library Chart-->
<script type="text/javascript" src="{{url('assets/plugins/chart/chart.js')}}"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="{{url('assets/plugins/pluginsForBS/pluginsForBS.js')}}"></script>
<!-- Library 10+ miscellaneous plugins -->
<script type="text/javascript" src="{{url('assets/plugins/miscellaneous/miscellaneous.js')}}"></script>
<!-- Library datable -->
<script type="text/javascript" src="{{url()}}/chefs/js/plugins/bootstrap/bootstrap-select.js"></script> 
<script type="text/javascript" src="{{url('assets/plugins/datable/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/datable/dataTables.'.Helpers::lang().'.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/bootstrap-timepicker.js')}}"></script>
<script src="{{url('assets/js/pnotify.core.js')}}"></script>
<script type='text/javascript'src="{{url('assets/js/timepicki.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
        $('.change-lang').change(function(){
            $(this).parent().submit();
        });
        console.log(moment.tz.guess());
        $('#timezone').val(moment.tz.guess());
        $('.selectpicker').selectpicker();
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

        var toResize;
        $(window).resize(function(e) {
            clearTimeout(toResize);
            toResize = setTimeout(toCenter(), 500);
        });

        $('.timepicker').timepicker({
            minuteStep: 1,
            template: 'modal',
            appendWidgetTo: 'body',
            showSeconds: true,
            showMeridian: false,
            defaultTime: false
        });

        $('#birthday').datetimepicker({
            locale: '{{Helpers::lang()}}',
            format: 'DD-MM-YYYY',
            viewMode: 'years',
            defaultDate:false,
            maxDate: '{{Carbon::now()->subYears(18)->format("m-d-Y")}}'
        });

        $("#birthday").on("dp.hide", function (e) {
            fecha = moment($(this).val(), "DD-MM-YYYY").format("YYYY-MM-DD"); 
            $("#date").val(fecha);
        });

        //Canvas Loading
        var throbber = new Throbber({  size: 144, padding: 50,  strokewidth: 2.8,  lines: 12, rotationspeed: 0, fps: 15,color:'black'});
        throbber.appendTo(document.getElementById('load'));
        throbber.start();

		$('#validate-wizard').bootstrapWizard({
            tabClass:"nav-wizard",
            onNext: function(tab, navigation, index) {
                var content=$('#step'+index);
                if(typeof  content.attr("parsley-validate") != 'undefined'){
                    var $valid = content.parsley( 'validate' );
                    if(!$valid){
                        return false;
                    }
                };
            // Set the name for the next tab
            $('#step3 h3').find("span").html($('#fullname').val());
            $('#step3 p').find("b").html($('#email').val());
            },
            /*onTabClick: function(tab, navigation, index) {
                $.notific8('Please click <strong>next button</strong> to wizard next step!! ',{ life:5000, theme:"danger" ,heading:" Wizard Tip :); "});
                return false;
            },*/
            onTabShow: function(tab, navigation, index) {
                tab.prevAll().addClass('completed');
                tab.nextAll().removeClass('completed');
                if(tab.hasClass("active")){
                    tab.removeClass('completed');
                }
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#validate-wizard').find('.progress-bar').css({width:$percent+'%'});
                $('#validate-wizard').find('.wizard-status span').html($current+" / "+$total);
                
                toCenter();
                
                var main=$("#load");
                var mgs=$("#block-mgs");
                //scroll to top
                main.animate({
                    scrollTop: 0
                }, 500);
                if($percent==100){
                    setTimeout(function () { main.show() }, 100);
                    setTimeout(function () { main.hide() }, 2000);
                    setTimeout(function () { $('#validate-wizard').submit(); }, 2100);
                    
                }  
            }
        });		
	});
</script>
</body>
</html>