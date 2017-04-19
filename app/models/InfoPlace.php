<?php
class InfoPlace extends Eloquent {

	protected $table = 'info_places';
	public $timestamps = true;

	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$service = InfoPlace::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = InfoPlaceLang::where('language_id', $lang->language_id)->where('info_place_id', $service->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }
}