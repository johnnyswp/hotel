<?php
class Phone extends Eloquent {

	protected $table = 'phones';
	public $timestamps = true;

    public static function phoneState($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$phone = Phone::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = NamePhone::where('language_id', $lang->language_id)->where('phone_id', $phone->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }
}