 
<style>
	.lang{height:300px; } .lang_{/* position: absolute; top:5px; right:10px; width:40px;*/ } .shopping_cart{/* position: absolute; top:5px; right:120px;*/ } a.back{padding: 0 10px; color:white; } div.nav{margin: 0; padding: 0; position:relative; } div.nav a.btn-ico{padding: 0 10px; color:white; margin-right:10px; } div.nav a.btn-ico span.badge{position: absolute; right: 0; color: white; padding-left: 18px; }
</style>
<div class="col s12 m12 l12 nav">
	<a class="waves-effect waves-light btn modal-trigger right btn-ico" href="#modal1" onclick="return window.onbeforeunload = false;">
		<i class="material-icons">language</i>
	</a>
	<a class="waves-effect waves-light btn modal-trigger right btn-ico" href="#modal3">
		<i class="material-icons">settings_phone</i>
	</a>
</div>
 
<div id="modal3" class="modal grey lighten-4">
	<div class="modal-content ">
		<ul class="collection with-header grey lighten-4">
	        <li class="collection-header teal-text"><h4>{{$lang->txt_telefonos}}</h4></li>
	        @foreach($phones as $p)w
	        	<li class="collection-item  indigo-text">{{$p->phones_name}}: <a href="tel:{{$p->phones_number}}"> +{{$p->phones_number}}</a></li>
	        @endforeach
      </ul>
	</div>
</div>

<div id="orderModal" class="modal bottom-sheet" >
	<div class="modal-content " style="padding: 5px; ">
		<h4 style="text-align: center; font-size: 1.5rem; color: #004B44; font-weight: 700;">
		<a class="btn waves-effect waves-light  back" onclick="return $('#orderModal').closeModal();"  style="float: left;
    width: 34px;
    padding: 0px !important;">
			<i class="material-icons">keyboard_backspace</i>
		</a>	
		<span> 
				{{$lang->txt_order}} # <b id="or_num"></b>
		</span> 
		<a class="btn-flat waves-effect waves-light  back" href="http://hotel.dev">
			<i class="material-icons">keyboard_backspace</i>
		</a>
		</h4>
		<p><h5 class="teal-text">{{$lang->txt_habitacion}}: <span id="or_habitacion"></span></h5></p>
		<p><h5 class="teal-text">{{$lang->txt_estado}}: <span id="or_estado"></span></h5></p>
		<p><h5 class="teal-text">{{$lang->txt_horario_de_entrega}}: <span id="or_fecha"></span></h5></p>
		<ul class="collection" id="listCarts" >
			<div id="listCartsBody2">

			</div>
			<li class="collection-item teal-text" style="border-top: 1px solid #e0e0e0;">
				<p><h5 class="teal-text col m6">{{$lang->txt_total}}:  <b id="or_total"></b> </h5></p>
				<p><h5 class="teal-text col m6">{{$lang->txt_tiempo}}: <b id="or_time"></b>m </h5></p>
			</li>
		</ul>
	</div>
	<div class="modal-footer">
		<div class="section" style="padding-top: 0;">
			<p class="teal-text" style="margin-top: 0;">{{$lang->txt_horario_entrega}}</p>
			<div class="divider c"></div>
		      <button id="o-cancel" code="{{url('roomers/deleteorder/')}}" class="col s12 btn waves-effect waves-green red">{{$lang->txt_cancelar_pedido}}</button>
		</div>
		<div class="divider c"></div>
		
	</div>
</div>

<div id="modal12" class="modal grey darken-2">
	<div class="modal-content ">
		<div class="input-field col push-m3 m6 s12 lang">
			<select id="lang">
				<?php $languages = Helpers::LangHotel($hotel->id); ?>
				@foreach($languages as $lang)
				@if($lang->language_id==Session::get('lang_id'))
					<option selected value="{{$lang->id}}">{{str_limit(Language::find($lang->language_id)->language,2,'')}}</option>
					@else
					<option value="{{$lang->id}}">{{str_limit(Language::find($lang->language_id)->language,2,'')}}</option>			
					@endif
				@endforeach
			</select> 
			<label>Language {{Session::get('lang_id')}}</label>
		</div>
	</div>
</div>

<div id="modal1" class="modal bottom-sheet  grey lighten-4">
	{{Form::open(['action' => 'RoomerController@postLang'])}}

	<div class="modal-content">
			<?php $languages = Helpers::LangHotel($hotel->id); ?>
			@foreach($languages as $lang)
			@if($lang->language_id==Session::get('lang_id'))
			<p>
			<input name="lang" type="radio" id="test{{$lang->language_id}}" lang="{{Language::find($lang->language_id)->sufijo}}"  value="{{$lang->language_id}}" checked="checked" />
				<label class=" red-text accent-4" for="test{{$lang->language_id}}">{{Language::find($lang->language_id)->language}}</label>
			</p>
			@else
			<p>
				<input name="lang" type="radio" id="test{{$lang->language_id}}" lang="{{Language::find($lang->language_id)->sufijo}}" value="{{$lang->language_id}}" />
				<label class=" red-text accent-4" for="test{{$lang->language_id}}"> {{Language::find($lang->language_id)->language}}</label>
			</p>
			@endif
			@endforeach
		
	</div>
	<div class="modal-footer grey lighten-4">
		<button id="btnlang" type="submit" class=" modal-action modal-close waves-effect waves-green btn-flat">{{Language::find($lang->language_id)->txt_aceptar}}</button>
	</div>
	</form>
</div> 

<div id="modal_eliminar_pedido" class="modal">
    <div class="modal-content">
      <h4 class="teal-text flow-text center">{{$lang->txt_message_eliminar_pedido}}</h4>       
    </div>
    <div class="modal-footer">
      
      <a href="#" id="btn_cancel_order" class="modal-action btn   waves-effect waves-green  ">{{$lang->txt_si}}</a>

      <a href="#"  class=" modal-action btn red modal-close waves-effect waves-green  " style="margin-right: 15px; ">{{$lang->txt_no}}</a>
    </div>
  </div>

  <div id="modal_cancelar_pedido" class="modal">
    <div class="modal-content">
      <h4 class="teal-text flow-text center">{{$lang->txt_message_eliminar_pedido}}</h4>       
    </div>
    <div class="modal-footer">
      
      <a href="#" id="btn_cancel_order2" class="modal-action btn   waves-effect waves-green  ">{{$lang->txt_si}}</a>

      <a href="#"  class=" modal-action btn red modal-close waves-effect waves-green  " style="margin-right: 15px; ">{{$lang->txt_no}}</a>
    </div>
  </div>


  <div id="modal_no_horario" class="modal">
    <div class="modal-content">
      <h4 class="teal-text flow-text center">{{$lang->txt_message_no_horario}}</h4>       
    </div>
    <div class="modal-footer">
      <a href="#!" id="modal_no_horario_close" onclick="return window.location.reload();" style="width: 100%; "  class="modal-action btn   waves-effect waves-green  ">{{$lang->txt_aceptar}}</a> <br>
     
    </div>
  </div>
<script type="text/javascript">
	
$('#btnlang').on('click', function(event) {
	event.preventDefault();
	var pathArray = window.location.pathname.split( '/' );
	delete pathArray[4];
	delete pathArray[0];
	var dominio = window.location.hostname;
	var sufijo = $("input[name=lang]:checked").attr('lang');
	var lastUrl = "http://"+dominio+'/'+pathArray[1]+'/'+pathArray[2]+'/'+pathArray[3]+'/'+sufijo;
	window.location.href = lastUrl;
});
</script>