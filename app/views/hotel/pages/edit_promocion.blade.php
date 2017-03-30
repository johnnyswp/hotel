@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong>{{trans('main.alta de')}}</strong> {{trans('main.promotion')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
                @if (Session::has('error'))
                <label class="color" style="color: red;">{{ Session::get('error') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($promotion, ['files' => 'true', 'method' => 'PATCH', 'route' => ['hotel.promotions.update', $promotion->id]]) }}
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">{{trans('main.select a Picture')}}</label><br>
						<div>
							<div class="fileinput fileinput-exists" data-provides="fileinput">
								<input type="hidden" value="" name="">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
									<img src="{{$promotion->picture}}" />
								</div>
							<div>
								<span class="btn btn-default btn-file">
									<span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
									<input type="file" name="picture">
								</span>
							<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
							</div>
						</div>
						<br>

						<span class="label label-danger ">{{trans('main.note')}}</span>
						<span>{{trans('main.you must select single files of')}}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Precio</label>
						<div>
							{{ Form::text('price', NULL, ['class' => 'form-control', 'placeholder'=>'price', 'autocomplete'=>'off']) }}
                            {{ errors_for('price', $errors) }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Cantidad de items por promocion</label>
						<div>
							<select name="quantity" class="form-control selectpicker" id="quantity">
								<?php
									for ($i=1; $i <= 10; $i++) { 
										if($promotion->quantity==$i){
											echo "<option value='".$i."' selected>".$i."</option>";
										}
										echo "<option value='".$i."'>".$i."</option>";
									}
								?>
							</select>
						</div>
					</div>
                    <hr style="color: #4E0519" />
                    
					<div class="form-group" id="grupos">
					<?php $i=1; ?>
					@for($i=1; $i < $promotion->quantity+1; $i++)
					    <?php $group = PromotionProduct::where('promotion_id', $promotion->id)->where('order', $i)->first(); ?>
					    <label class="control-label">{{trans('main.Grupo').' '.$i}} </label><br/>
					    <label class="control-label">{{trans('main.Nombres del grupo en idiomas activos')}}</label><br/>
					    <?php $x=0; ?>
					    @foreach($langs as $lang)
					        <?php
                                $nameGroupPromo = PromotionGroupName::where('promotionProduct_id', $group->id)->where('language_id', $lang->language_id)->first();
					        ?>
					        @if($nameGroupPromo)
					            @if($lang->main==1)
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}} ({{trans('main.lang')}})</label>
					            <div class="form-group">
					            	<div>
					            		{{ Form::text('name_group_'.$i.'_'.$lang->language->language, $nameGroupPromo->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                        {{ errors_for('name_group_'.$i.'_'.$lang->language->language, $errors) }}
					            	</div>
					            </div>
					            @else
					                @if($lang->state==0 and $x==0)
                                    <label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
                                    <?php $x=1; ?>
                                    @endif
					                <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					                <div class="form-group">
					                	<div>
					                		{{ Form::text('name_group_'.$i.'_'.$lang->language->language, $nameGroupPromo->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                            {{ errors_for('name_group_'.$i.'_'.$lang->language->language, $errors) }}
					                	</div>
					                </div>
					            @endif
					        @else
					            @if($lang->state==0 and $x==0)
                                <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                                <?php $x=1; ?>
                                @endif
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					            <div class="form-group">
					            	<div>
					            		{{ Form::text('name_group_'.$i.'_'.$lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for('name_group_'.$i.'_'.$lang->language->language, $errors) }}
					            	</div>
					            </div>
					        @endif
					    @endforeach
					    <label class="control-label">{{trans('main.productos grupo') .' '.$i}}</label>
					    <div>
					    	{{ Form::text("items_group_".$i, $group->items, ['class' => 'form-control', 'placeholder'=>trans('main.items')]) }}
					    	{{ errors_for("items_group_".$i, $errors) }}
					    </div>
					    <hr style="color: #4E0519" />
					@endfor
					</div>
					<label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
					<?php $x=0; ?>
					@foreach($langs as $lang)
					    <?php
                            $namePromo = PromotionName::where('promotion_id', $promotion->id)->where('language_id', $lang->language_id)->first();
					    ?>
					    @if($namePromo)
					        @if($lang->main==1)
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}} ({{trans('main.lang')}})</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang->language->language, $namePromo->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					        @else
					            @if($lang->state==0 and $x==0)
                                <label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
                                <?php $x=1; ?>
                                @endif
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					            <div class="form-group">
					            	<div>
					            		{{ Form::text($lang->language->language, $namePromo->name, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for($lang->language->language, $errors) }}
					            	</div>
					            </div>
					        @endif
					    @else
					        @if($lang->state==0 and $x==0)
                            <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                            <?php $x=1; ?>
                            @endif
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang->language->language, $errors) }}
					        	</div>
					        </div>
					    @endif
					@endforeach
					<hr style="color: #4E0519" />  

                    <div class="form-group">
                        <label class="control-label">{{trans('main.type of schedule')}}</label>
						<div class="iSwitch flat-switch">
							<div class="switch">
								<input name="type_of_schedule" value="1" type="checkbox" id="type_of_schedule" @if($promotion->type_of_schedule==1) checked @endif>
							</div>
						</div>
                    </div>

                    <div id="schedule" style="@if($promotion->type_of_schedule!=1) display: none; @else display: block; @endif"> 
                        <label class="control-label">{{trans('main.Horario de disponibilidad')}}</label><br/>
                        @foreach($weekdays as $weekday => $value)
                        <?php
                            $available = PromotionAvailable::where('weekday', $weekday)->where('promotion_id', $promotion->id)->first();
                        ?>
                        @if($available)
                        <div class="col-lg-12" style="border-bottom: 1px solid #E4E4E4; margin-bottom: 10px;">
                            <label class="control-label col-lg-12">{{trans('main.'.$value)}}</label>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Desde')}} 1</label>
					        	<div class="form-group">
					        		{{ Form::text('desde_1_'.$value, $available->desde_1, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Desde').' 1', 'autocomplete'=>'off']) }}
                                    {{ errors_for('desde_1_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Hasta')}} 1</label>
					        	<div class="form-group">
					        		{{ Form::text('hasta_1_'.$value, $available->hasta_1, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Hasta').' 1', 'autocomplete'=>'off']) }}
                                    {{ errors_for('hasta_1_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Desde')}} 2</label>
					        	<div class="form-group">
					        		{{ Form::text('desde_2_'.$value, $available->desde_2, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Desde').' 2', 'autocomplete'=>'off']) }}
                                    {{ errors_for('desde_2_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Hasta')}} 2</label>
					        	<div class="form-group">
					        		{{ Form::text('hasta_2_'.$value, $available->hasta_2, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Hasta').' 2', 'autocomplete'=>'off']) }}
                                    {{ errors_for('hasta_2_'.$value, $errors) }}
					        	</div>
					        </div>
					    </div>
					    @else
					    <div class="col-lg-12" style="border-bottom: 1px solid #E4E4E4; margin-bottom: 10px;">
                            <label class="control-label col-lg-12">{{$value}}</label>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Desde')}} 1</label>
					        	<div class="form-group">
					        		{{ Form::text('desde_1_'.$value, NULL, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Desde').' 1', 'autocomplete'=>'off']) }}
                                    {{ errors_for('desde_1_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Hasta')}} 1</label>
					        	<div class="form-group">
					        		{{ Form::text('hasta_1_'.$value, NULL, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Hasta').' 1', 'autocomplete'=>'off']) }}
                                    {{ errors_for('hasta_1_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Desde')}} 2</label>
					        	<div class="form-group">
					        		{{ Form::text('desde_2_'.$value, NULL, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Desde').' 2', 'autocomplete'=>'off']) }}
                                    {{ errors_for('desde_2_'.$value, $errors) }}
					        	</div>
					        </div>
					        <div class="col-lg-3">
					            <label class="control-label">{{trans('main.Hasta')}} 2</label>
					        	<div class="form-group">
					        		{{ Form::text('hasta_2_'.$value, NULL, ['class' => 'form-control timepicker',     'placeholder'=>trans('main.Hasta').' 2', 'autocomplete'=>'off']) }}
                                    {{ errors_for('hasta_2_'.$value, $errors) }}
					        	</div>
					        </div>
					    </div>
					    @endif
                        @endforeach
                    </div>
				{{ Form::close() }}
			</div>
		</section>
		</div>
	</div>
</div>
@stop
@section('js-script')
$('#type_of_schedule').change(function() {
    var $input = $(this);  
    var check = $input.prop( "checked" );
    if(check){
        $('#schedule').css('display', 'block');
    }else{
        $('#schedule').css('display', 'none');
    }
});

$('.selectpicker').selectpicker();

$('.timepicker').timepicker({
    minuteStep: 1,
    template: 'modal',
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});
@stop
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $( "#quantity" ).change(function() {
    	var html = '';
        for (var i=1; i<parseInt($(this).val())+1; i++) {
      	    var x=0;
            html += '<label class="control-label">{{trans('main.Grupo')}} '+i+'</label><br/>'+
		               '<label class="control-label">{{trans('main.Nombres del grupo en idiomas activos')}}</label><br/>';
		    $.each({{$langs}}, function( index, value ) {
		        if(value.main==1){
		            html+= ''+
		                   '    <label class="control-label">{{trans('main.Nombre en')}}'+value.language.language+'({{trans('main.lang')}})</label>'+
		                   '	<div>'+
		                   '		<input class="form-control" placeholder="'+value.language.language+'" autocomplete="off" required="required" name="name_group_'+i+'_'+value.language.language+'" type="text">'+
		                   '	</div>'+
		                   '';
		        }else{
		        	html+='';
                    if(value.state==0 && x==0){
                     html+='    <label class="control-label">{{trans('main.Nombres del grupo en idiomas no activos')}}</label><br/>';
                     x=1;
                    }
		            html+= '    <label class="control-label">{{trans('main.Nombre en')}} {{$lang->language->language}}</label>'+
		                   '	<div>'+
		                   '		<input class="form-control" placeholder="'+value.language.language+'" autocomplete="off" required="required" name="name_group_'+i+'_'+value.language.language+'" type="text">'+
		                   '	</div>'+
		                   '';
		        }
		    });
		    html+= ''+
		           '	<label class="control-label">Productos grupo 1</label>'+
		           '	<div>'+
		           '		<input class="form-control" id="items" placeholder="Productos" name="items_group_'+i+'" type="text">'+
		           '	</div> <hr style="color: #4E0519" /> '+
		           '';   
        } 
        $('#grupos').html(html);
    });
});
</script>
@stop