<!-- Modal Structure -->
<div id="listOrderModal" class="modal bottom-sheet" >
	<div class="modal-content " style="padding: 5px; ">
		<h4 style="text-align: center; font-size: 1.5rem; color: #004B44; font-weight: 700;">
		<a class="btn waves-effect waves-light  back" onclick="return $('#cartModal').closeModal();"  style="    float: left;
    width: 34px;
    padding: 0px !important;">
			<i class="material-icons">keyboard_backspace</i>
		</a>	
		{{$lang->txt_carrito_compra}}
		<a class="btn-flat waves-effect waves-light  back" href="http://hotel.dev">
			<i class="material-icons">keyboard_backspace</i>
		</a>
		</h4>
		<p><h5 class="teal-text">{{$lang->txt_habitacion}}: <span>0</span></h5></p>
		<ul class="collection" id="listCarts" >
			<div id="listCartsBody"></div>
			<li class="collection-item teal-text" style="border-top: 1px solid #e0e0e0;">
				<p><h5 class="teal-text col m6">{{$lang->txt_total}}: {{$exchange}} <b id="txt_total"></b> </h5></p>
				<p><h5 class="teal-text col m6">{{$lang->txt_tiempo}}: <b id="txt_time"></b>m </h5></p>
				<a href="#!" class="col s12 btn modal-action modal-close waves-effect waves-green">{{$lang->txt_continuar_comprando}}</a>
			</li>
		</ul>
	</div>
</div>

@section('script')

@stop

@section('link')

@stop()