<?php
class Service extends Eloquent {

	protected $table = 'services';
	public $timestamps = true;

	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$service = Service::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = ServiceLang::where('language_id', $lang->language_id)->where('service_id', $service->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }
}