<?php
use Carbon\Carbon;
class Payment extends Eloquent {

	protected $table = 'payment';
	public $timestamps = true;

	public static function VeryPaymentMessage()
    {
        if($user = Sentry::getUser()){
            if($user->type_user==0 or $user->type_user==1 or $user->type_user==2){
                    return true;
            }
            $dt = Carbon::now();
            $payment = Payment::where('user_id', $user->id)->where('paid', 1)->first();
            if($payment){
                $create =  Carbon::parse($payment->updated_at)->addDays($payment->time)->toDateString();
                $dt = $dt->addDays(15)->toDateString();
                if($create > $dt)
                   return true;
                else
                   return false;
            }else{
               return false; 
            }
        }
        return true;
    }


    public static function DisabledPayment()
    {
        if($user = Sentry::getUser()){
            if($user->type_user==0 or $user->type_user==1 or $user->type_user==2){
                    return true;
            }
            $dt = Carbon::now();
            $payment = Payment::where('user_id', $user->id)->where('paid', 1)->first();
            if($payment){
                $create =  Carbon::parse($payment->updated_at)->addDays($payment->time)->toDateString();
                $dt = $dt->toDateString();
                if($create > $dt)
                   return true;
                else
                   return false;
            }else{
               return false; 
            }
        }
        return true;
    }

    public static function PaymentsDate()
    {
        if($user = Sentry::getUser()){
            $payment = Payment::where('user_id', $user->id)->where('paid', 1)->first();
            if($payment){
                $caducidad =  Carbon::parse($payment->updated_at)->addDays($payment->time)->toDateString();
                return $caducidad;
            }else{
               return false; 
            }
        }
    }

    public static function chancePayment($price)
    {
        if($user = Sentry::getUser()){
            $payment = Payment::where('user_id', $user->id)->first();
            $plan = Plan::find($payment->plan_id);
            $create =  Carbon::parse($payment->updated_at);
            $caducidad = $create->addDays($payment->time);
            $dt = Carbon::now();
            return round(($price - $plan->price) / 365 * ($dt->diffInDays($caducidad)), 2, PHP_ROUND_HALF_UP);
        }
    }
}