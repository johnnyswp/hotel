$(function(){
    function resizeTask () {
        $(window).resize(function() {
            $('#tasks_scheduled').height($(window).height() - 170);
            $("#tasks_scheduled").getNiceScroll().resize();
        });
        $(window).trigger('resize');
    }

    $('.show_item').on('click', function(event) {
        event.preventDefault();
        $id = $(this).attr('cod');
        $( "#task-accordion-"+$id ).slideToggle( "linear", function() {
            console.log('Click '+$id);
        });
    });

    $('.next-board').on('click', function(event) {
        event.preventDefault();
        var code = $(this).attr('code');
        var delivery = $(this).attr('delivery');
        var preparation = $(this).attr('preparation');
        $.ajax({
            type: 'GET',
            url: 'chef/change-state',
            data: {id:code},
            success: function (data){
                if(data.state=="just_now"){
                    $('.item-'+code).attr('state', "just_now");
                    $('.item-'+code).appendTo('#tasks_progreess');
                    $('.item-'+code).addClass("task-scheduled");
                    var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                    var b = moment();
                    var time2 = pt.diff(b);

                    var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                    $('#btn-state-'+code).html(html);
        
        
                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'none');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
        
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time2);
                    }
                }else if(data.state=="ready"){
                    var html = "<span class='btn btn-danger btn-xs state'>A preparacion</span>";
                    $('#btn-state-'+code).html(html);
        
        
                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'none');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
        
                    $('.item-'+code).attr('state', "ready");
                    $('.item-'+code).appendTo('#tasks_preparing');
                    $('.item-'+code).addClass("task-scheduled");
                    var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss');
                    var b = moment();
                    var time2 = pt.diff(b);
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time2);
                    }
                }else if(data.state=="delivered"){
                    $('.item-'+code).attr('state', "delivered");
                    $('.item-'+code).removeClass("task-scheduled");
                    $('.item-'+code).removeClass("task-progreess");
                    $('.item-'+code).appendTo('#tasks_completed');

                    var html = "<span class='btn btn-info btn-xs state'>Entregado</span>";
                    $('#btn-state-'+code).html(html);
        
        
                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'none');
                }else if(data.state=="finalized"){
                    $('.item-'+code).remove();
                }
            }
        });
        console.log('movido'+code);
    });

    $('.btn-chage').on('click', function(event) {
        event.preventDefault();
        var code = $(this).attr('code');
        var st = $(this).attr('state');

        var delivery = $(this).attr('delivery');
        var preparation = $(this).attr('preparation');
        var state = $('.item-'+code).attr('state');
        if(st=="programmed"){
            $('.item-'+code).appendTo('#tasks_scheduled');
            $('.item-'+code).removeClass("task-scheduled");
            $('.item-'+code).removeClass("task-progreess");
    
            if(state=='just_now'){
                var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                var b = moment();
                console.log(a)
                var time = a.diff(b);
                var time2 = pt.diff(b);
    
                if(time<=0){
                    $('.item-'+code).appendTo('#tasks_progreess');
                    $('.item-'+code).addClass("task-scheduled");
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time2);
                    }
                }else{
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:'programmed'},
                        success: function (data) {
                            return true;
                        }
                    });
                    var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                    $('#btn-state-'+code).html(html);
    
                     
                    $('#btns-states-'+code+' .programmed').css('display', 'none');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
                    
                    $('.item-'+code).attr('state','programmed');
                    setTimeout(function(){
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        var time2 = pt.diff(b);
                        $('.item-'+code).appendTo('#tasks_progreess');
                        $('.item-'+code).addClass("task-scheduled");
                        $.ajax({
                            type: 'GET',
                            url: 'chef/change-state2',
                            data: {id:code, state:state},
                            success: function (data) {
                                return true;
                            }
                        });
                        var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                        $('#btn-state-'+code).html(html);
        
                         
                        $('#btns-states-'+code+' .programmed').css('display', 'block');
                        $('#btns-states-'+code+' .just_now').css('display', 'node');
                        $('#btns-states-'+code+' .ready').css('display', 'block');
                        $('#btns-states-'+code+' .delivered').css('display', 'block');

                        setTimeout(function(){
                            $('.item-'+code).addClass("task-progreess");
                            $('.item-'+code).removeClass("task-scheduled");
                         },
                         time2);
                       console.log('.item-'+code);
                    },
                    time);
                }
            }else if(state=='ready'){
                var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                var b = moment();
                var time = a.diff(b);
                var time2 = pt.diff(b);
                if(time<=0){
                    $('.item-'+code).appendTo('#tasks_preparing');
                    $('.item-'+code).addClass("task-scheduled");
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:'ready'},
                        success: function (data) {
                            return true;
                        }
                    });
                    
                    $('.item-'+code).attr('state','ready');
                    var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss');
                    var b = moment();
                    var time2 = pt.diff(b);
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time2);
                    }
                }else{
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:'programmed'},
                        success: function (data) {
                            return true;
                        }
                    });
                    var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                    $('#btn-state-'+code).html(html);
    
                     
                    $('#btns-states-'+code+' .programmed').css('display', 'none');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
                    
                    $('.item-'+code).attr('state','programmed');
                    setTimeout(function(){
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        var time2 = pt.diff(b);
                        $('.item-'+code).appendTo('#tasks_progreess');
                        $('.item-'+code).addClass("task-scheduled");
                            $.ajax({
                            type: 'GET',
                            url: 'chef/change-state2',
                            data: {id:code, state:state},
                            success: function (data) {
                                return true;
                            }
                        });
                        var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                        $('#btn-state-'+code).html(html);
        
                         
                        $('#btns-states-'+code+' .programmed').css('display', 'block');
                        $('#btns-states-'+code+' .just_now').css('display', 'node');
                        $('#btns-states-'+code+' .ready').css('display', 'block');
                        $('#btns-states-'+code+' .delivered').css('display', 'block');
                        setTimeout(function(){
                            $('.item-'+code).addClass("task-progreess");
                            $('.item-'+code).removeClass("task-scheduled");
                         },
                         time2);
                       console.log('.item-'+code);
                    },
                    time);
                } 
            }else if(state=='delivered'){
                var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                var b = moment();
                var time = a.diff(b);
                var time2 = pt.diff(b);
                console.log(preparation);
                console.log(b);
                console.log(a);
                console.log(time);
                if(time<=0){
                    $('.item-'+code).appendTo('#tasks_completed');
                    $('.item-'+code).removeClass("task-scheduled");
                    $('.item-'+code).removeClass("task-progreess");
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:state},
                        success: function (data) {
                            return true;
                        }
                    });
                }else{
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:'programmed'},
                        success: function (data) {
                            return true;
                        }
                    });
                    var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                    $('#btn-state-'+code).html(html);
    
                     
                    $('#btns-states-'+code+' .programmed').css('display', 'none');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');
                    
                    $('.item-'+code).attr('state','programmed');
                    setTimeout(function(){
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        var time2 = pt.diff(b);
                        $('.item-'+code).appendTo('#tasks_progreess');
                        $('.item-'+code).addClass("task-scheduled");
                            $.ajax({
                            type: 'GET',
                            url: 'chef/change-state2',
                            data: {id:code, state:'just_now'},
                            success: function (data) {
                                return true;
                            }
                        });
                        var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                        $('#btn-state-'+code).html(html);
        
                         
                        $('#btns-states-'+code+' .programmed').css('display', 'block');
                        $('#btns-states-'+code+' .just_now').css('display', 'node');
                        $('#btns-states-'+code+' .ready').css('display', 'block');
                        $('#btns-states-'+code+' .delivered').css('display', 'block');
                        setTimeout(function(){
                            $('.item-'+code).addClass("task-progreess");
                            $('.item-'+code).removeClass("task-scheduled");
                         },
                         time2);
                       console.log('.item-'+code);
                    },
                    time);
                } 
            }
        }else if(st=="just_now"){
            $.ajax({
                type: 'GET',
                url: 'chef/change-state2',
                data: {id:code, state:'just_now'},
                success: function (data) {
                    return true;
                }
            });

            $('.item-'+code).attr('state', "just_now");
            $('.item-'+code).appendTo('#tasks_progreess');
            $('.item-'+code).addClass("task-scheduled");
            var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
            var b = moment();
            var time2 = pt.diff(b);
            var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
            $('#btn-state-'+code).html(html);


            $('#btns-states-'+code+' .programmed').css('display', 'block');
            $('#btns-states-'+code+' .just_now').css('display', 'none');
            $('#btns-states-'+code+' .ready').css('display', 'block');
            $('#btns-states-'+code+' .delivered').css('display', 'block');

            if(time2<=0){
                $('.item-'+code).addClass("task-progreess");
                $('.item-'+code).removeClass("task-scheduled");
            }else{
                setTimeout(function(){
                   $('.item-'+code).addClass("task-progreess");
                   $('.item-'+code).removeClass("task-scheduled");
                },
                time2);
            }
        }else if(st=="ready"){
            $.ajax({
                type: 'GET',
                url: 'chef/change-state2',
                data: {id:code, state:'ready'},
                success: function (data) {
                    return true;
                }
            });

            var html = "<span class='btn btn-danger btn-xs state'>A preparacion</span>";
            $('#btn-state-'+code).html(html);


            $('#btns-states-'+code+' .programmed').css('display', 'block');
            $('#btns-states-'+code+' .just_now').css('display', 'block');
            $('#btns-states-'+code+' .ready').css('display', 'none');
            $('#btns-states-'+code+' .delivered').css('display', 'block');

            $('.item-'+code).attr('state', "ready");
            $('.item-'+code).appendTo('#tasks_preparing');
            $('.item-'+code).addClass("task-scheduled");
            var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss');
            var b = moment();
            var time2 = pt.diff(b);
            if(time2<=0){
                $('.item-'+code).addClass("task-progreess");
                $('.item-'+code).removeClass("task-scheduled");
            }else{
                setTimeout(function(){
                   $('.item-'+code).addClass("task-progreess");
                   $('.item-'+code).removeClass("task-scheduled");
                },
                time2);
            }
        }else if(st=="delivered"){
            $.ajax({
                type: 'GET',
                url: 'chef/change-state2',
                data: {id:code, state:'delivered'},
                success: function (data) {
                    return true;
                }
            });
            $('.item-'+code).attr('state', "delivered");
            $('.item-'+code).removeClass("task-scheduled");
            $('.item-'+code).removeClass("task-progreess");
            $('.item-'+code).appendTo('#tasks_completed');

            var html = "<span class='btn btn-info btn-xs state'>Entregado</span>";
            $('#btn-state-'+code).html(html);


            $('#btns-states-'+code+' .programmed').css('display', 'block');
            $('#btns-states-'+code+' .just_now').css('display', 'block');
            $('#btns-states-'+code+' .ready').css('display', 'block');
            $('#btns-states-'+code+' .delivered').css('display', 'none');
        }  
    });

    $('#md-add-event').on('hidden.bs.modal', function (e) {
        $('.modal-backdrop').removeClass('in').addClass('out');
    })

    $("time.timeago").timeago();
    $('.clock_finish').each(function(index, val) {
        var dateF = $(this).attr('date');
        var $el = $(this);
         
        $el.countdown(dateF, function(event) {
            $(this).html(event.strftime('%D days %H:%M:%S'));
        }).on('update.countdown', function(event) {
            var format = '%H:%M:%S';
            if(event.offset.days > 0) {
              format = '%-d day%!d ' + format;
            }
            if(event.offset.weeks > 0) {
              format = '%-w week%!w ' + format;
            }            
            $(this).html(event.strftime(format));
            
            var minutes = event.offset.minutes;
            
            var seconds = event.offset.seconds;
                if(minutes <= 4 && seconds <= 59 ){
                    console.log('menor 4 minutos y  de 50 segundos')
                }
        });
        console.log(dateF);
    });

    var tasks = function(){
        
        $("#add_new_task").on("click",function(){
            var nt = $("#new_task").val();
            if(nt != ''){
                
                var task = '<div class="task-item task-primary">'
                                +'<div class="task-text">'+nt+'</div>'
                                +'<div class="task-footer">'
                                    +'<div class="pull-left"><span class="fa fa-clock-o"></span> now</div>'
                                +'</div>'
                            +'</div>';
                    
                $("#tasks_scheduled").prepend(task);
            }            
        });
        
        $("#tasks_scheduled,#tasks_progreess,#tasks_preparing,#tasks_completed").sortable({
            
            items: "> .task-item",

            connectWith: "#tasks_scheduled,#tasks_progreess,#tasks_preparing,#tasks_completed",

            handle: ".task-text", 

            placeholder: "task-placeholder",

            receive: function(event, ui) {
                if(this.id == "tasks_scheduled"){
                    ui.item.removeClass("task-scheduled");
                    ui.item.removeClass("task-progreess");

                    var code = ui.item.context.id;
                    var state = $('.item-'+code).attr('state');
                    var delivery = $('.item-'+code).attr('delivery');
                    var preparation = $('.item-'+code).attr('preparation');

                    if(state=='just_now'){
                        var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        console.log(a)
                        var time = a.diff(b);
                        var time2 = pt.diff(b);

                        if(time<=0){
                            $('.item-'+code).appendTo('#tasks_progreess');
                            $('.item-'+code).addClass("task-scheduled");
                            if(time2<=0){
                                $('.item-'+code).addClass("task-progreess");
                                $('.item-'+code).removeClass("task-scheduled");
                            }else{
                                setTimeout(function(){
                                   $('.item-'+code).addClass("task-progreess");
                                   $('.item-'+code).removeClass("task-scheduled");
                                },
                                time2);
                            }
                        }else{
                            $.ajax({
                                type: 'GET',
                                url: 'chef/change-state2',
                                data: {id:code, state:'programmed'},
                                success: function (data) {
                                    return true;
                                }
                            });
                            var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                            $('#btn-state-'+code).html(html);
                            
                            $('#btns-states-'+code+' .programmed').css('display', 'none');
                            $('#btns-states-'+code+' .just_now').css('display', 'block');
                            $('#btns-states-'+code+' .ready').css('display', 'block');
                            $('#btns-states-'+code+' .delivered').css('display', 'block');
                            $('.item-'+code).attr('state','programmed');
                            setTimeout(function(){
                                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                                var b = moment();
                                var time2 = pt.diff(b);
                                $('.item-'+code).appendTo('#tasks_progreess');
                                $('.item-'+code).addClass("task-scheduled");
                                    $.ajax({
                                    type: 'GET',
                                    url: 'chef/change-state2',
                                    data: {id:code, state:state},
                                    success: function (data) {
                                        return true;
                                    }
                                });
                                var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                                $('#btn-state-'+code).html(html);
        
        
                                $('#btns-states-'+code+' .programmed').css('display', 'block');
                                $('#btns-states-'+code+' .just_now').css('display', 'none');
                                $('#btns-states-'+code+' .ready').css('display', 'block');
                                $('#btns-states-'+code+' .delivered').css('display', 'block');
                                setTimeout(function(){
                                    $('.item-'+code).addClass("task-progreess");
                                    $('.item-'+code).removeClass("task-scheduled");
                                 },
                                 time2);
                               console.log('.item-'+code);
                            },
                            time);
                        }
                    }else if(state=='ready'){
                        var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        var time = a.diff(b);
                        var time2 = pt.diff(b);
                        if(time<=0){
                            $('.item-'+code).appendTo('#tasks_preparing');
                            $('.item-'+code).addClass("task-scheduled");
                            $.ajax({
                                type: 'GET',
                                url: 'chef/change-state2',
                                data: {id:code, state:'ready'},
                                success: function (data) {
                                    return true;
                                }
                            });
                            $('.item-'+code).attr('state','ready');
                            var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss');
                            var b = moment();
                            var time2 = pt.diff(b);
                            if(time2<=0){
                                $('.item-'+code).addClass("task-progreess");
                                $('.item-'+code).removeClass("task-scheduled");
                            }else{
                                setTimeout(function(){
                                   $('.item-'+code).addClass("task-progreess");
                                   $('.item-'+code).removeClass("task-scheduled");
                                },
                                time2);
                            }
                        }else{
                            $.ajax({
                                type: 'GET',
                                url: 'chef/change-state2',
                                data: {id:code, state:'programmed'},
                                success: function (data) {
                                    return true;
                                }
                            });
                            var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                            $('#btn-state-'+code).html(html);

                             
                            $('#btns-states-'+code+' .programmed').css('display', 'none');
                            $('#btns-states-'+code+' .just_now').css('display', 'block');
                            $('#btns-states-'+code+' .ready').css('display', 'block');
                            $('#btns-states-'+code+' .delivered').css('display', 'block');
                            $('.item-'+code).attr('state','programmed');
                            setTimeout(function(){
                                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                                var b = moment();
                                var time2 = pt.diff(b);
                                $('.item-'+code).appendTo('#tasks_progreess');
                                $('.item-'+code).addClass("task-scheduled");
                                    $.ajax({
                                    type: 'GET',
                                    url: 'chef/change-state2',
                                    data: {id:code, state:state},
                                    success: function (data) {
                                        return true;
                                    }
                                });
                                var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                                $('#btn-state-'+code).html(html);
        
        
                                $('#btns-states-'+code+' .programmed').css('display', 'block');
                                $('#btns-states-'+code+' .just_now').css('display', 'none');
                                $('#btns-states-'+code+' .ready').css('display', 'block');
                                $('#btns-states-'+code+' .delivered').css('display', 'block');
                                setTimeout(function(){
                                    $('.item-'+code).addClass("task-progreess");
                                    $('.item-'+code).removeClass("task-scheduled");
                                 },
                                 time2);
                               console.log('.item-'+code);
                            },
                            time);
                        } 
                    }else if(state=='delivered'){
                        var a = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation)+5, 'm');
                        var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                        var b = moment();
                        var time = a.diff(b);
                        var time2 = pt.diff(b);
                        console.log(preparation);
                        console.log(b);
                        console.log(a);
                        console.log(time);
                        if(time<=0){
                            $('.item-'+code).appendTo('#tasks_completed');
                            $('.item-'+code).removeClass("task-scheduled");
                            $('.item-'+code).removeClass("task-progreess");
                            $.ajax({
                                type: 'GET',
                                url: 'chef/change-state2',
                                data: {id:code, state:state},
                                success: function (data) {
                                    return true;
                                }
                            });
                        }else{
                            $.ajax({
                                type: 'GET',
                                url: 'chef/change-state2',
                                data: {id:code, state:'programmed'},
                                success: function (data) {
                                    return true;
                                }
                            });
                            var html = "<span class='btn btn-success btn-xs state'> Programado </span>";
                            $('#btn-state-'+code).html(html);

                            $('#btns-states-'+code+' .programmed').css('display', 'none');
                            $('#btns-states-'+code+' .just_now').css('display', 'block');
                            $('#btns-states-'+code+' .ready').css('display', 'block');
                            $('#btns-states-'+code+' .delivered').css('display', 'block');
                            $('.item-'+code).attr('state','programmed');
                            setTimeout(function(){
                                var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                                var b = moment();
                                var time2 = pt.diff(b);
                                $('.item-'+code).appendTo('#tasks_progreess');
                                $('.item-'+code).addClass("task-scheduled");
                                    $.ajax({
                                    type: 'GET',
                                    url: 'chef/change-state2',
                                    data: {id:code, state:'just_now'},
                                    success: function (data) {
                                        return true;
                                    }
                                });
                                var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                                $('#btn-state-'+code).html(html);
        
        
                                $('#btns-states-'+code+' .programmed').css('display', 'block');
                                $('#btns-states-'+code+' .just_now').css('display', 'none');
                                $('#btns-states-'+code+' .ready').css('display', 'block');
                                $('#btns-states-'+code+' .delivered').css('display', 'block');
                                setTimeout(function(){
                                    $('.item-'+code).addClass("task-progreess");
                                    $('.item-'+code).removeClass("task-scheduled");
                                 },
                                 time2);
                               console.log('.item-'+code);
                            },
                            time);
                        } 
                    }
                }

                if(this.id == "tasks_progreess"){
                    var code = ui.item.context.id;
                    var delivery = $('.item-'+code).attr('delivery');
                    var preparation = $('.item-'+code).attr('preparation');
                    var state = 'just_now';
                    $('.item-'+code).attr('state','just_now');
                    $('.item-'+code).addClass("task-scheduled");
                    $('.item-'+code).removeClass("task-progreess");
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:state},
                        success: function (data) {
                            if(data.success==true)
                                console.log(ui.item.context.id+" - "+data.state);
                        }
                    });

                    var html = "<span class='btn btn-warning btn-xs state'>A preparar</span>";
                    $('#btn-state-'+code).html(html);
        
        
                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'none');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');

                    var pt = moment(delivery, 'YYYY-MM-DD HH:mm:ss').subtract(parseInt(preparation), 'm');
                    var b = moment();
                    var time2 = pt.diff(b);
                    if(time2<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                        console.log('a preparar');
                    }else{
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                           console.log('.item-'+code);
                        },
                        time2);
                    }
                } 

                if(this.id == "tasks_preparing"){
                    var code = ui.item.context.id;
                    var state = 'ready';
                    $('.item-'+code).attr('state','ready');
                    $('.item-'+code).addClass("task-scheduled");
                    $('.item-'+code).removeClass("task-progreess");
                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:state},
                        success: function (data) {
                            if(data.success==true)
                                console.log(ui.item.context.id+" m "+data.state);
                        }
                    });
                    var html = "<span class='btn btn-danger btn-xs state'>A preparacion</span>";
                    $('#btn-state-'+code).html(html);


                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'none');
                    $('#btns-states-'+code+' .delivered').css('display', 'block');

                    var delivery = $('.item-'+code).attr('delivery');
                    var pt = moment(delivery);
                    var b = moment();
                    var time = pt.diff(b);
                    if(time<=0){
                        $('.item-'+code).addClass("task-progreess");
                        $('.item-'+code).removeClass("task-scheduled");
                    }else{
                        $('.item-'+code).addClass("task-scheduled");
                        setTimeout(function(){
                           $('.item-'+code).addClass("task-progreess");
                           $('.item-'+code).removeClass("task-scheduled");
                        },
                        time);
                    }
                }

                if(this.id == "tasks_completed"){
                    var code = ui.item.context.id;
                    $('.item-'+code).removeClass("task-progreess");
                    $('.item-'+code).removeClass("task-scheduled");
                    var state = 'delivered';
                    $('.item-'+code).attr('state','delivered');
                    
                    var html = "<span class='btn btn-info btn-xs state'>Entregado</span>";
                    $('#btn-state-'+code).html(html);


                    $('#btns-states-'+code+' .programmed').css('display', 'block');
                    $('#btns-states-'+code+' .just_now').css('display', 'block');
                    $('#btns-states-'+code+' .ready').css('display', 'block');
                    $('#btns-states-'+code+' .delivered').css('display', 'none');

                    $.ajax({
                        type: 'GET',
                        url: 'chef/change-state2',
                        data: {id:code, state:state},
                        success: function (data) {
                            if(data.success==true)
                                console.log(ui.item.context.id+" - "+data.state);
                        }
                    }); 
                }

                page_content_onresize();
            }
        }).disableSelection();        
    }();
    //$("#tasks_scheduled").mCustomScrollbar({axis:"y", autoHideScrollbar: true, scrollInertia: 20, advanced: {autoScrollOnFocus: false}});
    $('#tasks_scheduled').height($(window).height() - 170);        

    $("#tasks_scheduled").niceScroll({cursorwidth:"10px"});
    $("body").niceScroll({cursorwidth:"10px"});
    
    resizeTask();
});
