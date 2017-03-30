<?php

class AdminController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getHome()
	{
		return View::make('admin.dashboard.index');
	}

	public function getConfig()
	{
		$options = OptionAdmin::get();
		return View::make('admin.dashboard.options')->with('options', $options);
	}

	public function getConfigEdit($id)
	{
         $option = OptionAdmin::find($id);
         return View::make('admin.dashboard.edit')->with('option', $option);
	}

	public function postConfigUpdate($id)
	{
		$data = array(
		 	//data person          
	        "value" =>  Input::get("value")                
	    );
	
		$rules = array(
	        'value' => 'required',
	    );
        

        $messages = array(
	        'required'  => 'El campo :attribute es obligatorio.'
         );
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::to('admin/configuration/'.$id.'/edit')->withErrors($validation)->withInput();
        }else{
            $option = OptionAdmin::find($id);
            $option->value = Input::get("value");
            $option->save();

            return Redirect::to('admin/configuration')->with('flash_message', 'Guardado con Exito');
        }
	}

	public function getComfirmationSms()
	{
         $userPaymentSms = UserPaymentSms::where('state', 0)->get();
         return View::make('admin.dashboard.confirmSms')->with('userPaymentSms', $userPaymentSms);
	}

    public function getComfirmationPayment()
    {
         $userPayments = Userpayment::where('state', 0)->get();
         return View::make('admin.dashboard.SendBills')->with('userPayments', $userPayments);
    }

	public function getComfirmationPaymentSave($id)
    {
        $userPayment = Userpayment::find($id);
        $userPayment->state = 1;
        $userPayment->save();
        return Redirect::to('admin/confirmation-payment/')->with('flash_message', 'Guardado con Exito');
    }

    public function getComfirmationSmsSave($id)
	{
        $userPaymentSms = UserPaymentSms::find($id);

        $user_id = $userPaymentSms->user_id;

        $payment = PaymentSms::where('user_id', $user_id)->first();
        if(!$payment){
            $payment = new PaymentSms;
            $payment->sms = $userPaymentSms->sms;
            $payment->user_id = $user_id;
            $payment->plan_id = $userPaymentSms->plan_id;
            $payment->price = $userPaymentSms->price;
            $payment->save();
        }else{
            $payment->sms = $payment->sms+$userPaymentSms->sms;
            $payment->plan_id = $userPaymentSms->plan_id;
            $payment->price = $userPaymentSms->price;
            $payment->save();
        }
        $userPaymentSms->state = 1;
        $userPaymentSms->save();
        return Redirect::to('admin/refills-confirmation-sms/')->with('flash_message', 'Guardado con Exito');
	}

	public function getComfirmationSmsAllSave()
	{
        $userPaymentSmss = UserPaymentSms::where('state', 0)->get();
        foreach ($userPaymentSmss as $userPaymentSms) {
        	$userPaymentSms->state = 1;
            $userPaymentSms->save();
 
            $user_id = $userPaymentSms->user_id;
 
            $payment = PaymentSms::where('user_id', $user_id)->first();
            if(!$payment){
                $payment = new PaymentSms;
                $payment->sms = $userPaymentSms->sms;
                $payment->user_id = $user_id;
                $payment->plan_id = $userPaymentSms->plan_id;
                $payment->price = $userPaymentSms->price;
                $payment->save();
            }else{
                $payment->sms = $payment->sms+$userPaymentSms->sms;
                $payment->plan_id = $userPaymentSms->plan_id;
                $payment->price = $userPaymentSms->price;
                $payment->save();
            }
        }
         return Redirect::to('admin/refills-confirmation-sms/')->with('flash_message', 'Guardado con Exito');
	}
}