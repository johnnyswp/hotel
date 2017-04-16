<?php
class Business extends Eloquent {

	protected $table = 'business';
	public $timestamps = true;

    public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$business = Business::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = BusinessLang::where('language_id', $lang->language_id)->where('business_id', $business->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }

    public function service()
    {
        return $this->belongsTo('services');
    }
}