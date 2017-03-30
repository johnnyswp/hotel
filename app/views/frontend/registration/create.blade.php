@extends('master') 

@section('title', trans('main.registro'))

@section('content')
<div id="content">
    <div class="row">
        <style type="text/css">
            #language {
            display: block;
            height: 38px;
            width: 125px;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 999;
        }
        </style>
        <div id="language">         
            {{ Form::open(array('url' =>'/lang', 'class' => 'filters', 'method' => 'GET')) }}
                {{ Form::select('lang',Language::where('state',1)->lists('language', 'sufijo'), Helpers::lang(), array('class' =>             'selectpicker form-control select change-lang')) }}
            {{ Form::close() }}
        </div>
        <div class="col-lg-12">
            <div class="account-wall">
                <section class="align-lg-center">
                    <div class="site-logo" style="  height: 75px; background-size: contain;"></div>
                    <br>
                
                </section>
                <section class="clearfix align-lg-center">
                    <i class="fa fa-sign-in"></i> {{trans('main.return to')}} <a href="{{url()}}">{{trans('main.login')}}</a>
                </section>  
                {{ Form::open(array('route' => 'registration.store','files'=>true,'class'=>'wizard-step shadow','id'=>'validate-wizard')) }} 
                {{ Form::hidden("timezone", NULL, ['id' => 'timezone']) }}
                    <ul class="align-lg-center" style="">
                        <li><a href="#step1" data-toggle="tab">1</a></li>
                        <li><a href="#step2" data-toggle="tab">2</a></li>
                        <li><a href="#step3" data-toggle="tab">3</a></li>
                    </ul>
                    <div class="progress progress-stripes progress-sm" style="margin:0">
                        <div class="progress-bar" data-color="theme"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="step1" parsley-validate parsley-bind> 
                        
                            <div class="form-group">
                               <h3 class="login-title"><span>{{trans('main.personal data')}}</span></h3>
                            </div>
                            <input  type="hidden" name="code" value="{{$code}}">
                            <div class="form-group row">

                               <div class="col-md-12">
                                   <label class="control-label">{{trans('main.first name')}}</label>
                                   {{ Form::text("first_name", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.first name'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                   {{ errors_for('first_name', $errors) }}
                               </div>
                            </div>
            
                            <div class="form-group">
                                <label class="control-label">{{trans('main.last name')}}</label>
                                {{ Form::text("last_name", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.last name'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('last_name', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.position')}}</label>
                                {{ Form::text("position", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.position'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('position', $errors) }}
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">{{trans('main.email')}}</label>
                                {{ Form::text("email", NULL, ['class' => 'form-control', 'parsley-type'=>'email', 'placeholder'=>'john@email.com','autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('email', $errors) }}
                            </div>

                            <div class="form-group">
                                <label class="control-label">{{trans('main.username')}}</label>
                                {{ Form::text("username", NULL, ['class' => 'form-control', 'placeholder'=>'username', 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('username', $errors) }}
                            </div>
                
                            <div class="form-group">
                                <label class="control-label">{{trans('main.fn')}}</label>
                                {{ Form::hidden('birthday', NULL,['id'=>'date'])}}
                                {{ Form::text("fn", NULL, ['class' => 'form-control', 'id'=>'birthday','placeholder'=>trans('main.fn'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.country')}}</label>   
                                {{ Form::select('country_id', $countries, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                                {{ errors_for('country_id', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.phone')}}</label>
                                {{ Form::text("phone", NULL, ['class' => 'form-control', 'placeholder'=>'88888888', 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('phone', $errors) }}
                            </div>                                                                                             
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.password')}}</label>
                                {{ Form::text("password", NULL, ['class' => 'form-control', 'placeholder'=>'6-8 '.trans('main.Characters'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('password', $errors) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{trans('main.password confirmation')}}</label>
                                {{ Form::text("password_confirmation", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.password confirmation'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                            </div>
                        </div>
        
                        <div class="tab-pane fade" id="step2" parsley-validate parsley-bind>
                            <h3 class="login-title"><span>{{trans('main.hotel data')}}</span></h3><br>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.hotel name')}}</label>
                                {{ Form::text("hotel_name", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.hotel name'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('hotel_name', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.country')}}</label>
                                                                                             
                                {{ Form::select('country', $countries, null, ['class' => 'form-control selectpicker', 'data-size'=>'10', 'data-live-search'=>'true', 'autocomplete'=>'off']) }}
                                {{ errors_for('country', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.city')}}</label>
                                <div>
                                    {{ Form::text("city", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.city'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                    {{ errors_for('city', $errors) }}
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.address')}}</label>
                                {{ Form::text("address_hotel", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.address'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('address_hotel', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.email publico')}}</label>
                                {{ Form::text("infoemail", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.infoemail site'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('infoemail', $errors) }}
                            </div>

                            <div class="form-group">
                                <label class="control-label">{{trans('main.web site')}}</label>
                                {{ Form::text("web", NULL, ['class' => 'form-control', 'placeholder'=>trans('main.web site'), 'autocomplete'=>'off', 'oncopy'=>'return false', 'ondrag'=>'return false', 'ondrop'=>'return false', 'onpaste'=>'return false',]) }}
                                {{ errors_for('web', $errors) }}
                            </div>
        
                            <div class="form-group">
                                <label class="control-label">{{trans('main.lang')}}</label>
                                {{ Form::select('lang', $langs, NULL, ['class' => 'selectpicker form-control'])}}
                                {{ errors_for('lang', $errors) }}
                            </div>
                            
                            <div class="form-group">
    			    			<label class="control-label">{{trans('main.divisa de precios')}}</label>
    			    			<div>
                                    {{ Form::select('exchange_id', $divisas, NULL, ['class' => 'selectpicker form-control'])}}
                                    {{ errors_for('exchange_id', $errors) }}
    			    			</div>
    			    		</div>
        
                            <div class="form-group">
    			    			<label class="control-label">{{trans('main.logo')}}</label><br>
    			    			<div>
    			    				<div class="fileinput fileinput-exists" data-provides="fileinput">
    			    					<input type="hidden" value="" name="">
    			    					<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
    			    						<img src="{{url('assets/img/no-image.png')}}" />
    			    					</div>
    			    				<div>
    			    					<span class="btn btn-default btn-file">
    			    						<span class="fileinput-new">{{trans('main.select image')}}</span><span class="fileinput-exists">{{trans('main.change')}}</span>
    			    						<input type="file" name="logo" accept="image/*">
    			    					</span>
    			    				<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('main.delete')}}</a>
    			    				</div>
    			    			</div>
    			    			<br>
        
    			    			<span class="label label-danger ">{{trans('main.note')}}</span>
    			    			<span>{{trans('main.you must select single files of')}}</span>
    			    			</div>
                                {{ errors_for('logo', $errors) }}
    			    		</div>
                       
        
                            <div class="form-group">
                                <br>
                                {{trans('main.When registering you are accepting')}} <a style="color: #0F00FF; font-weight: 400;" href="http://easyroomservice.com/index.php/es/terminos-condiciones">{{trans('main.Terms and Conditions and Privacy Policy')}}</a>. {{trans('main.Please read them carefully')}}
                            </div>
                            
                        </div>
        
                        <div class="tab-pane fade align-lg-center" id="step3">
                            <div id="block-mgs" style="display: none;">
                                <br><h2>{{trans('main.Thank you for your registration')}} <span></span> ...</h2><br>
                                <p id="mgs">{{trans('main.An email has been sent to')}} <b></b> {{trans('main.with details on how to activate your account (if you do not receive it in your inbox, look in the mailbox of spam or Spam)')}}.</p> 
                            </div>
                            <div  id="load" style="  display: block; width: 145px; margin: 0 auto;">
                                <p>{{trans('main.Information Processing')}}</p>
                            </div>
                        </div>
        
                        <footer class="row">
                            <div class="col-sm-12">
                                <section class="wizard">
                                    <button type="button"  class="btn  btn-default previous pull-left"> <i class="fa fa-chevron-left"></i></button>
                                    <button type="button"  class="btn btn-theme next pull-right">{{trans('main.next')}} </button>
                                </section>
                            </div>
                        </footer>
                    </div>
                {{ Form::close() }}
                <section class="clearfix align-lg-center">
                    <i class="fa fa-sign-in"></i> {{trans('main.return to')}} <a href="{{url()}}">{{trans('main.login')}}</a>
                </section>  
            </div>
        </div>  
    <!-- //col-sm-6 col-md-4 col-md-offset-4-->
    </div>
</div>
@stop

