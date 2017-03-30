    function resizeTask () {
        $(window).resize(function() {
            $('#tasks_scheduled').height($(window).height() - 170);
            $("#tasks_scheduled").getNiceScroll().resize();
        });
        $(window).trigger('resize');
    }

    $('.show_item_'+data.id).on('click', function(event) {
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

    var code = data.id;
    var state = data.state;
    var delivery = data.delivery_time;
    var preparation = data.preparation_time;
    $('.item-'+code).removeClass("task-scheduled");
    $('.item-'+code).removeClass("task-progreess");

	var a = moment(delivery).subtract(parseInt(preparation)+5, 'm');
	var pt = moment(delivery).subtract(parseInt(preparation), 'm');
    var b = moment();
    var time = a.diff(b);
    var time2 = pt.diff(b);
    if(time<=0){
    	$('.item-'+code).appendTo('#tasks_progreess');
        $('.item-'+code).addClass("task-scheduled");
        var state = "just_now";
        console.log(code);
        $.ajax({
            type: 'GET',
            url: 'chef/change-state2',
            data: {id:code, state:state},
            success: function (data) {
                return true;
            }
        });

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
    	setTimeout(function(){
	        var pt = moment(delivery).subtract(parseInt(preparation), 'm');
            var b = moment();
            var time2 = pt.diff(b);
    	    $('.item-'+code).appendTo('#tasks_progreess');
            $('.item-'+code).addClass("task-scheduled");
            var state = 'just_now';
            $.ajax({
                type: 'GET',
                url: 'chef/change-state2',
                data: {id:code, state:state},
                success: function (data) {
                    return true;
                }
            });
            setTimeout(function(){
                $('.item-'+code).addClass("task-progreess");
                $('.item-'+code).removeClass("task-scheduled");
             },
             time2);
        },
        time);
    }
    

    +function ($) {
     
       'use strict';
     
     
       /* NUMBER CLASS DEFINITION
        * ====================== */
     
       var BFHNumber = function (element, options) {
         this.options = $.extend({}, $.fn.bfhnumber.defaults, options);
         this.$element = $(element);
     
         this.initInput();
       };
     
       BFHNumber.prototype = {
     
         constructor: BFHNumber,
     
         initInput: function() {
           var value;
           
           if (this.options.buttons === true) {
             this.$element.wrap('<div class="input-group"></div>');
             this.$element.parent().append('<span class="input-group-addon bfh-number-btn inc"><span class="glyphicon glyphicon-plus     "></span></span>');
             this.$element.parent().append('<span class="input-group-addon bfh-number-btn dec"><span class="glyphicon glyphicon-     minus"></span></span>');
           }
           
           this.$element.on('change.bfhnumber.data-api', BFHNumber.prototype.change);
             
           if (this.options.keyboard === true) {
             this.$element.on('keydown.bfhnumber.data-api', BFHNumber.prototype.keydown);
           }
           
           if (this.options.buttons === true) {
             this.$element.parent()
               .on('mousedown.bfhnumber.data-api', '.inc', BFHNumber.prototype.btninc)
               .on('mousedown.bfhnumber.data-api', '.dec', BFHNumber.prototype.btndec);
           }
           
           this.formatNumber();
         },
         
         keydown: function(e) {
           var $this;
           $this = $(this).data('bfhnumber');
           
           if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
             return true;
           }
           console.log('keydown');
           switch (e.which) {
             case 38:
               $this.increment();
               break;
             case 40:
               $this.decrement();
               break;
             default:
           }
           
           return true;
         },
         
         mouseup: function(e) {
           console.log('mouseup');
           var $this,
               timer,
               interval;
           
           $this = e.data.btn;
           timer = $this.$element.data('timer');
           interval = $this.$element.data('interval');
           
           clearTimeout(timer);
           clearInterval(interval);
         },
         
         btninc: function() {
           var $this,
               timer;
           
           $this = $(this).parent().find('.bfh-number').data('bfhnumber');
           
           if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
             return true;
           }
           
           $this.increment();
           
           timer = setTimeout(function() {
             var interval;
             interval = setInterval(function() {
               $this.increment();
             }, 80);
             $this.$element.data('interval', interval);
           }, 750);
           $this.$element.data('timer', timer);
           
           $(document).one('mouseup', {btn: $this}, BFHNumber.prototype.mouseup);
           
           return true;
         },
         
         btndec: function() {
           console.log('btndec');
           var $this,
               timer;
           
           $this = $(this).parent().find('.bfh-number').data('bfhnumber');
           
           if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
             return true;
           }
           
           $this.decrement();
           
           timer = setTimeout(function() {
             var interval;
             interval = setInterval(function() {
               $this.decrement();
             }, 80);
             $this.$element.data('interval', interval);
           }, 750);
           $this.$element.data('timer', timer);
           
           $(document).one('mouseup', {btn: $this}, BFHNumber.prototype.mouseup);
           
           return true;
         },
         change: function() {
           var $this;
     
           $this = $(this).data('bfhnumber');
     
           if ($this.$element.is('.disabled') || $this.$element.attr('disabled') !== undefined) {
             return true;
           }
     
           $this.formatNumber();
     
           var value = $this.getValue();
           var code = $this.$element.attr('code');
           $.ajax({
               type: 'GET',
               url: 'chef/edit-item',
               data: {id:code, value:value},
               success: function (data) {
                   console.log(value+" - "+code);
               }
           });
           return true;
         },
         increment: function() {
           var value = this.getValue() + 1;
           var code = this.$element.attr('code');
           $.ajax({
               type: 'GET',
               url: 'chef/edit-item',
               data: {id:code, value:value},
               success: function (data) {
                   console.log(value+" - "+code);
               }
           });
           this.$element.val(value).change();
         },
         
         decrement: function() {
           var value = this.getValue() - 1;
           var code = this.$element.attr('code');
           $.ajax({
               type: 'GET',
               url: 'chef/edit-item',
               data: {id:code, value:value},
               success: function (data) {
                   console.log(value+" - "+code);
               }
           });
           this.$element.val(value).change();
         },
         
         getValue: function() {
           var value;
           
           value = this.$element.val();
     
           if (value !== '-1') {
             value = String(value).replace(/\D/g, '');
           }
           if (String(value).length === 0) {
             value = this.options.min;
           }
           
           return parseInt(value);
         },
         
         formatNumber: function() {
           var value,
               maxLength,
               length,
               zero;
           
           value = this.getValue();
           
           if (value > this.options.max) {
             if (this.options.wrap === true) {
               value = this.options.min;
             } else {
               value = this.options.max;
             }
           }
           
           if (value < this.options.min) {
             if (this.options.wrap === true) {
               value = this.options.max;
             } else {
               value = this.options.min;
             }
           }
           
           if (this.options.zeros === true) {
             maxLength = String(this.options.max).length;
             length = String(value).length;
             for (zero=length; zero < maxLength; zero = zero + 1) {
               value = '0' + value;
             }
           }
           
           if (value !== this.$element.val()) {
             this.$element.val(value);
           }
         }
     
       };
     
       /* NUMBER PLUGIN DEFINITION
        * ======================= */
     
       var old = $.fn.bfhnumber;
     
       $.fn.bfhnumber = function (option) {
         return this.each(function () {
           var $this,
               data,
               options;
     
           $this = $(this);
           data = $this.data('bfhnumber');
           options = typeof option === 'object' && option;
     
           if (!data) {
             $this.data('bfhnumber', (data = new BFHNumber(this, options)));
           }
           if (typeof option === 'string') {
             data[option].call($this);
           }
         });
       };
     
       $.fn.bfhnumber.Constructor = BFHNumber;
     
       $.fn.bfhnumber.defaults = {
         min: 0,
         max: 9999,
         zeros: false,
         keyboard: true,
         buttons: true,
         wrap: false
       };
     
     
       /* NUMBER NO CONFLICT
        * ========================== */
     
       $.fn.bfhnumber.noConflict = function () {
         $.fn.bfhnumber = old;
         return this;
       };
     
     
       /* NUMBER DATA-API
        * ============== */
     
       $(document).ready( function () {
         $('input[type="text"].bfh-number, input[type="number"].bfh-number').each(function () {
           var $number;
     
           $number = $(this);
     
           $number.bfhnumber($number.data());
         });
       });
     
     
       /* APPLY TO STANDARD NUMBER ELEMENTS
        * =================================== */
    }(window.jQuery);



    $('.new-item-'+data.id).on('click',function(event){
        $('.element').attr('data-order', $(this).attr('order'));
        console.log('order id: '+$(this).attr('order'));
        $('#md-add-event').modal({ backdrop: 'static', keyboard: false });
        setTimeout(function(){
           $('#container').isotope({ sortBy : 'original-order' });
        }, 1000);
    });

    $('.delete_new').on('click',function(event){
        event.preventDefault();
        var code = $(this).attr('code');
        PNotify.removeAll();
        var notice = new PNotify({
            text: $('#form_notice_item').html(), 
            icon: false, 
            width: 'auto', 
            hide: false, 
            addclass: 'custom', 
            icon: 'picon picon-32 picon-edit-delete', 
            opacity: .8, 
            nonblock: { nonblock: true }, 
            animation: {effect_in: 'show', effect_out: 'show'}, 
            buttons: {closer: false, sticker: false }, 
            insert_brs: false 
        }); 
        $('.btn-delete').on('click', function(){
            $.ajax({
                type: 'GET',
                url: 'chef/remove-item',
                data: {id:code},
                success: function (data) {
                    $('.element-'+code).remove();
                    $('.count-item-'+data.code).html('<b>'+data.count+'</b>');
                    notice.remove();
                }
            });
        });
        $('.btn-calcel').on('click', function(){
            notice.remove();
        });
    });

    $('.order-delete_new').on('click',function(event){
        event.preventDefault();
        var code = $(this).attr('code');
        PNotify.removeAll();
        var notice = new PNotify({
            text: $('#form_notice_order').html(), 
            icon: false, 
            width: 'auto', 
            hide: false, 
            addclass: 'custom', 
            icon: 'picon picon-32 picon-edit-delete', 
            opacity: .8, 
            nonblock: { nonblock: true }, 
            animation: {effect_in: 'show', effect_out: 'slide'}, 
            buttons: {closer: false, sticker: false }, 
            insert_brs: false 
        }); 
        notice.get().find('.btn-delete').on('click', function(){
            $.ajax({
                type: 'GET',
                url: 'chef/remove-order',
                data: {id:code},
                success: function (data) {
                    $('.item-'+code).remove();
                    notice.remove();
                }
            });
        });
        notice.get().find('.btn-calcel').on('click', function(){
            notice.remove();
        });
    });
