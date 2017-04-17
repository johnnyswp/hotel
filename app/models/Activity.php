<?php
class Activity extends Eloquent {

	protected $table = 'activity';
	public $timestamps = true;

	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$activity = Activity::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = ActivityLang::where('language_id', $lang->language_id)->where('activity_id', $activity->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }
}