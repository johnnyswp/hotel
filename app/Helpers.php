<?php 
use Carbon\Carbon;
class Helpers
{	

	public static function lang()
	{
		$lang_c=Cookie::get('language');	   
		$retVal = (is_null($lang_c)) ? Config::get('app.locale') : Cookie::get('language');
		return $retVal;
	}

    public static function dataLang(){
       return explode(',', Option::find(46)->value);
    }


	public static function date_iso86($date)
    {
        $datetime = new DateTime($date);
        $date_min =  $datetime->format(DateTime::ISO8601);     
        return $date_min;
    }

    public static function date_mysql($date)
    {        
        $dt = Carbon::parse($date);       
        return $dt->toDateString();
    }

    public static function datetime_mysql($date)
    {        
        $dt = Carbon::parse($date);       
        return $dt->toDateTimeString();
    }

    public static function date_bd($date)
    {
        list($y,$m,$d)=explode('-',$date);
        $dt = Carbon::create($y,$m,$d,0,0,0);       
        return $dt->format('d-m-Y');
    }

	public static function hora_min($hora)
	{
		list($h,$m,$s)=explode(':',$hora);
			
		return $h.":".$m;
	}
	
	public static function token($text,$length=5)
	{
    	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$a =  substr(str_shuffle(str_repeat($pool, 5)), 0, 20);
            $b =  substr( $a.str_random(10), 0, $length);
    	return  strtoupper($b);
	}

    public static function cToken($token)
    {        
        return hash('sha256',$token);            
    }

    public static function LangHotel($hotel_id)
    {        
        $lang_activos = LanguageHotel::where('hotel_id',$hotel_id)->where('state',1)->orderBy('main','DESC')->get();
        return $lang_activos;
    }

    public static function typeU()
    {       
        $user = Sentry::getUser(); 
        $type = $user->type_user;
        return $type;
    }

	 
}