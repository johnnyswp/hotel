<?php
use Carbon\Carbon;
class ReceptionistSaveController extends \BaseController {


	/**
	 * Display a listing of the resource.	 
	 * @return Response
	 */
	public function getIndex()
	{
		return Redirect::to('/');
	}

	/**
	 * Save Receptionist
	 * @return Response
	 */
	public function postCheckIn()
	{
	    #Verficiar si exite este email alguna estadia con estado pendiente
		$email = Input::get('email');
		
		$hotel_id = Input::get('hotel_id');

		$hotel = Hotel::find($hotel_id);
		
		$user = Sentry::getUser();
		
		$stay_ = Stay::where('email',$email)->where('hotel_id',$hotel_id)->where('state','Pending')->first();
		
		if($stay_){
	    	Session::flash('message', trans('main.Existe una estadia con este email').$email.trans('main.con estado Pendiente.'));
			#return Redirect::back();
			return Redirect::back()->withInput();
		}

		$habitacion = Room::where(['id'=>Input::get('habitacion'),'condition'=>0,'state'=>1,'hotel_id'=>$user->hotel_id])->first();
        if(!$habitacion){
        	Session::flash('message', trans('main.la habitacion').Input::get('habitacion').trans('main.no esta disponle.'));
			#return Redirect::back();
			return Redirect::back()->withInput();
        }

		$rules = [
					'nombre'       => 'required',				
					'contrasena'   => 'required|min:5',
					'habitacion'   => 'required',
					'entrada_dia'  => 'required',
					'entrada_hora' => 'required',
					'salida_dia'   => 'required',
					'salida_hora'  => 'required',					
					'idioma'       => 'required',
	    ];

		$r_email = 1;
		$r_sms = 0;

		if($r_email){
			$rules['email'] = 'required|email';
			$r_email =1;
		}else{
			$r_email =0;

		}

		if($r_sms){
			$rules['telefono'] = 'required';
			$r_sms=1;
		}else{
			$r_sms=0;

		}
		$uname = Input::get('username');

		$stt = Stay::where('username',$uname)->where('state','Pending')->first();

		if($hotel->type_login==1 && $stt){
           	$rules['username'] = 'required|min:1|max:50|unique:stays';
		}
		
	    $inputs = [
					'email'        => Input::get('email'),
					'username'     => Input::get('username'),
					'name'         => Input::get('nombre'),
					'token'        => Input::get('contrasena'),			
					'room_id'      => Input::get('habitacion'),			
					'opening_date' => Input::get('entrada_dia'),			
					'start'        => Input::get('entrada_hora'),			
					'closing_date' => Input::get('salida_dia'),			
					'end'          => Input::get('salida_hora'),			
					'phone'        => Input::get('telefono'),			
					'language_id'  => Input::get('idioma'),
					'state'	       => 'Pending',
					'report_email' => Input::get('report_email'),
					'report_sms'   => Input::get('report_sms'),
	    ];
	     
	    $validator = Validator::make(Input::all(), $rules);

	    if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
        	
			 
        	$token = Helpers::cToken(Input::get('contrasena'));

        	#Guardar Estadia
			$stay               = new Stay;
			$stay->email        = Input::get('email');
			if($hotel->type_login==1){
			$stay->username     = Input::get('username');
			}
			$stay->type_login   = Input::get('type_login');
			$stay->name         = Input::get('nombre');
			$stay->room_id      = Input::get('habitacion');		
			$stay->opening_date = Helpers::date_mysql(Input::get('entrada_dia'));	
			$stay->start        = Input::get('entrada_hora');	
			$stay->closing_date = Helpers::date_mysql(Input::get('salida_dia'));		
			$stay->end          = Input::get('salida_hora');	
			$stay->phone        = Input::get('telefono');		
			$stay->language_id  = Input::get('idioma');
			$stay->state	    = 'Pending';
			$stay->report_email = $r_email;
			$stay->report_sms   = $r_sms;
			$stay->hotel_id = $user->hotel_id;
			$stay->token   = Input::get('contrasena');
			$stay->finished_token   = Carbon::parse(Input::get('salida_dia')." ".Input::get('salida_hora'));
	    	$stay->save();

	    	$habitacion = Room::find(Input::get('habitacion'));
	    	$habitacion->condition=1;
	    	$habitacion->save();

	    	$token=$token."-".$stay->id."?lang=".$stay->language_id;
	    	if($stay){
	    		Session::flash('message', trans('main.Estadia Guarda Exitosamente'));
                
                $hotel = Hotel::find($hotel_id);
	    		$subject = $hotel->name.' - '.trans('main.msg activate');
		        $name  = $stay->name;
		        $email = $stay->email;
		        
		        $data = array(
		           'id'   => $stay->id,
		           'name' => $stay->name,
		           'token' =>  $token,
		           'logo' =>  $hotel->logo,
		           'hotel_name' =>  $hotel->name
		        );
		        
		        $lang_new = Language::find($stay->language_id)->sufijo;
    			$lang_now = Config::get('app.locale');   
			    
    			App::setLocale($lang_new);
    			
    			if($hotel->type_login!=1){
	    		    Mail::send('emails.activation',  $data, function($message) use ($name, $email, $subject)
		            {
		                $message->to($email, $name);
		                $message->subject($subject);
		            });
		        }
		        App::setLocale($lang_now); 
	    		
	    		 
		    	Session::flash('message', trans('main.Su Estadia a sido guardada exitosamente.'));
				#return Redirect::back();
				return Redirect::to('receptionist/stays');
			 


	    	}else{
	    		Session::flash('message', trans('main.Error al guardar la estadia'));
	    		return  Redirect::to('/');
	    	}

	    }

		return [];		

	}
	public function anyUpdateCheckIn()
	{
	    #Verficiar si exite este email alguna estadia con estado pendiente
		
		$email = Input::get('email');
		$id_room = Input::get('habitacion');
		
		$hotel_id = Input::get('hotel_id');
		$hotel = Hotel::find($hotel_id);
		$stay_ = Stay::where('email',$email)->where('state','Pending')->first();
		
		if($stay_){
			if($email==$stay_->email){

			}else{
				Session::flash('message', trans('main.Existe una estadia con este email').$email.trans('main.con estado Pendiente.'));
				#return Redirect::back();
				return Redirect::back()->withInput();	
			}

			if($id_room==$stay_->room_id){

			}else{
				$habitacion = Room::find(Input::get('habitacion'));
	    		$habitacion->condition=0;
	    		$habitacion->save();
			}
   	
		}

		$rules = [
					'name'       => 'required',				
					'habitacion'      => 'required',
					'opening_date'  => 'required',
					'start' => 'required',
					'closing_date'   => 'required',
					'end'  => 'required',	
					'token'  => 'required'

	    ];

		$r_email = 1;
		$r_sms = 0;

		if($r_email){
			$rules['email'] = 'required|email';
			$r_email =1;
		}else{
			$r_email =0;

		}

		if($r_sms){
			$rules['phone'] = 'required';
			$r_sms=1;
		}else{
			$r_sms=0;

		}

		if($hotel->type_login==1){
			$stay               =  Stay::find(Input::get('id'));
			if($stay){
				$rules['username'] = 'required|min:1|max:50|unique:stays,username,'.$stay->id;
			}
            
		}
		
	    
	    $validator = Validator::make(Input::all(), $rules);
	    
	    
	    if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
        	$token = Helpers::cToken(Input::get('token'));
        	#Guardar Estadia
			$stay               =  Stay::find(Input::get('id'));
			$stay->email        = Input::get('email');
			if($hotel->type_login==1){
			$stay->username     = Input::get('username');
			}
			$stay->name         = Input::get('name');
			$stay->room_id      = Input::get('habitacion');		
			$stay->opening_date = Helpers::date_mysql(Input::get('opening_date'));	
			$stay->start        = Input::get('start');	
			$stay->closing_date = Helpers::date_mysql(Input::get('closing_date'));		
			$stay->end          = Input::get('end');	
			$stay->phone        = Input::get('phone');		
			$stay->language_id  = Input::get('idioma');
			$stay->state	    = 'Pending';
			$stay->report_email = $r_email;
			$stay->report_sms   = $r_sms;
			$stay->token   = Input::get('token');
			$stay->finished_token   = Carbon::parse(Input::get('closing_date')." ".Input::get('end'));
	    	$stay->save();
	    	
	    	$habitacion = Room::find(Input::get('habitacion'));
	    	$habitacion->condition=1;
	    	$habitacion->save();
	    	$token=$token."-".$stay->id."?lang=".$stay->language_id;


	    	if($stay){
	    		Session::flash('message', trans('main.Estadia Guarda Exitosamente'));

	    		$subject = $hotel->name.' - '.trans('main.msg activate');
		        $name  = $stay->name;
		        $email = $stay->email;
		        $hotel = Hotel::find($hotel_id);
		        $data = array(
		           'id'   => $stay->id,
		           'name' => $stay->name,
		           'token' =>  $token,
		           'logo' =>  $hotel->logo,
		           'hotel_name' =>  $hotel->name
		        );

		        $lang_new = Language::find($stay->language_id)->sufijo;
    			$lang_now = Config::get('app.locale');   
			    
    			App::setLocale($lang_new);
    			if($hotel->type_login!=1){
	    		    Mail::send('emails.activation',  $data, function($message) use ($name, $email, $subject)
		            {
		                $message->to($email, $name);
		                $message->subject($subject);
		            });
		        }
		        App::setLocale($lang_now); 


	    		return  Redirect::to('receptionist/stays');


	    	}else{
	    		Session::flash('message', trans('main.Error al guardar la estadia'));
	    		return  Redirect::to('/');
	    	}

	    }

		return [];		

	}



}
 