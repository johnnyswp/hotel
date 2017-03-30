console.log("roomers.js");
function log (id) {
    console.log(id);
};
var shopcar = {
    url : "http://panel.ezresto.com",
    txt_mesaje_pedido :"",
    txt_select_horario:"",
    txt_item_no_horario:"",
    txt_no_datos:"",
    txt_programmed:"",
    txt_just_now:"",
    txt_ready:"",
    txt_delivered:"",
    txt_finalized:"",
    txt_message_no_horario:"",
    setPad:function (d) {
        return (d < 10) ? '0' + d.toString() : d.toString();
    },
    setLink : function() {

        $('.back_').on('click', function(event) {
            console.log($(this).attr('href'));
            if($(this).attr('href')==shopcar.url)
            { 
                event.preventDefault(); 
                window.location.href =shopcar.url+'/roomer/catalog';
            }
        });
    },
    setInit: function () {
         
        if(store.get('item_list')==null || store.get('item_list') ===undefined){
            store.set('item_list',null);
        }

        if(store.get('item_time')==null || store.get('item_time') ===undefined){
            store.set('item_time',0);
        }

        if(store.get('item_total')==null || store.get('item_total') ===undefined){
            store.set('item_total',0);
        }else{
            $('#label_numcar').text(store.get('item_total'));
        }
        if(store.get('item_num')==null || store.get('item_num') ===undefined){
            store.set('item_num',0);
            $('#label_numcar').text(store.get('item_num'));
        }else{
            $('#label_numcar').text(store.get('item_num'));
        }

        //Button Agregar a Carrito
        $('.add').on('click', function(event) {
            event.preventDefault();
            var price = $(this).data('price');
            var id = $(this).data('id');
            var picture = $(this).data('picture');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var exchange = $(this).data('exchange'); 
            var count = 1;
            var time = $(this).data('time'); 

            shopcar.setIdItem(id); 
            shopcar.setItem(id,price,count,name,description,picture,exchange,time); 
            shopcar.setAddNum();
            shopcar.setAddTime(time);
            var cs= parseInt($(this).parent().find('.number-text0').text());
            var css=  parseInt(cs)+1;
            $(this).parent().find('.number-text0').text(css)

            var t = store.get('item_total');
            var total =  parseFloat(t) + parseFloat(price);
            store.set('item_total',total);
        });

        $('.less_').on('click', function(event) {
            event.preventDefault();
              
                var nus=parseInt($(this).parent().find('.number-text0').text());
                if(nus < 1) return false;
                console.log(nus);
                var price       = $(this).data('price');
                var id          = $(this).data('id');
                var picture     = $(this).data('picture');
                var name        = $(this).data('name');
                var description = $(this).data('description');
                var exchange    = $(this).data('exchange');
                var count       = 1;
                var time        = $(this).data('time');
            
            if(nus>1){
                //shopcar.setIdItem(id); 
                shopcar.setItemLess(id,price,count,name,description,picture,exchange,time); 
                shopcar.setLessNum();
                 
                var t = store.get('item_total');
                var total =  parseFloat(t)- parseFloat(price);
                store.set('item_total',total);

                var item_titeS = parseInt(store.get('item_time')); 
                var total_time;
                if(item_titeS > parseInt(time))                                           
                {
                     total_time = item_titeS;  
                }
                else
                {
                     total_time = time;  
                }
                
                store.set('item_time', total_time);
                
                //$('#txt_time').text(total_time);
                //$('#txt_total').text(total);
                console.log('total: '+total+" timeTotal: "+total_time);


                //$('.rr'+id).data('count',cCtotal).attr('data-count', cCtotal);
                $(this).parent().find('.number-text0').text(nus-1); 


            }else{
                console.log(nus);
                shopcar.setRemove(id,count,price,time);
                store.set('item_time', shopcar.setTimeMayor());
                $('#txt_time').text(shopcar.setTimeMayor());//__ok
                 shopcar.setFechaEntrega();
                $(this).parent().find('.number-text0').text('0'); 


                /*$(this).parent().fadeOut('slow',function  () {
                   $(this).remove();
                });*/
            }
        });

        //Button Ver Carrito
        $('#btnShopCart').on('click', function(event) {
            event.preventDefault();
            var count = $('#label_numcar').text();
            if(count>0){
                shopcar.getElem();
                shopcar.setType();
                $('#cartModal').openModal();
            }else{
               Materialize.toast(shopcar.txt_no_datos, 3000);
            }
        });
        shopcar.setLink();
        shopcar.setOrder();
        shopcar.setShowOrder();
        $('#o-cancel').on('click', function(event) {
            event.preventDefault();
           
            $('#modal_eliminar_pedido').openModal();
            $("#btn_cancel_order").attr('code',$(this).attr('code'));
            $('#modal1').closeModal();
            $('#modal2').closeModal();
            $('#orderModal').closeModal();
            $('#modal3').closeModal();
            $('#modal4').closeModal();

        });
        $('#btn_cancel_order').on('click', function(event) {
            event.preventDefault();
            window.onbeforeunload = false;  
            $.post($(this).attr('code'), {}, function(data, textStatus, xhr) {
                window.location.href=shopcar.url+"/roomer";
            });
        });
         $('#cancel').on('click', function(event) {
            event.preventDefault();
            $('#modal_cancelar_pedido').openModal();
            $("#btn_cancel_order").attr('code',$(this).attr('code'));
            $('#modal1').closeModal();
            $('#modal2').closeModal();
            $('#orderModal').closeModal();
            $('#modal3').closeModal();
            $('#modal4').closeModal();
        });
        $('#btn_cancel_order2').on('click', function(event) {
            shopcar.setClear();
        });
    },
    setClear:function  () {
        
        store.clear();
        var t = "inmediato";
        store.set('item_list',null);
        store.set('item_time',0);
        store.set('item_total',0);
        store.set('item_num',0);
        store.set('item_type',t);
        $('#label_numcar').text('0');
        $('#listCartsBody').html('');
        $('#datetimepicker4').val('');
        $('#datetimepicker1').val('');
        Materialize.toast(shopcar.txt_mesaje_pedido, 4000);
        window.location.href = shopcar.url+'/roomer/';
    },
    setIdItem: function (id) {
        if(store.get('item_list')==null)
        {
            var ro = Array();
            ro.push(id);
            store.remove('item_list')
            store.set('item_list', ro);

        }
        else
        {
            var s = JSON.stringify(store.get('item_list'));
            var k = store.get('item_list');
            if(k.indexOf(id) >= 0){}else{
                k.push(id);
                store.remove('item_list')
                store.set('item_list', k);
            }
        }    
    },
    setItem: function     (id,price,count,name,description,picture,exchange,time) {
        var item = store.get('elem_'+id);
        if(item===undefined)
        {
            //store.remove('item_list')
            store.set('elem_'+id, {id:id,price:price,count:count,exchange:exchange,time:time,name:name,description:description,picture:picture});
            $.post(shopcar.url+'/roomer/item-name/'+id, {}, function(data, textStatus, xhr) {
                store.set('name_'+id,data);
            });
        }
        else
        {
            var c = item.count;
            var count_total =  parseInt(c)+1;        
            store.set('elem_'+id, {id:id,price:price,count:count_total,exchange:exchange,time:time,name:name,description:description,picture:picture});
        }
    },
    setItemLess: function (id,price,count,name,description,picture,exchange,time) {
        var item = store.get('elem_'+id);
        if(item===undefined)
        {
            //store.remove('item_list')
            store.set('elem_'+id, {id:id,price:price,count:count,exchange:exchange,time:time,name:name,description:description,picture:picture});
        }
        else
        {
            var c = item.count;
            var count_total =  parseInt(c)-1;
            
            store.set('elem_'+id, {id:id,price:price,count:count_total,exchange:exchange,time:time,name:name,description:description,picture:picture});
        }
    },
    setAddNum:function () {
        if(store.get('item_num')==null || store.get('item_num') ===undefined){
            store.set('item_num',1);
        }else{
            var num = store.get('item_num');
            var total_num =  parseInt(num) +1;
            store.set('item_num',total_num);
            $('#label_numcar').text(total_num);
        }
    },
    setAddTime:function (tt) {
        if(store.get('item_time')==null || store.get('item_time') ===undefined || store.get('item_time') ===0){
            store.set('item_time',tt);
        }else{
            var num = store.get('item_time');
            if(num >  parseInt(tt)){
                store.set('item_time',num); 
                $('#txt_time').text(num);

            }else{
                store.set('item_time',parseInt(tt)); 
                $('#txt_time').text(parseInt(tt));

           }
            
           
        }
    },
    setLessNum:function () {
        if(store.get('item_num')==null || store.get('item_num') ===undefined){
            store.set('item_num',1);
        }else{
            var num = store.get('item_num');
            var total_num =  parseInt(num) - 1;
            store.set('item_num',total_num);
            $('#label_numcar').text(total_num);
        }
    },
    setLessTime:function (tt) {
        if(store.get('item_time')==null || store.get('item_time') ===undefined || store.get('item_time') ===0){
            store.set('item_time',tt);
        }else{

            var num = store.get('item_time');
            var total_time = num - tt;
            store.set('item_time',total_time);
            $('#txt_time').text(total_time);


        }
    },
    getElem:function () {
        var arrayElem = store.get('item_list');
        store.forEach(function(key, val) {
            //console.log(key.indexOf('elem_'));
            if(key.indexOf('elem_')>=0){
                var elem = store.get(key);
                    //console.log(elem);
                    if($('#item-'+elem.id).length == 0)
                    {
                        var lang = store.get('lang');
                        var nameX = store.get('name_'+elem.id);
                        var nombre = nameX[lang];
                        var html ='<li id="item-'+elem.id+'" class="collection-item avatar">'
                                +    '<a id="close_item" href="#" data-count="'+elem.count+'" data-time="'+elem.time+'" class="rr'+elem.id+' remove secondary-content btn-floating btn-large waves-effect waves-light red"  data-description="" data-name="" data-picture="" data-price="'+elem.price+'" data-id="'+elem.id+'"><b><i class="material-icons">close</i></b></a>'
                                +    '<img src="'+elem.picture+'" alt="" class="circle">'
                                +    '<span class="title teal-text">'+nombre+'</span>'
                                +    '<span class="price teal-text"> U: '+elem.exchange+' '+elem.price+'</span>'
                              //+    '<p class="teal-text">'+elem.description+'</p>'
                                +    '<a href="#less" class="secondary-content white-text remove2 less'+elem.id+'" data-exchange="'+elem.exchange+'"  data-count="1" data-name="'+elem.name+'" data-picture="'+elem.picture+'" data-price="'+elem.price+'" data-id="'+elem.id+'" data-time="'+elem.time+'"><i class="material-icons">remove_circle</i></a>'
                                +    '<a href="#add" class="secondary-content white-text add2 add2-'+elem.id+'" data-exchange="'+elem.exchange+'"  data-count="1" data-name="'+elem.name+'" data-picture="'+elem.picture+'" data-price="'+elem.price+'" data-id="'+elem.id+'" data-time="'+elem.time+'"><b><i class="material-icons">add_circle</i></b></a>'
                                +    '<span class="number-text teal-text">'+elem.count+'</span>'                                                    
                                +'</li>';
                        $('#listCartsBody').append(html);
                        
                        shopcar.setDeleteItem(elem.id);
                        
                        shopcar.setAdd2(elem.id);      
                        shopcar.setLess2(elem.id); 
                        $('#txt_time').text(store.get('item_time'));

                    }else
                    {
                      $('#item-'+elem.id).data('count',elem.count).attr('data-count',elem.count).find('.number-text').text(elem.count);
                      $('#item-'+elem.id).find('.remove').data('count',elem.count).attr('data-count',elem.count);
                    }  

                   
            }

        });
        
            
        var total = store.get('item_total');
        $('#txt_total').text(total);
    }, 
    setRemove: function(id, count,price,time){
            event.preventDefault();
            var num  = store.get('item_num');
            var item_num = count;
            var total_num = num - item_num;
            store.set('item_num', total_num);
            $('#label_numcar').text(total_num);
            var item_count = count * price ;
            var item_total = store.get('item_total');
            var total =item_total-item_count ;
            store.set('item_total', total);
            $('#txt_total').text(total);

            /*var item_titeS = store.get('item_time');                                            
            var total_time = item_titeS - time;
            store.set('item_time', total_time);*/
            
            
            var item_titeS = parseInt(store.get('item_time')); 
            var total_time;
            if(item_titeS > parseInt(time))                                           
            {
                 total_time = item_titeS;  
                 console.log('item_titeS: '+item_titeS) 

            }
            else
            {
                 total_time = item_titeS-parseInt(time); 
                 //total_time = parseInt(time); 
                 /*if(total_time < 1){
                    total_time= shopcar.setTimeMayor();
                    console.log('antes del time(-): '+total_time) 
                 }*/
                 console.log('time(-): '+total_time) 
            }
            
           
            store.set('item_time', total_time);
             $('#txt_time').text(total_time);

            //console.clear();
            var s = JSON.stringify(store.get('item_list'));
            var k = store.get('item_list');
                //console.log(k+ ' es k = store.get(item_list)');
            var l = k.indexOf(id);
            if(k.indexOf(id) >= 0){
                //console.log(l+ ' es l = k.indexOf(id)');
                if (l > -1) {
                    k.splice(l, 1);
                }
                //console.log(k+ ' es k = k.splice(l)');                                
                store.remove('item_list')
                store.set('item_list', k);
            } 
            store.remove('elem_'+id);
            store.remove('name_'+id);
            var nn =  parseInt($('#num0-'+id).text());
            var ls = $('#num0-'+id).text(nn-1);
    },
    setDeleteItem: function  (id) {
        $('.rr'+id).on('click', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var num  = store.get('item_num');
            var time  = store.get('item_time');
            var item_num = $(this).data('count');
            var total_num = num - item_num;
            store.set('item_num', total_num);
            $('#label_numcar').text(total_num);
            /*var item_time = $(this).data('time') * $(this).data('count');
            var item_titeS = store.get('item_time');                            
            var total_time = item_titeS - item_time;
            store.set('item_time', total_time);
            $('#txt_time').text(total_time);*/
            var item_titeS = parseInt(store.get('item_time')); 
            var total_time;
            if(item_titeS > parseInt($(this).data('time')))                                           
            {
                 total_time = item_titeS;  
                 console.log('item_titeS: '+item_titeS) 
            }
            else
            {
                 total_time = item_titeS - parseInt($(this).data('time')); 
                 //total_time = parseInt($(this).data('time')); 
                 console.log('time: (_x_) '+total_time) 
            }
            $('#txt_time').text(total_time);
            var item_count = $(this).data('count') * $(this).data('price') ;
            var item_total = store.get('item_total');
            var total =item_total-item_count ;
            store.set('item_total', total);
            $('#txt_total').text(total);
            //console.clear();
            var s = JSON.stringify(store.get('item_list'));
            var k = store.get('item_list');
                //console.log(k+ ' es k = store.get(item_list)');
            var l = k.indexOf(id);
            if(k.indexOf(id) >= 0){
                //console.log(l+ ' es l = k.indexOf(id)');
                if (l > -1) {
                    k.splice(l, 1);
                }
                //console.log(k+ ' es k = k.splice(l)');                                
                store.remove('item_list')
                store.set('item_list', k);
            } 
            store.remove('elem_'+id);
            store.remove('name_'+id);
            $(this).parent().fadeOut('slow',function  () {
                $('#num0-'+id).text('0'); 
                $(this).remove();
                if($('#listCartsBody').html()=="") $('#cartModal').closeModal();
            });
            store.set('item_time', shopcar.setTimeMayor());
            $('#txt_time').text(shopcar.setTimeMayor());//__ok
             shopcar.setFechaEntrega();
        });
    },
    setDeleteItem2: function  (ids) {
             
            var id = $('.rr'+ids).data('id');
            console.log("este es el ID: "+id)
            var num  = store.get('item_num');
            var time  = store.get('item_time');
            var item_num = $('.rr'+id).data('count');
            var total_num = num - item_num;
            store.set('item_num', total_num);
            $('#label_numcar').text(total_num);
            /*var item_time = $('.rr'+id).data('time') * $('.rr'+id).data('count');
            var item_titeS = store.get('item_time');                            
            var total_time = item_titeS - item_time;
            store.set('item_time', total_time);
            $('#txt_time').text(total_time);*/
            var item_titeS = parseInt(store.get('item_time')); 
            var total_time;
            if(item_titeS > parseInt($('.rr'+id).data('time')))                                           
            {
                 total_time = item_titeS;  
                 console.log('item_titeS: '+item_titeS) 
            }
            else
            {
                 total_time = item_titeS - parseInt($('.rr'+id).data('time')); 
                 //total_time = parseInt($('.rr'+id).data('time')); 
                 console.log('time: (_x_) '+total_time) 
            }
            $('#txt_time').text(total_time);
            var item_count = $('.rr'+id).data('count') * $('.rr'+id).data('price') ;
            var item_total = store.get('item_total');
            var total =item_total-item_count ;
            store.set('item_total', total);
            $('#txt_total').text(total);
            //console.clear();
            var s = JSON.stringify(store.get('item_list'));
            var k = store.get('item_list');
                //console.log(k+ ' es k = store.get(item_list)');
            var l = k.indexOf(id);
            if(k.indexOf(id) >= 0){
                //console.log(l+ ' es l = k.indexOf(id)');
                if (l > -1) {
                    k.splice(l, 1);
                }
                //console.log(k+ ' es k = k.splice(l)');                                
                store.remove('item_list')
                store.set('item_list', k);
            } 
            store.remove('elem_'+id);
            store.remove('name_'+id);
            $('.rr'+ids).parent().fadeOut('slow',function  () {
                $('#num0-'+id).text('0'); 
                $(this).remove();
                if($('#listCartsBody').html()=="") $('#cartModal').closeModal();
            });
            store.set('item_time', shopcar.setTimeMayor());
            $('#txt_time').text(shopcar.setTimeMayor());//__ok
            shopcar.setFechaEntrega();
    },
    setTimeMayor: function () {
        var t=0;var r=[];
         store.forEach(function(key, val) {
            if(key.indexOf('elem_')>=0){
                var elem = store.get(key);
                r.push(elem.time);
               t=t+1;
            }
        });
         /*Math.min.apply(null, valores); Math.max.apply(null, valores);*/
            console.log('mayor time: '+Math.max.apply(null, r));

        return Math.max.apply(null, r); 
    },
    getServer: function (){

        return 'http://'+window.location.host;
    },    
    setAdd2: function (id) {
        //console.clear();
        //console.log('Entro Add2');
        $('.add2-'+id).on('click', function(event) {
            event.preventDefault();

            var price       = $(this).data('price');
            var id          = $(this).data('id');
            var picture     = $(this).data('picture');
            var name        = $(this).data('name');
            var description = $(this).data('description');
            var exchange    = $(this).data('exchange');
            var count       = 1;
            var time       = $(this).data('time');
           
            shopcar.setIdItem(id); 
            shopcar.setItem(id,price,count,name,description,picture,exchange,time); 
            shopcar.setAddNum();
            shopcar.setAddTime(time);

            var t = store.get('item_total');
            var total = parseFloat(t)+ parseFloat(price);
            store.set('item_total',total);
            var cCount = $('.rr'+id).data('count');
            var cCtotal = cCount+1;
            $('.rr'+id).data('count',cCtotal).attr('data-count', cCtotal);
            $(this).parent().find('.number-text').text(cCtotal);
            $('#num0-'+id).text(cCtotal);
            $('#txt_total').text(total);
        });
    },
    setLess2: function (id) {
        //console.clear();
        $('.less'+id).on('click', function(event) {
            event.preventDefault();
                var nus= parseInt($(this).parent().find('.number-text').text());
                var price       = $(this).data('price');
                var id          = $(this).data('id');
                var picture     = $(this).data('picture');
                var name        = $(this).data('name');
                var description = $(this).data('description');
                var exchange    = $(this).data('exchange');
                var count       = 1;
                var time        = $(this).data('time');
            if(nus>1){
                //shopcar.setIdItem(id); 
                shopcar.setItemLess(id,price,count,name,description,picture,exchange,time); 
                shopcar.setLessNum();
                 
                var t = store.get('item_total');
                var total =  parseFloat(t) - parseFloat(price);
                store.set('item_total',total);

                var cCount = $('.rr'+id).data('count');
                var cCtotal =  parseInt(cCount)-1;

                var item_titeS = parseInt(store.get('item_time')); 
                var total_time;

                if(item_titeS > parseInt(time))                                           
                {
                     total_time = item_titeS;  
                }
                else
                {
                    //total_time = item_titeS - parseInt(time);
                    total_time = parseInt(time);
                    console.log('time: (x) '+total_time) 
                }

                store.set('item_time', total_time);

                $('#txt_time').text(total_time);                
                $('#txt_total').text(total);
                 

                var nn =  parseInt($('#num0-'+id).text());
                var ls = $('#num0-'+id).text(nn-1);


                $('.rr'+id).data('count',cCtotal).attr('data-count', cCtotal);
                $(this).parent().find('.number-text').text(cCtotal);


            }else{
                shopcar.setRemove(id,count,price,time);
                store.set('item_time', shopcar.setTimeMayor());
                $('#txt_time').text(shopcar.setTimeMayor());//__ok
                shopcar.setFechaEntrega();


                $('#num0-'+id).text('0');        
                $(this).parent().fadeOut('slow',function  () {
                   $(this).remove();
                });
                var ht = $('#listCartsBody li').length;
                    console.log('content: -> ' + ht);

                if(ht < 2)
                { 
                    $('#cartModal').closeModal();
                }
                                
            }
                
        });
    },
    setType:function () {

        var type = store.get('item_type');
        if(type=='programado')
        {
            $('#entregaProgramada').css('display','inline-block');
            $('#entregaInmediata').css('display','none');
            var mdd = store.get('item_time');
            var dd= store.get('item_type_date');//ser hh:mm dd/mm/aaaa
            
            var tiempo_de_pedido = moment(dd);
            var r = moment();
            
            var ff;
            if(r > tiempo_de_pedido){
                ff=r;
                console.log("Mayor r que tiempo_de_pedido");
            }else{
                ff=tiempo_de_pedido;
                console.log("Menor r que tiempo_de_pedido");
            }
            
            $('#txt_ei').text(ff.format('HH:mm DD/MM/YYYY')).parent().css('display', 'inline-block');
            $('#mgs_program').css('display', 'block');
            $('#datetimepicker2').val(ff.format('HH:mm DD/MM/YYYY'));            
        }
        else
        {
            $('#entregaProgramada').css('display','none');
            $('#entregaInmediata').css('display','block');
            var mdd = store.get('item_time');
            $('#datetimepicker2').val(moment().add('m',mdd).format('H:m:s'));
            $('#txt_ei').text($('#datetimepicker2').val());
        }
    },
    setFechaEntrega: function () {
        if(store.get('item_type')=='programado'){
            
            //tiempo de preparacion en minutos 15
            var time = parseInt($('#txt_time').text());
            
            //fecha de entrega limite. 21:40
            var ttt =  store.get('item_type_date');

            var tiempo_de_pedido = moment(ttt);

            //fecha actual mas el tiempo de preparacion
            var r = moment();

            var ff;

            if(r > tiempo_de_pedido){
                ff=r;
                console.log("Mayor r que tiempo_de_pedido");
            }else{
                ff=tiempo_de_pedido;
                console.log("Menor r que tiempo_de_pedido");
            }
            
            $('#txt_ei').text(ff.format('HH:mm DD/MM/YYYY')).parent().css('display', 'inline-block');
            $('#mgs_program').css('display', 'block');
            
            console.log("Entro a: "+store.get('item_type'))

        }else{
            console.log("Entro a: "+store.get('item_type'))
            var time = parseInt($('#txt_time').text());
            
            //fecha de entrega limite. 21:40
            var ttt =  store.get('item_type_date');

            var tiempo_de_pedido = moment(ttt);

            //fecha actual mas el tiempo de preparacion
            var r = moment().add('m',time);
            
            $('#txt_ei').text(r.format('HH:mm DD/MM/YYYY'));

        }
    },
    setOption:function (p1,p2) {
        var o1=$('#'+p1);
        var o2=$('#'+p2);

        o1.on('click', function(event) {            
            /* Act on the event */
            if($(this).prop('checked')){
                //console.log(' desactivado a activado ');                
                o2.prop('checked',false);
                $('#entregaProgramada').css('display','none');
            }else{
                //console.log('activado a desactivado');                
                o2.prop('checked',true);
                $('#entregaProgramada').css('display','block');
            }
        });

        o2.on('click', function(event) {            
            /* Act on the event */
            if($(this).prop('checked')){
                //console.log(' desactivado a activado ');                
                o1.prop('checked',false);
                $('#entregaProgramada').css('display','block');
            }else{
                //console.log('activado a desactivado');                
                o1.prop('checked',true);
                $('#entregaProgramada').css('display','none');
            }
        });
    },
    setOrder: function () {
        $('#order, #btn_send2').on('click', function(event) {
            event.preventDefault();
            
            /* Act on the event 
            if(!$('#opt1').prop('checked') && !$('#opt1').prop('checked')){
                Materialize.toast(shopcar.txt_select_horario, 4000);
                return false;
            }*/
            var t="";
            
            //Obtener datos
            store.forEach(function(key, val) {
                //console.log(key.indexOf('elem_'));
                 
                if(key.indexOf('elem_')>=0)
                {
                   t = t+JSON.stringify(store.get(key))+',';
                } 
            });

            if(t==""){
                Materialize.toast(shopcar.txt_no_datos, 3000);                
                return false;
            }
            t = t.substring(0,t.length - 1);            
            t = '['+t+']';
            var tt_t = store.get('item_type');
            if(tt_t == 'inmediato')
            {
                var timeH = moment().format('DD-MM-YYYY H:mm');
                var time = store.get('item_time');
                var time = store.get('item_time');
                var timeOut = moment().add(time,'m').format('DD-MM-YYYY H:mm');
                var state = "just_now";
            }
            else
            {
                var time = store.get('item_time');
                var ttt =  store.get('item_type_date');;
                //var timeOut = moment(ttt,"MM/DD/YYYY h:mm:ss").add(time,'m').format('DD-MM-YYYY H:mm');
                var timeOut = moment(ttt,"MM/DD/YYYY h:mm:ss").format('DD-MM-YYYY H:mm');
                var timeH = moment(ttt,"MM/DD/YYYY h:mm:ss").format('DD-MM-YYYY H:mm');
                var state = "for_later";
            }
                var today = moment().format('DD-MM-YYYY');

            var timeUp = moment().format('DD-MM-YYYY H:mm');
            var stay_id = $('#stay_id').val();
                $.post(shopcar.url+'/roomer/order', 
                {
                    timeH:timeH,
                    items: t,
                    cantidad:store.get('item_num'),
                    time:timeOut,
                    preparation_time:store.get('item_time'),
                    stay_id:stay_id,
                    timeUp:timeUp,
                    state:'programmed',
                    today:today
                }, 
                function(data, textStatus, xhr) {
                    if(data.out){
                       
                       window.location.href =shopcar.url+'/roomer/stay-out';
                    }
                    if(data.success){
                        $('#cartModal').closeModal();
                        
                        
                        window.location.href = shopcar.url+'/roomer#mgs';                        
                    }else{
                        $('#modal_no_horario').openModal();
                        $.each(data, function(index, val) {
                            shopcar.setDeleteItem2(val);
                        });
                        
                    }
                });
        });
    },
    setOrders:function (ids) {        
        //verificar si ya existen los pedidos en localStore
         var s=ids.split(',');
        $.each(s,function(p,e){
            var item = store.get('order_'+e);
            var datos;
                var lang = store.get('lang');
                $.post(shopcar.url+'/roomer/order-roomer/'+e+'/'+lang,{},function(data, textStatus, xhr) {
                    var asd=JSON.parse(data);
                    store.set('order_'+e,asd);
                });
        });        
    },
    setShowOrder:function () {
        $('.showOrder').on('click',function(event) {
            event.preventDefault();
            /* Act on the event */
            //obtener store local
            var name = $(this).attr('order');
            var idn = $(this).attr('idn');
            
            var x = name.split('_'); 
            var order_id =  x[1];
            var lang = store.get('lang');
                $.post(shopcar.url+'/roomer/order-roomer/'+order_id+'/'+lang,{},function(data, textStatus, xhr) {
                    var datos=JSON.parse(data);
                    $('#or_num').text(idn);
                    $('#or_habitacion').text(datos.habitacion);
                    if(datos.estado=="programmed")
                    {
                        $('#or_estado').text(shopcar.txt_programmed);
                        $('#o-cancel').prop('disabled',false);

                    }
                    else if(datos.estado=="just_now")
                    {
                        $('#or_estado').text(shopcar.txt_just_now);
                        $('#o-cancel').prop('disabled',false);

                    }
                    else if(datos.estado=="ready")
                    {
                        $('#or_estado').text(shopcar.txt_ready); 
                        $('#o-cancel').prop('disabled',true);                       
                    }
                    else if(datos.estado=="delivered")
                    {
                        $('#o-cancel').prop('disabled',true);
                        $('#or_estado').text(shopcar.txt_delivered);                        
                    }else if(datos.estado=="finalized")
                    {
                        $('#o-cancel').prop('disabled',true);
                        $('#or_estado').text(shopcar.txt_finalized);                        
                    }
                    $('#or_fecha').text(moment(datos.entrega).format('HH:mm DD/MM/YYYY'));
                    $('#or_total').text(datos.total);
                    $('#or_time').text(datos.tiempo);

                    $('#o-cancel').attr('code',shopcar.url+'/roomer/deleteorder/'+datos.id);
                     
                    var items = datos.items;

                    $('#listCartsBody2').html('');

                    $.each(items, function(index, value) {
                        var html ='<li id="item-'+value.id+'" class="collection-item avatar">'
                                +    '<img src="'+value.picture+'" alt="" class="circle">'
                                +    '<span class="title teal-text">'+value.name+'</span>'
                                +    '<span class="price teal-text" style="left: 66px;">   '+value.precio+'</span>'
                                +    '<span class="number-text teal-text">'+value.cantidad+'</span>'                                                    
                                +'</li>';
                        $('#listCartsBody2').append(html);
                    });
                });
            

        });
    },
    setHour:function(olde){
        var k = olde.split(':');
        return k[0]+':'+k[1];
    },
    setDays : function (id) {
        var days = [
            shopcar.domingo,
            shopcar.lunes,
            shopcar.martes,
            shopcar.miercoles,
            shopcar.jueves,
            shopcar.viernes,
            shopcar.sabado,
        ];   
        return days[id];
    },
    setItemHorario: function (item_id,hotel_id) {
        $.post(shopcar.url+'/roomer/item-horario/'+item_id+"/"+hotel_id, {}, function(data, textStatus, xhr) {
            var html = "";
            $.each(data,function(p,e){
               var dia = shopcar.setDays(e.weekday);
                
               html+="<p style='margin: 0; padding: 0; font-weight: 400;'> <b style='width:85px;display: inline-block;'>"+ 
               dia+"</b>   "+ shopcar.setHour(e.desde_1)+" a "+shopcar.setHour(e.hasta_1);
               if(shopcar.setHour(e.desde_2)=="00:00" && shopcar.setHour(e.hasta_2)=="00:00"){
               html+="</p>";

               }else{
               html+=" / "+shopcar.setHour(e.desde_2)+" a "+shopcar.setHour(e.hasta_2)+"</p>";
               }
               
            });
            $('#horario').html(html);
        });
    }
}