<?php

class Sms extends Eloquent {

	protected $table = 'addresses';
	public $timestamps = false;

	 

    public static  function send($numbers,$message, $user)
    {   
        if($numbers=="")
            return false;

        $profile = Profile::where('phone', $numbers)->first();
        if(!$profile)
            return false;
        if(!Address::find($profile->address_id) or $profile->address_id==0 or Address::concatAddress($profile->address_id)['city']=="")
            return false;
        
        $country_name = explode(',',Address::concatAddress($profile->address_id)['city'])[0];
        $country = Country::where('name', $country_name)->first();
        $numbers = $country->prefix.$numbers;

        $payment  = PaymentSms::where('user_id', $user)->first();
        if($payment){
        if($payment->sms >=1){
            // Datos de autorización.
            $username = "diegoesteban.serra@gmail.com";
            $hash = "953e4a9599d86cd28f00b130e2ab42e5598fe022";
            // Variables de configuración. Consulta http://api.txtlocal.com/docs para obtener más información.
            $test = "1";
            // Datos para mensaje de texto. Estos son los datos del mensaje de texto.
            $sender = "SmartDoctorApp"; // Esta es la persona a la que parece pertenecer el mensaje.
            // 612 caracteres o menos
            // Un número individual o una lista de números separados por coma
            $message = urlencode($message);
            $data = array("custom"=>Sentry::getUser()->id,"username"=>$username,"hash"=>$hash,"message"=>$message,"sender"=>$sender,"numbers"=>$numbers,"test"=>$test);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://api.txtlocal.com/send/'); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch); // Este es el resultado de la API
            curl_close($ch); 
            
            $parts = explode(':', explode(',', $result)[5])[2];
            $cost  = explode(':', explode(',', $result)[1])[1];

            #$parts = explode(':', explode(',', $result)[5])[2];
            #$cost  = explode(':', explode(',', $result)[1])[1];
    
            $optionAdmin = OptionAdmin::where('code', 'sal_sms')->first();
            $optionAdmin->value = $cost;
            $optionAdmin->save();

            if($parts>=$payment->sms)
                $payment->sms = 0;
            else
                $payment->sms = $payment->sms - $parts;

            $payment->save();
    
            return true;
        }else{
            return false;
        }
        }
    }

    public static function SendNotificacionDelayed($id)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        
        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $hourPart = explode(':',explode(' ', $appo->last_time)[1]);
            if($doctor->clinic_id==0){
                $duser =  User::find($doctor->user_id);
                $dprofile = Profile::where('user_id',$doctor->user_id)->first();
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$appo->day,
                    'centro' => $bdoctor->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                $message = trans('main.please note that the estimated schedule an appointment today in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.is')." ".$data['hours'].". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$appo->day,
                    'centro' => $clinic->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone,
                    'email' => $cuser->email
                    );
                $message = trans('main.please note that the estimated schedule an appointment today in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.is')." ".$data['hours'].". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


               
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationDelayed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }

    public static function SendNotificacionCancel($id)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        
        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $day = new DateTime($appo->day);
            $hourPart = explode(':',explode(' ', $appo->start_date)[1]);
            if($doctor->clinic_id==0){
                $duser =  User::find($doctor->user_id);
                $dprofile = Profile::where('user_id',$doctor->user_id)->first();
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $bdoctor->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                $message = trans('main.Please note that your quotes')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours']." ".trans('main.has been canceled')." ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.sorry for the inconvenience');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }

    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $clinic->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone,
                    'email' => $cuser->email
                    );
                $message = trans('main.Please note that your quotes')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours']." ".trans('main.has been canceled')." ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.sorry for the inconvenience');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }
    
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationCancel',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }

    public static function SendNotificacionNotAcepted($id)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        
        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $day = new DateTime($appo->day);
            $hourPart = explode(':',explode(' ', $appo->start_date)[1]);
            if($doctor->clinic_id==0){
                $duser =  User::find($doctor->user_id);
                $dprofile = Profile::where('user_id',$doctor->user_id)->first();
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $bdoctor->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                $message = trans('main.Please note that your quotes')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours']." ".trans('main.has been rejected')." ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.sorry for the inconvenience');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }

    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $clinic->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone,
                    'email' => $cuser->email
                    );
                $message = trans('main.Please note that your quotes')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours']." ".trans('main.has been rejected')." ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.sorry for the inconvenience');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }
    
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationNoAcepted',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }

    public static function SendNotificacionChangeDate($id, $last_state)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        $date = new DateTime($last_state);

        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $duser =  User::find($doctor->user_id);
            $day = new DateTime($appo->day);
            $hourPart = explode(':',explode(' ', $appo->start_date)[1]);
            $dprofile = Profile::where('user_id',$doctor->user_id)->first();
            if($doctor->clinic_id==0){
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'last_state'=>$date->format('d/m'),
                    'doctor_name' => trans('main.'.$doctor->treatment)." ".$duser->getFullName(),
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                
                $message = trans('main.Please note that your quote of the day')." ".$data['last_state']." ".trans('main.with')." ".$data['doctor_name']."  ".trans('main.has changed the day')." ".$data['day']." ".trans('main.to')." ".$data['hours'].". ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.either confirm or reject the change in our app')." ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }
    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'last_state'=>$date->format('d/m'),
                    'doctor_name' => trans('main.'.$doctor->treatment)." ".$duser->getFullName(),
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone
                    );
                $message = trans('main.Please note that your quote of the day')." ".$data['last_state']." ".trans('main.with')." ".$data['doctor_name']."  ".trans('main.has changed the day')." ".$data['day']." ".trans('main.to')." ".$data['hours'].". ";
                $message = $message.trans('main.you can contact us at')." ".$data['phone']." ".trans('main.either confirm or reject the change in our app')." ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }
                    
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationChangeDate',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }

    public static function SendNotificacion($id, $datasms, $user)
    {
        $patient = Patient::find($id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();

        $subject = trans('main.notice of appointment');
        $centro = Doctor::where('user_id', $user)->first();
        if($centro){
            if($centro->clinic_id==0){
                $user = User::find($user);
                $dprofile = Profile::where('user_id', $user->id)->first();
                $remitente = trans('main.'.$centro->treatment)." ".$user->getFullName();
                $dphone = $dprofile->phone;
            }else{
                $user = User::find($user);
                $doctorname = trans('main.'.$centro->treatment)." ".$user->getFullName();
                $centro = Clinic::find($centro->clinic_id);
                $remitente = $centro->name.", ".$doctorname;
                $dphone = $centro->phone;
            } 
        }else{
            $centro = Clinic::where('user_id', $user)->first();
            if($centro){
                $remitente = $centro->name;
                $dphone = $centro->phone;
            }
        }
        
        $name = $userPatient->getFullName();
        if($patient->main!=0){
           $patientMain = Patient::find($patient->main);
           $userMain = User::find($patientMain->user_id);
           $profileMain = Profile::where('user_id', $userMain->id)->first();
           $email = $userMain->email;
           $phone = $profileMain->phone;
        }else{
          $email = $userPatient->email;
          $phone = $profile->phone;
        }
    
        $data = array(
            'name' => $userPatient->getFullName(),
            'remitente' => $remitente,
            'data' => $datasms,
            'phone' => $dphone
        );
        
        $sms = $data['remitente'].": ".$data['data'].". ".trans('main.you can contact us at')." ".$data['phone'];
    
        if($centro->sms_state==1){
            if($email!="" and (stripos($email, "notuser") == FALSE)){
                Mail::send('email.notifications',  $data, function($message) use ($name, $email, $subject)
                {
                    $message->to($email, $name);
                    $message->subject($subject);
                });
            }
    
            if($phone!=""){
                Sms::send($phone, $sms, $centro->user_id);
            }
        }elseif($centro->sms_state==2){
            if($phone!=""){
                Sms::send($phone, $sms, $centro->user_id);
            }
        }elseif($centro->sms_state==3){
            if($phone!=""){
                Sms::send($phone, $sms, $centro->user_id);
            }else{
                if($email!="" and (stripos($email, "notuser") == FALSE)){
                    Mail::send('email.notifications',  $data, function($message) use ($name, $email, $subject)
                    {
                        $message->to($email, $name);
                        $message->subject($subject);
                    });
                }
            }
        }elseif($centro->sms_state==4){
            if($email!="" and (stripos($email, "notuser") == FALSE)){
                Mail::send('email.notifications',  $data, function($message) use ($name, $email, $subject)
                {
                    $message->to($email, $name);
                    $message->subject($subject);
                });
            }
        }elseif($centro->sms_state==5){
            if($email!="" and (stripos($email, "notuser") == FALSE)){
                Mail::send('email.notifications',  $data, function($message) use ($name, $email, $subject)
                {
                    $message->to($email, $name);
                    $message->subject($subject);
                });
            }else{
                if($phone!=""){
                    Sms::send($phone, $sms, $centro->user_id);
                }
            }
        }
    }

     public static function SendNotificacionConfirmed($id)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        $day = new DateTime($appo->day);
        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $hourPart = explode(':',explode(' ', $appo->start_date)[1]);
            if($doctor->clinic_id==0){
                $duser =  User::find($doctor->user_id);
                $dprofile = Profile::where('user_id',$doctor->user_id)->first();
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $bdoctor->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                $message = trans('main.we will confirm your appointment on')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours'].". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $clinic->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone,
                    'email' => $cuser->email
                    );
                $message = trans('main.we will confirm your appointment on')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours'].". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


               
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmed',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }

    public static function SendNotificacionConfirmedManual($id)
    {
        $appo = Appointment::find($id);
        $patient = Patient::find($appo->patient_id);
        $userPatient = User::find($patient->user_id);
        $profile = Profile::where('user_id',$userPatient->id)->first();
        $day = new DateTime($appo->day);
        $subject = trans('main.notice of appointment');

        $agenda = Agenda::find($appo->agenda_id);
        if($agenda){
            $doctor = Doctor::find($agenda->doctor_id);
            $hourPart = explode(':',explode(' ', $appo->start_date)[1]);
            if($doctor->clinic_id==0){
                $duser =  User::find($doctor->user_id);
                $dprofile = Profile::where('user_id',$doctor->user_id)->first();
                $bdoctor = BusinessDoctor::where('agenda_id', $agenda->id)->first();
                $address = Address::concatAddress($bdoctor->addresses_id)['adrress'];
                $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $bdoctor->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $dprofile->phone,
                    'email' => $duser->email
                    );
                $message = trans('main.we have received your request for quotation')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours'].". ".trans('main.You will receive a confirmation message').". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


    
                if($doctor->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }
                }elseif($doctor->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $doctor->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($doctor->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($doctor->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $doctor->user_id);
                        }
                    }
                }
            }else{
               $clinic = Clinic::find($doctor->clinic_id);
               $cuser =  User::find($clinic->user_id);
               $address = Address::concatAddress($clinic->address_id)['adrress'];
               $data = array(
                    'name' => $userPatient->getFullName(),
                    'day'=>$day->format('d/m'),
                    'centro' => $clinic->name,
                    'address' => $address,
                    'hours' => $hourPart[0].":".$hourPart[1],
                    'phone' => $clinic->phone,
                    'email' => $cuser->email
                    );
                $message = trans('main.we have received your request for quotation')." ".$data['day']." ".trans('main.in')." ".$data['centro'].", ".trans('main.address')." ".$data['address']." ".trans('main.to')." ".$data['hours'].". ".trans('main.You will receive a confirmation message').". ".trans('main.you can contact us at')." ".$data['phone']." ".trans('main.or')." ".$data['email'].". ".trans('main.thank you');
                $name = $userPatient->getFullName();
                if($patient->main!=0){
                   $patientMain = Patient::find($patient->main);
                   $userMain = User::find($patientMain->user_id);
                   $profileMain = Profile::where('user_id', $userMain->id)->first();
                   $email = $userMain->email;
                   $phone = $profileMain->phone;
                }else{
                  $email = $userPatient->email;
                  $phone = $profile->phone;
                }


               
                if($clinic->sms_state==1){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
    
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==2){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }
                }elseif($clinic->sms_state==3){
                    if($phone!=""){
                        Sms::send($phone, $message, $clinic->user_id);
                    }else{
                        if($email!="" and (stripos($email, "notuser") == FALSE)){
                            Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                            {
                                $message->to($email, $name);
                                $message->subject($subject);
                            });
                        }
                    }
                }elseif($clinic->sms_state==4){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }
                }elseif($clinic->sms_state==5){
                    if($email!="" and (stripos($email, "notuser") == FALSE)){
                        Mail::send('email.notificationConfirmedManual',  $data, function($message) use ($name, $email, $subject)
                        {
                            $message->to($email, $name);
                            $message->subject($subject);
                        });
                    }else{
                        if($phone!=""){
                            Sms::send($phone, $message, $clinic->user_id);
                        }
                    }
                }
                    
            }
        }
    }
}