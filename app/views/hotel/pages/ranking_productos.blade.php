@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-12 ">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>Estadisticas</strong> de  Ventas</h2>
		        @if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
                @if (Session::has('error'))
                <label class="color" style="color: red;">{{ Session::get('error') }}</label>
                @endif
		    </header>
			<div class="panel-body">	
			    {{ Form::open(array('action' => 'HotelController@anyStatistics'))}} 				
                    <div class="form-group row">
                        <div class='date col-md-3' >
                            <label class="control-label">Desde</label>
                            <input type='text' class="form-control" name="since" id='datetimepicker6' placeholder="Desde" @if(Input::has('since')) value="{{Input::get('since')}}" @endif/>
                        </div>
                        <div class='date col-md-3' >
                            <label class="control-label">Hasta</label>
                            <input type='text' class="form-control" name="until" id='datetimepicker7' placeholder="Hasta" @if(Input::has('until')) value="{{Input::get('until')}}" @endif/>
                        </div>
                        <div class='date col-md-6' >
                            <label class="control-label"></label>
                            <input type='submit' class="form-control btn-primary"  value="Enviar" style="width: 86px;" />
                        </div>
                    </div>
                {{ Form::close() }}
				<hr style="color: #4E0519" />
				<h3 style="padding-bottom: 18px;"><strong>Productos</strong></h3>

				<table class="table table-bordered" class="table">
					<thead>
						<tr>
							<td>Nombre</td>
							<td>Categoria</td>
							<td>Cantidad vendida</td>
							<td>Valor</td>
						</tr>
					</thead>

					<tbody>
					@foreach($products->groupBy('name_item_menu_id')->get() as $product)
					    <?php 
					         $item = Item::find($product->name_item_menu_id);
			          	     $exchange = Exchanges::find($hotel->exchange_id);
                             $nameItem = NameItem::where('item_id', $product->name_item_menu_id)->where('language_id', $lang->language_id)->first();
                             $q = ItemOrder::where('name_item_menu_id', $product->name_item_menu_id)->get()->sum('quantity');
                             $nameCategory = Name_category_menu::where('category_menu_id', $item->category_id)->where('language_id', $lang->language_id)->first();
				  	    ?>
						<tr>
							<td>{{$nameItem->name}}</td>
							<td>{{$nameCategory->name}}</td>
							<td>{{$q}}</td>
							<td>{{$exchange->symbol}} {{ItemOrder::where('name_item_menu_id', $product->name_item_menu_id)->first()->price*$q}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
                <hr style="color: #4E0519" />
				<h3 style="padding-bottom: 18px;"><strong>Categorias</strong></h3>

				<table class="table table-bordered" class="table">
					<thead>
						<tr>
							<td>Categoria</td>
							<td>Cantidad vendida</td>
							<td>Valor</td>
						</tr>
					</thead>

					<tbody>
					    @foreach(Category_menu::where('hotel_id', $hotel->id)->where('state', 1)->get() as $category)
					    <?php 
					        $exchange = Exchanges::find($hotel->exchange_id);
                            $nameCategory = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang->language_id)->first();
                            $items= Item::where('category_id', $category->id)->where('state', 1)->lists('id');
				  	        $quantity = ItemOrder::whereIn('name_item_menu_id', $items)->sum('quantity');
				  	        $precio = 0;
				  	        foreach (ItemOrder::whereIn('name_item_menu_id', $items)->get() as  $value) {
				  	        	$precio = $precio+($value->price*$value->quantity);
				  	        }
				  	    ?>
						<tr>
							<td>{{$nameCategory->name}}</td>
							<td>{{$quantity}}</td>
							<td>{{$exchange->symbol}} {{$precio}}</td>
						</tr>
		                @endforeach
					</tbody>
				</table>
			</div>
		</section>
		</div>

	</div>
	
</div>


@stop
@section('script')
<script type="text/javascript">
	$(function() {
		$('.table').dataTable();
        $('#datetimepicker6').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#datetimepicker7').datetimepicker({
            useCurrent: false,
            format: 'DD-MM-YYYY'
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
	});
</script>
@stop