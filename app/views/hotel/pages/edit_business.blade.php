@extends('hotel.master') 

@section('title', trans('main.panel de control'))

@section('content')
<div id="content">
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<section class="panel">
			<header class="panel-heading sm" data-color="theme-inverse">
				<h2><strong> {{trans('main.Editar')}}</strong>  {{trans('main.business')}}</h2>
				@if (Session::has('flash_message'))
                <label class="color" style="color: white;background-color: rgba(0, 204, 23, 0.29);">{{ Session::get('flash_message') }}</label>
                @endif
			</header>
			<div class="panel-body">
				{{ Form::model($business, ['files' => 'true', 'method' => 'PATCH', 'route' => ['hotel.business.update', $business->id]]) }}
					
					<div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label">{{trans('main.service')}}</label>
                        <div>
                            {{ Form::select('service_id', $services, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                            {{ errors_for('service_id', $errors) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{trans('main.phone')}}</label>
                        <div>
                            {{ Form::text('phone', null, ['class' => 'form-control', 'autocomplete'=>'off']) }}
                            {{ errors_for('phone', $errors) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{trans('main.horarios')}}</label>
                        <div>
                            <div class="col-md-6" style='padding-left: 0px;'>{{ Form::text('since', null, ['class' => 'form-control timepicker', 'autocomplete'=>'off', 'placeholder'=>trans('main.since')]) }}
                            {{ errors_for('since', $errors) }}</div>

                            <div class="col-md-6"  style='padding-right: 0px;'>{{ Form::text('until', null, ['class' => 'form-control timepicker', 'autocomplete'=>'off', 'placeholder'=>trans('main.until')]) }}
                            {{ errors_for('until', $errors) }}</div>
                            
                        </div>
                    </div>


					<div class="form-group">
						<label class="control-label">{{trans('main.select a Picture')}}</label><br>
						<div>
							<div class="fileinput fileinput-exists" data-provides="fileinput">
								<input type="hidden" value="" name="">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
									<img src="{{$business->picture}}" />
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

					<label class="control-label">{{trans('main.Nombre en idiomas activos')}}</label><br/>
					<?php $x=0; ?>
					@foreach($langs as $lang_)
					    <?php
                            $businessLang = BusinessLang::where('business_id', $business->id)->where('language_id', $lang_->language_id)->first();
					    ?>
					    @if($businessLang)
					        @if($lang_->main==1)
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang_->language->language}} ({{trans('main.lang')}})</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang_->language->language, $businessLang->name, ['class' => 'form-control', 'placeholder'=>$lang_->language->language, 'autocomplete'=>'off', 'required'=>'required']) }}
                                    {{ errors_for($lang_->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::textarea('descrption_'.$lang_->language->language, $businessLang->description, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang_->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('descrption_'.$lang_->language->language, $errors) }}
					        	</div>
					        </div>
					        @else
					            @if($lang_->state==0 and $x==0)
                                <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                                <?php $x=1; ?>
                                @endif
					            <label class="control-label">{{trans('main.Nombre en')}} {{$lang_->language->language}}</label>
					            <div class="form-group">
					            	<div>
					            		{{ Form::text($lang_->language->language, $businessLang->name, ['class' => 'form-control', 'placeholder'=>$lang_->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for($lang_->language->language, $errors) }}
					            	</div>
					            </div>
					            <div class="form-group">
					            	<div>
					            		{{ Form::textarea('descrption_'.$lang_->language->language, $businessLang->description, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang_->language->language, 'autocomplete'=>'off']) }}
                                        {{ errors_for('descrption_'.$lang_->language->language, $errors) }}
					            	</div>
					            </div>
					        @endif
					    @else
					        @if($lang_->state==0 and $x==0)
                            <label class="control-label">{{trans('main.Nombre en idiomas no activos')}}</label><br/>
                            <?php $x=1; ?>
                            @endif
					        <label class="control-label">{{trans('main.Nombre en')}} {{$lang_->language->language}}</label>
					        <div class="form-group">
					        	<div>
					        		{{ Form::text($lang_->language->language, NULL, ['class' => 'form-control', 'placeholder'=>$lang_->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for($lang_->language->language, $errors) }}
					        	</div>
					        </div>
					        <div class="form-group">
					        	<div>
					        		{{ Form::textarea('descrption_'.$lang_->language->language, NULL, ['class' => 'form-control', 'style'=>'height: 75px;','placeholder'=>trans('main.descrpcion en').' '.$lang_->language->language, 'autocomplete'=>'off']) }}
                                    {{ errors_for('descrption_'.$lang_->language->language, $errors) }}
					        	</div>
					        </div>
					    @endif
					@endforeach

                    <div class="form-group offset">
						<div>
							{{ Form::submit(trans('main.save'), ['class' => 'btn btn-primary']) }}
                            {{ Form::reset(trans('main.cancel'), ['class' => 'btn btn-default']) }}
						</div>
					</div>

				{{ Form::close() }}
			</div>
		</section>
		</div>

	</div>
	
</div>
@stop

@section('js-script')

$('.timepicker').timepicker({
    minuteStep: 1,
    template: 'modal',
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});
@stop