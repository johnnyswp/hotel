<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminPlansController extends \BaseController {
    ///////////////////hotel PLANS///////////////////////////////////
    public function getSms()
    {
        $hotel = Hotel::find(Input::get('hotel_id'));
        $payment = PaymentSms::where('user_id', $hotel->user_id)->first();
        if(!$payment){
            $payment = new PaymentSms;
            $payment->user_id = $hotel->user_id;
        }

        if(Input::get('plan_id')!=""){
            $plan = PlanSms::find(Input::get('plan_id'));
            if($plan){
                $payment->plan_id = $plan->id;
                $payment->price   = Input::get('Price');
                $payment->sms     =  $payment->sms + $plan->sms;

                $userpayment = new UserPaymentSms;
                $userpayment->sms = $plan->sms;
                $userpayment->user_id = $hotel->user_id;
                $userpayment->plan_id = $plan->id;
                $userpayment->price   = Input::get('Price');
                $userpayment->save();
            }
        }else{
            $payment->plan_id = "";
            $payment->price   = Input::get('Price');
            $payment->sms     = $payment->sms+Input::get('sms');

            $userpayment = new UserPaymentSms;
            $userpayment->sms     = Input::get('sms');
            $userpayment->user_id = $hotel->user_id;
            $userpayment->price = Input::get('Price');
            $userpayment->save();
        }
          
        $payment->save();

        return Redirect::back();
    } 

    public function getPlan()
    {
        $data = array(
            //data person
            "end"      =>  Input::get("end"),            
            "plan_id"      =>  Input::get("plan_id"),                 
        );
    
        $rules = array(
            'end'      => 'required',
            'plan_id'      => 'required',

        );
        
        $messages = array(
            'required'  => 'El campo :attribute es obligatorio.'
         );
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{

        $hotel = Hotel::find(Input::get('hotel_id'));
        
        $dtNow = Carbon::now();
        $dtCad = Carbon::parse(Input::get('end'));
        $days = $dtCad->diffInDays($dtNow)+1;
        $plan = Plan::find(Input::get('plan_id'));
        $payment = Payment::where('user_id', $hotel->user_id)->first();
        $payment->time = $days;
        $payment->plan_id = Input::get('plan_id');
        $payment->price = Input::get('Price');
        $payment->paid  = 1;
        $payment->save();

        $userpayment = new Userpayment;
        $userpayment->user_id = $hotel->user_id;
        $userpayment->plan_id = Input::get('plan_id');
        $userpayment->time    = $days;
        $userpayment->paid    = 1;
        $userpayment->price   = Input::get('Price');
        $userpayment->save();

        return Redirect::back();
        }
        
    }

    public function getHistory($id)
    {   

        $hotel = Hotel::find($id);
        $user    = User::find($hotel->user_id);
        $payment  = PaymentSms::where('user_id', $user->id)->first();
        $plansmss = PlanSms::orderBy('price', 'ASC')->get();
        if($payment){
           $plan = PlanSms::find($payment->plan_id);
           $payms = UserPaymentSms::where('user_id', $user->id)->orderby('id','desc')->paginate(10);
           return View::make('admin.hotel.HistorySms')->with('plansmss', $plansmss)->with('hotel', $hotel)->with('plan', $plan)->with('user', $user)->with('payms', $payms)->with('payment', $payment); 
        }else{
           return View::make('admin.hotel.HistorySms')->with('plansmss', $plansmss)->with('hotel', $hotel);
        }
    }

    public function getHistoryPlan($id)
    {   
        $hotel = Hotel::find($id);
        $user    = User::find($hotel->user_id);
        $payment  = Payment::where('user_id', $user->id)->first();
        if($payment){
           $plans = Plan::orderBy('price', 'ASC')->get();
           $plan = Plan::find($payment->plan_id);
           $payms = Userpayment::where('user_id', $user->id)->orderby('id','desc')->paginate(10);
           return View::make('admin.hotel.HistoryPlans')->with('plans', $plans)->with('hotel', $hotel)->with('plan', $plan)->with('user', $user)->with('payms', $payms)->with('payment', $payment); 
        }else{
           return View::make('admin.hotel.HistoryPlans')->with('hotel', $hotel);
        }
    }
}  