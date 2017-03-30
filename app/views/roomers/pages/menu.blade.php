@extends('hotel.master') 

@section('title', 'Hotels Dashboard')

@section('content')

@if (Session::has('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif

<div id="content">
	
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel">
			<h3></h3>
			<div class="panel-body">
				<div class="col-lg-6">
					<h2>Hotel 1</h2>
				</div>

				<div class="col-lg-6">
					<div class="col-lg-4 col-lg-offset-6"> 
						<select class="form-control">
							<option>Español</option>
							<option>Ingles</option>
						</select>
					</div>

                    <div class="col-lg-2">
                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                    </div>
				</div>
				
				<h3>Calle Principal, Madrid</h3>
				<h3>77889933</h3>

				<div id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Elemento 1</a>
                </h4>
            </div>

            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum feugiat ipsum mauris, quis ullamcorper est pretium id. Sed suscipit velit sit amet porta hendrerit. Aenean ac nunc maximus, ornare erat eu, suscipit lorem. Nam elementum dapibus augue, ut vulputate mi condimentum pharetra. Mauris iaculis enim augue. Aenean accumsan quam massa, ut rhoncus orci gravida sed. Pellentesque id purus semper, congue lectus eu, consequat orci. Nullam sed nunc at felis tempus vulputate id convallis risus. </p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Elemento 2</a>
                </h4>
            </div>

            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum feugiat ipsum mauris, quis ullamcorper est pretium id. Sed suscipit velit sit amet porta hendrerit. Aenean ac nunc maximus, ornare erat eu, suscipit lorem. Nam elementum dapibus augue, ut vulputate mi condimentum pharetra. Mauris iaculis enim augue. Aenean accumsan quam massa, ut rhoncus orci gravida sed. Pellentesque id purus semper, congue lectus eu, consequat orci. Nullam sed nunc at felis tempus vulputate id convallis risus. </p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Elemento 3</a>
                </h4>
            </div>

            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum feugiat ipsum mauris, quis ullamcorper est pretium id. Sed suscipit velit sit amet porta hendrerit. Aenean ac nunc maximus, ornare erat eu, suscipit lorem. Nam elementum dapibus augue, ut vulputate mi condimentum pharetra. Mauris iaculis enim augue. Aenean accumsan quam massa, ut rhoncus orci gravida sed. Pellentesque id purus semper, congue lectus eu, consequat orci. Nullam sed nunc at felis tempus vulputate id convallis risus. </p>
                </div>
            </div>
        </div>
    </div>

			</div>
		</section>
		</div>

	</div>
	
</div>


@stop

@section('script')
<script type="text/javascript" src="{{url()}}/assets/plugins/datable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{url()}}/assets/plugins/datable/dataTables.bootstrap.js"></script>


<script type="text/javascript">
	$(function() {
		


		// Call dataTable in this page only
		$('#table-example').dataTable();
	});
</script>
@stop