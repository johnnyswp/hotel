<!-- Modal Structure -->
<div id="cartModal" class="modal bottom-sheet" >
	<div class="modal-content " style="padding: 5px; ">
		<h4 style="text-align: center; font-size: 1.5rem; color: #004B44; font-weight: 700;">
		<a class="btn waves-effect waves-light  back" onclick="return $('#cartModal').closeModal();"  style="    float: left;
    width: 34px;
    padding: 0px !important;">
			<i class="material-icons">keyboard_backspace</i>
		</a>	
		{{$lang->txt_carrito_compra}}
		<a class="btn-flat waves-effect waves-light  back" href="http://panel.ezresto.com">
			<i class="material-icons">keyboard_backspace</i>
		</a>
		</h4>
		<p><h5 class="teal-text">{{$lang->txt_habitacion}}: <span room_id="{{$stay->room_id}}" id="habitacion_id">
		{{Room::find($stay->room_id)->number_room}}</span></h5></p>
		<ul class="collection" id="listCarts" >
			<div id="listCartsBody"></div>
			<li class="collection-item teal-text" style="border-top: 1px solid #e0e0e0;">
				<p><h5 class="teal-text col m6">{{$lang->txt_total}}: {{$exchange}} <b id="txt_total"></b> </h5></p>
				
				<a href="#!" class="col s12 btn modal-action modal-close waves-effect waves-green">{{$lang->txt_continuar_comprando}}</a>
			</li>
		</ul>
	</div>
	<div class="modal-footer">
		 
		<div class="section" style="padding-top: 0;">
		<p class="teal-text" style=" margin-top: 0;">{{$lang->txt_horario_entrega}}</p>
		<!-- Switch
		<div class="switch">
			<label>
				{{$lang->txt_entrega_inmediata}}
				<input id="opt1" type="checkbox">
				<span class="lever right"></span>				
			</label>
		</div>

		<div class="switch">
			<label>
				{{$lang->txt_entrega_programa}}
				<input  id="opt2" type="checkbox">
				<span class="lever right"></span>				
			</label>
		</div> -->
		
		<div class="divider c"></div>
		
		<div >
			<h5  id="entregaInmediata" class="teal-text">{{$lang->txt_entrega_inmediata}}</h5>			
			<h5 id="entregaProgramada" class="teal-text" style="display: inline-block;">{{$lang->txt_entrega_programa}}</h5>
				<br>
				<span class="teal-text" style="display: none;font-size: 1.5rem;"><b id="txt_ei"></b></span>
				<br>
				<h5 style="font-size: 1.2rem; margin: 0;padding: 0 0 32px; " class="teal-text col m6">{{$lang->txt_tiempo}}: <b id="txt_time"></b>m </h5>			
				<span id="mgs_program" class="teal-text" style="display: none; float: left; margin-top: -20px;"><b>({{$lang->txt_mgs_entrega_programada}})</b></span>
				<input type='hidden' class="datetimepicker" id='datetimepicker2' />
				<input type='hidden' id='stay_id'  value="{{$stay->id}}" />
		</div>
		<div class="divider c"></div>

		<div class="room">
			
		</div>
		<a id="order" href="#!" class="col s12 btn waves-effect waves-green green">{{$lang->txt_enviar_pedido}}</a>
		<br>
		<a id="cancel" href="#!" class="col s12 btn waves-effect waves-green red">{{$lang->txt_cancelar_pedido}}</a>

		</div>
		<div class="divider c"></div>
		
	</div>
</div>

@section('script')
<script>
	shopcar.setInit();
	shopcar.exchange = '{{$exchange}}';
	shopcar.txt_mesaje_pedido = '{{$lang->txt_message_pedido_ok}}';
	shopcar.txt_select_horario = '{{$lang->txt_message_selec_horario}}';
	shopcar.txt_item_no_horario = "{{$lang->txt_message_no_horario}}";

	shopcar.txt_no_datos = '{{$lang->txt_message_no_datos}}';
	shopcar.txt_programmed = '{{$lang->txt_programmed}}';
	shopcar.txt_just_now = '{{$lang->txt_just_now}}';
	shopcar.txt_ready = '{{$lang->txt_ready}}';
	shopcar.txt_delivered = '{{$lang->txt_delivered}}';
	shopcar.txt_finalized = '{{$lang->txt_finalized}}';

	shopcar.domingo   = '{{$lang->txt_domingo}}';	
	shopcar.lunes     = '{{$lang->txt_lunes}}';
	shopcar.martes    = '{{$lang->txt_martes}}';
	shopcar.miercoles = '{{$lang->txt_miercoles}}';
	shopcar.jueves    = '{{$lang->txt_jueves}}';
	shopcar.viernes   = '{{$lang->txt_viernes}}';
	shopcar.sabado    = '{{$lang->txt_sabado}}';
	shopcar.horario_disponible    = "{{$lang->txt_horario_disponible}}";
	shopcar.txt_message_no_horario    = "{{$lang->txt_message_no_horario}}";
	
</script>


@stop

@section('link')

@stop()